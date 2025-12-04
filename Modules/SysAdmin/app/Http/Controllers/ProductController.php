<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

use Modules\SysAdmin\Interfaces\ProductInterface;
use Modules\SysAdmin\Interfaces\ProductVariantInterface;
use Modules\SysAdmin\Interfaces\ProductConfigurableAttributeInterface;
use Modules\SysAdmin\Requests\ProductFormRequest;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Models\AttributeGroup;
use Modules\SysAdmin\Models\ProductVariant;
use Modules\SysAdmin\Models\ProductVariantValue;
use Modules\SysAdmin\DataTables\ProductDataTable;
use Modules\SysAdmin\Interfaces\ProductVariantValueInterface;
use Modules\SysAdmin\Repository\AttributeRepository;
use Modules\SysAdmin\Repository\ProductCategoryRepository;
class ProductController extends Controller
{
    public function __construct(
        protected ProductInterface $productRepository,
        protected ProductVariantInterface $variantRepository,
        protected ProductConfigurableAttributeInterface $configAttrRepository,
        protected ProductVariantValueInterface    $productAttributeValueRepository,
        protected AttributeRepository $attributeRepository,
        protected ProductCategoryRepository $categoryRepository,
    ) {}

    /**
     * Display Product Listing (DataTable)
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::catalog.product.index');
    }

    /**
     * Show create form
     */
    public function create()
    {
        $attributeSets = app(\Modules\SysAdmin\Repository\AttributeRepository::class)
            ->getAttributeSets();

        return view('sysadmin::catalog.product.create', [
            'attributeSets' => $attributeSets,
            'statuses'      => $this->productRepository->getStatuses(),
            'categories'    => $this->productRepository->getCategories(),
            'subCategories' => $this->productRepository->getSubCategories(),
        ]);
    }

