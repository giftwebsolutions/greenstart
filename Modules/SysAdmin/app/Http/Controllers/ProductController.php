<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Modules\SysAdmin\Interfaces\ProductInterface;
use Modules\SysAdmin\Interfaces\ProductVariantInterface;
use Modules\SysAdmin\Interfaces\ProductConfigurableAttributeInterface;
use Modules\SysAdmin\Requests\ProductFormRequest;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Models\AttributeGroup;
use Modules\SysAdmin\DataTables\ProductDataTable;
use Modules\SysAdmin\Interfaces\ProductAttributeValueInterface;
use Modules\SysAdmin\Repository\AttributeRepository;
use Modules\SysAdmin\Repository\ProductCategoryRepository;
use Modules\SysAdmin\Models\ProductImage;

class ProductController extends Controller
{
    public function __construct(
        protected ProductInterface $productRepository,
        protected ProductVariantInterface $variantRepository,
        protected ProductConfigurableAttributeInterface $configAttrRepository,
        protected ProductAttributeValueInterface    $productAttributeValueRepository,
        protected AttributeRepository $attributeRepository,
        protected ProductCategoryRepository $categoryRepository
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

            unset($validated['attributes'], $validated['configurable_attributes'], $validated['variants']);

            //unset($validated['type']);

            /** @var Product $product */
            $product = $this->productRepository->saveOrUpdate($validated);

            // attribute_set_id
            if ($request->filled('attribute_set_id')) {
                $product->attribute_set_id = (int) $request->input('attribute_set_id');
            }
            //$product->type = $this->determineProductTypeFromAttributeSet($product->attribute_set_id);
            $product->save();

            if ($request->hasFile('gallery_images')) {
                $this->productRepository->syncGallery($product, $request->file('gallery_images'), false);
            }

            return redirect()
                ->route('sysadmin.catalog.product.attributes', $product->id)
                ->with('success', 'Product saved. Now fill attributes & variants.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        }
    }

    private function determineProductTypeFromAttributeSet(?int $attributeSetId): int
    {
        if (empty($attributeSetId) || (int) $attributeSetId <= 0) {
            return 1; // Simple
        }

        $hasConfigurable = AttributeGroup::query()
            ->where('id', (int) $attributeSetId)
            ->whereHas('attributes', function ($q) {
                $q->where('configurable', 1)
                    ->where('type', 2); // dropdown
            })
            ->exists();

        return $hasConfigurable ? 2 : 1;
    }

    public function attributes(int $productId)
    {
        $product = $this->productRepository->find($productId);
        //dd($product);
        if (!$product) abort(404);

        if (!$product->attribute_set_id) {
            return redirect()
                ->route('sysadmin.catalog.product.edit', $product->id)
                ->with('error', 'Please select an Attribute Set for this product first.');
        }

        /** @var AttributeGroup $group */
        $group = AttributeGroup::with(['attributes.values'])
            ->findOrFail($product->attribute_set_id);

        //  Product-level attribute values only (product_id = product.id)
        $productAttributeValues = $this->productAttributeValueRepository
            ->findWhere(['product_id' => $product->id])
            ->keyBy('attribute_id');

        //  Existing configurable attributes for this product
        $existingConfigurable = $this->configAttrRepository
            ->findWhere(['product_id' => $product->id])
            ->pluck('attribute_id')
            ->toArray();

        // Variant attributes (dropdown + configurable)
        $variantAttributes = $group->attributes->filter(function ($attr) {
            return (int)$attr->configurable === 1 && (int)$attr->type === 2;
        });

        //  Existing variants with their values
        // Use Eloquent/Repo method that REALLY eager loads `values`
        $existingVariants = $this->variantRepository->with(['values'])
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
        $product = $this->productRepository->find($productId);
        if (!$product) abort(404);

        $attributes             = $request->input('attributes', []);
        $configurableAttributes = $request->input('configurable_attributes', []);
        $variantsData           = $request->input('variants', []);

        if (!$product->attribute_set_id) {
            return redirect()
                ->route('sysadmin.catalog.product.edit', $product->id)
                ->with('error', 'Please select an Attribute Set first.');
        }

        $group = AttributeGroup::with(['attributes.values'])->findOrFail($product->attribute_set_id);
        $attributeMeta = $group->attributes->keyBy('id');

        /* ============================================================
     * 1) Product-level attributes
     * ============================================================ */
        $this->productAttributeValueRepository->deleteWhere(['product_id' => $product->id]);

        foreach ($attributes as $attributeId => $rawValue) {
            if ($rawValue === null || $rawValue === '') continue;

            $attributeId  = (int)$attributeId;
            $attributeDef = $attributeMeta->get($attributeId);
            if (!$attributeDef) continue;

            $data = [
                'product_id'   => $product->id,
                'attribute_id' => $attributeId,
            ];

            if ((int)$attributeDef->type === 3) {
                $data['attribute_value_id'] = (int)$rawValue;
                $data['value'] = null;
            } else {
                $data['attribute_value_id'] = null;
                $data['value'] = is_array($rawValue) ? json_encode($rawValue) : $rawValue;
            }

            $this->productAttributeValueRepository->create($data);
        }

        /* ============================================================
     * 2) Configurable attributes
     * ============================================================ */
        $this->configAttrRepository->deleteWhere(['product_id' => $product->id]);

        $configurableAttributes = is_array($configurableAttributes)
            ? array_values(array_filter(array_map('intval', $configurableAttributes)))
            : [];

        foreach ($configurableAttributes as $attributeId) {
            $this->configAttrRepository->create([
                'product_id'   => $product->id,
                'attribute_id' => $attributeId,
            ]);
        }

        /* ============================================================
     * 3) Filter variants WITHOUT reindexing (IMPORTANT for file upload)
     * ============================================================ */
        $variantsData = is_array($variantsData) ? $variantsData : [];

        $filteredVariants = [];
        foreach ($variantsData as $key => $row) {
            $name = trim((string)($row['name'] ?? ''));
            $sku  = trim((string)($row['sku'] ?? ''));

            $attrs = $row['attributes'] ?? [];
            $hasAttrs = is_array($attrs) && count(array_filter($attrs, fn($v) => $v !== null && $v !== '')) > 0;

            // valid row
            if ($name !== '' || $sku !== '' || $hasAttrs) {
                $filteredVariants[$key] = $row; // ✅ keep original key
            }
        }

        $product->type = count($filteredVariants) > 0 ? 2 : 1;
        $product->save();

        if ((int)$product->type === 2 && empty($filteredVariants)) {
            return redirect()
                ->route('sysadmin.catalog.product.attributes', $product->id)
                ->with('error', 'Please add at least one variant.');
        }

        /* ============================================================
     * 4) UPSERT variants + image upload
     * ============================================================ */
        $keptVariantIds = [];

        foreach ($filteredVariants as $key => $row) {

            $variantId = isset($row['id']) ? (int)$row['id'] : 0;

            $existingVariant = null;
            if ($variantId > 0) {
                $existingVariant = $this->variantRepository->find($variantId);
                if (!$existingVariant || (int)$existingVariant->product_id !== (int)$product->id) {
                    $existingVariant = null;
                    $variantId = 0;
                }
            }

            // thumb defaults to existing on update
            $thumb = $existingVariant ? $existingVariant->thumb : null;

            // remove thumb only if remove_thumb=1
            $removeThumb = isset($row['remove_thumb']) && (int)$row['remove_thumb'] === 1;
            if ($existingVariant && $removeThumb) {
                $thumb = null;
            }

            //  file upload must use ORIGINAL KEY
            if ($request->hasFile("variants.$key.thumb")) {
                $thumb = \Modules\SysAdmin\Helpers\ImageUploader::upload(
                    $request->file("variants.$key.thumb"),
                    $product->created_at
                );
            }

            // upsert variant
            if ($existingVariant) {
                $this->variantRepository->update([
                    'name'   => $row['name'] ?? null,
                    'sku'    => $row['sku'] ?? null,
                    'price'  => $row['price'] ?? 0,
                    'thumb'  => $thumb,
                    'stock'  => $row['stock'] ?? 0,
                    'status' => $row['status'] ?? 1,
                ], $existingVariant->id);

                $variantId = (int)$existingVariant->id;
            } else {
                $variant = $this->variantRepository->create([
                    'product_id' => $product->id,
                    'name'       => $row['name'] ?? null,
                    'sku'        => $row['sku'] ?? null,
                    'price'      => $row['price'] ?? 0,
                    'thumb'      => $thumb,
                    'stock'      => $row['stock'] ?? 0,
                    'status'     => $row['status'] ?? 1,
                ]);

                $variantId = (int)$variant->id;
            }

            $keptVariantIds[] = $variantId;

            // replace variant attribute values (your schema: product_id = variant_id)
            $this->productAttributeValueRepository->deleteWhere(['product_id' => $variantId]);

            if (!empty($row['attributes']) && is_array($row['attributes'])) {
                foreach ($row['attributes'] as $attributeId => $attributeValueId) {
                    if (!$attributeValueId) continue;

                    $this->productAttributeValueRepository->create([
                        'product_id'         => $variantId,
                        'attribute_id'       => (int)$attributeId,
                        'attribute_value_id' => (int)$attributeValueId,
                        'value'              => null,
                    ]);
                }
            }
        }

        /* ============================================================
     * 5) AUTO DELETE removed variants (this makes “row removed” delete DB)
     * ============================================================ */
        $existingIds = $this->variantRepository
            ->where('product_id', $product->id)
            ->pluck('id')
            ->toArray();

        $toDelete = array_diff($existingIds, $keptVariantIds);

        if (!empty($toDelete)) {
            foreach ($toDelete as $delId) {
                $delId = (int) $delId;

                // delete variant values first (product_id = variant_id)
                $this->productAttributeValueRepository->deleteWhere(['product_id' => $delId]);

                // delete variant (repo-safe)
                $this->variantRepository->deleteWhere([
                    'id'         => $delId,
                    'product_id' => $product->id,
                ]);
            }
        }

        return redirect()
            ->route('sysadmin.catalog.product.attributes', $product->id)
            ->with('success', 'Attributes & variants saved successfully.');
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
        //dd($product);
        $attributeSets = $this->attributeRepository->getAttributeSets();

        $galleryImages = ProductImage::where('product_id', $product->id)
            ->orderBy('sort_order')
            ->get();

        //dd($attributeSets);

        return view('sysadmin::catalog.product.edit', [
            'product'       => $product,
            'statuses'      => $this->productRepository->getStatuses(),
            'categories'    => $this->productRepository->getCategories() ?? [],
            'subCategories' => $this->productRepository->getSubCategories($product->product_category) ?? [],
            'attributeSets' => $attributeSets,
            'galleryImages' => $galleryImages
        ]);
    }

    /**
     * Update Product
     */
    public function update(ProductFormRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();
        //dd($validated);
        // do not touch attributes / variants here
        unset($validated['attributes'], $validated['configurable_attributes'], $validated['variants']);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['slider']      = $request->boolean('slider');

        /** @var Product $product */
        $product = $this->productRepository->saveOrUpdate($validated, $id);

        // Keep attribute set in sync
        if ($request->filled('attribute_set_id')) {
            $product->attribute_set_id = (int) $request->input('attribute_set_id');
        }

        // IMPORTANT: re-determine product type
        //$product->type = $this->determineProductTypeFromAttributeSet($product->attribute_set_id);
        $product->save();

        // Gallery update
        if ($request->hasFile('gallery_images')) {
            $this->productRepository->syncGallery(
                $product,
                $request->file('gallery_images'),
                true // edit mode
            );
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