    /**
     * Store new product
     */
    public function store(ProductFormRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();

            // Step 1 only saves basic product fields, not attributes
            unset($validated['attributes'], $validated['configurable_attributes']);

            /** @var Product $product */
            $product = $this->productRepository->saveOrUpdate($validated);

            if ($request->filled('attribute_set_id')) {
                $product->attribute_set_id = (int) $request->input('attribute_set_id');
                $product->save(); // this is still via Eloquent object returned by repo
            }

            return redirect()
                ->route('sysadmin.catalog.product.attributes', $product->id)
                ->with('success', 'Product basic details saved. Now fill attributes.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        }
    }

    public function attributes(int $productId)
    {
        // Product via repository
        $product = $this->productRepository->find($productId);

        if (! $product) {
            abort(404);
        }

        if (! $product->attribute_set_id) {
            return redirect()
                ->route('sysadmin.catalog.product.edit', $product->id)
                ->with('error', 'Please select an Attribute Set for this product first.');
        }

    // Load attribute group (family)
        /** @var AttributeGroup $group */
        $group = AttributeGroup::with(['attributes.values'])
            ->findOrFail($product->attribute_set_id);

        // Product attribute values (EAV) via repository
        $productAttributeValues = $this->productAttributeValueRepository
            ->findWhere(['product_id' => $product->id])
            ->keyBy('attribute_id');

        // Existing configurable attributes for this product
        $existingConfigurable = $this->configAttrRepository
            ->findWhere(['product_id' => $product->id])
            ->pluck('attribute_id')
            ->toArray();

        // Attributes that can be used as variant options: configurable=1 and type=3 (dropdown)
        $variantAttributes = $group->attributes->filter(function ($attr) {
            return (int)$attr->configurable === 1 && (int)$attr->type === 3;
        });

        // Existing variants (if editing), including their values
        $existingVariants = $this->variantRepository
            ->with(['values'])  // assumes relation `values` on ProductVariant
            ->findWhere(['product_id' => $product->id]);

        return view('sysadmin::catalog.product.attributes', [
            'product'                => $product,
            'group'                  => $group,
            'productAttributeValues' => $productAttributeValues,
            'existingConfigurable'   => $existingConfigurable,
            'variantAttributes'      => $variantAttributes,
            'existingVariants'       => $existingVariants,
        ]);
    }


    // already in your code

    public function storeAttributes(Request $request, int $productId): RedirectResponse
    {
        // Product via repository
        $product = $this->productRepository->find($productId);

        if (! $product) {
            abort(404);
        }

        $attributes             = $request->input('attributes', []);
        $configurableAttributes = $request->input('configurable_attributes', []);
        $variantsData           = $request->input('variants', []);

        /**
         * 1) Load attribute meta (to know type for each attribute)
         */
        if (! $product->attribute_set_id) {
            return redirect()
                ->route('sysadmin.catalog.product.edit', $product->id)
                ->with('error', 'Please select an Attribute Set before saving attributes.');
        }

        /** @var AttributeGroup $group */
        $group = AttributeGroup::with('attributes')
            ->findOrFail($product->attribute_set_id);

        $attributeMeta = $group->attributes->keyBy('id');

        /**
         * 2) Clear old product attribute values (EAV)
         */
        $this->productAttributeValueRepository->deleteWhere([
            'product_id' => $product->id,
        ]);

        /**
         * 3) Save product attributes:
         *    - type 2 (text)  → value column
         *    - type 3 (dropdown) → attribute_value_id column
         */
        foreach ($attributes as $attributeId => $rawValue) {
            if ($rawValue === null || $rawValue === '') {
                continue;
            }

            $attributeId  = (int) $attributeId;
            $attributeDef = $attributeMeta->get($attributeId);

            if (! $attributeDef) {
                continue;
            }

            $data = [
                'product_id'   => $product->id,
                'attribute_id' => $attributeId,
            ];

            if ((int) $attributeDef->type === 3) {
                // DROPDOWN → selected value id to attribute_value_id
                $data['attribute_value_id'] = (int) $rawValue;
                $data['value']              = null;
            } else {
                // TEXT (type 2 or anything else) → plain text to value
                $data['attribute_value_id'] = null;
                $data['value']              = is_array($rawValue) ? json_encode($rawValue) : $rawValue;
            }

            $this->productAttributeValueRepository->create($data);
        }

        /**
         * 4) Save configurable attributes (for variants)
         */
        $this->configAttrRepository->deleteWhere(['product_id' => $product->id]);

        if (is_array($configurableAttributes)) {
            foreach ($configurableAttributes as $attributeId) {
                $attributeId = (int) $attributeId;
                if ($attributeId <= 0) {
                    continue;
                }

                $this->configAttrRepository->create([
                    'product_id'   => $product->id,
                    'attribute_id' => $attributeId,
                ]);
            }
        }

        /**
         * 5) If variable product, save variants on the SAME submit
         */

        // Clear old variants
        $this->variantRepository->deleteWhere(['product_id' => $product->id]);

        foreach ($variantsData as $row) {

            // Create variant via repository
            $variant = $this->variantRepository->create([
                'product_id' => $product->id,
                'name'       => $row['name'] ?? null,
                'sku'        => $row['sku'] ?? null,
                'price'      => $row['price'] ?? 0,
                'thumb'      => $row['thumb'] ?? null, // handle file upload later if needed
                'stock'      => $row['stock'] ?? 0,
                'status'     => $row['status'] ?? 1,
            ]);

            //dd($variant);

            // Variant attribute values (Color, Size, etc.)
            if (! empty($row['attributes']) && is_array($row['attributes'])) {
                foreach ($row['attributes'] as $attributeId => $attributeValueId) {
                    if (! $attributeValueId) {
                        continue;
                    }

                    ProductVariantValue::create([
                        // ⚠ see note below about schema
                        'product_id'        => $product->id,
                        'attribute_id'      => (int) $attributeId,
                        'attribute_value_id' => (int) $attributeValueId,
                        'value'             => null,
                    ]);
                }
            }
        }


        return redirect()
            ->route('sysadmin.catalog.product.attributes', $product->id)
            ->with('success', 'Product attributes and variants saved successfully.');
    }

    /**
     * AJAX: load attributes for a given attribute set (group).
     * route: sysadmin.catalog.product.load-attributes
     */
    public function loadAttributeSetAttributes(Request $request)
    {
        $groupId = (int) $request->input('attribute_set_id');

        /** @var AttributeGroup $group */
        $group = AttributeGroup::with(['attributes.values'])
            ->findOrFail($groupId);

        $data = $group->attributes->map(function ($attr) {
            return [
                'id'          => $attr->id,
                'name'        => $attr->name,
                'type'        => $attr->type,
                'configurable' => (bool) $attr->configurable,
                'values'      => $attr->values->map(function ($v) {
                    return [
                        'id'    => $v->id,
                        'value' => $v->value,
                    ];
                })->toArray(),
            ];
        })->toArray();

        return response()->json([
            'status'     => 'ok',
            'attributes' => $data,
        ]);
    }


    /**
     * Edit Product
     */
    public function edit(int $id)
    {
        $product = $this->productRepository->find($id);

        $attributeSets = $this->attributeRepository->getAttributeSets();

        return view('sysadmin::catalog.product.edit', [
            'product'       => $product,
            'statuses'      => $this->productRepository->getStatuses(),
            'categories'    => $this->productRepository->getCategories(),
            'subCategories' => $this->productRepository->getSubCategories($product->product_category),
            'attributeSets' => $attributeSets,
        ]);
    }

    /**
     * Update Product
     */
    public function update(ProductFormRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();

        // step 1 does not touch attributes / configurable / variants
        unset($validated['attributes'], $validated['configurable_attributes']);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['slider']      = $request->boolean('slider');

        /** @var Product $product */
        $product = $this->productRepository->saveOrUpdate($validated, $id);

        // keep attribute_set_id in sync
        if ($request->filled('attribute_set_id')) {
            $product->attribute_set_id = (int)$request->input('attribute_set_id');
            $product->save();
        }

        return redirect()
            ->route('sysadmin.catalog.product.edit', $product->id)
            ->with('success', 'Product updated. You can manage attributes & variants from this page.');
    }

    /**
     * Delete Product
     */
    public function destroy(int $id): RedirectResponse
    {
        $product = $this->productRepository->find($id);
        $product->delete();

        return redirect()
            ->route('sysadmin.catalog.product.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * View single product details
     */
    public function show(int $id)
    {
        $product = $this->productRepository->find($id);

        return view('sysadmin::catalog.product.view', [
            'product'  => $product,
            'status'   => $product->status_label ?? null,
            'category' => $product->category ?? null,
            'subCategory' => $product->subCategory ?? null,
        ]);
    }

    /**
     * Return sub categories for given parent category (AJAX)
     */
    public function subCategories(Request $request)
    {
        $parentId = (int) $request->get('parent_id', 0);

        if (! $parentId) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Invalid parent category',
            ], 422);
        }

        // You’ll create this method in the repository (see below)
        $subCategories = $this->categoryRepository->getSubCategories($parentId);

        return response()->json([
            'success' => true,
            // Expecting array: [id => name, id2 => name2, ...]
            'data'    => $subCategories,
        ]);
    }
}
