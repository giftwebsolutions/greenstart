<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\SysAdmin\DataTables\ProductDataTable;
use Modules\SysAdmin\Interfaces\ProductInterface;
use Modules\SysAdmin\Requests\ProductFormRequest;

class ProductController extends Controller
{
    public function __construct(
        protected ProductInterface $productRepository
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
        return view('sysadmin::catalog.product.create', [
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
        // Normalize checkbox values
        $validated = $request->validated();
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['slider']      = $request->boolean('slider');

        $this->productRepository->saveOrUpdate($validated);

        return redirect()
            ->route('sysadmin.catalog.product.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Edit Product
     */
    public function edit(int $id)
    {
        $product = $this->productRepository->find($id);

        return view('sysadmin::catalog.product.edit', [
            'product'       => $product,
            'statuses'      => $this->productRepository->getStatuses(),
            'categories'    => $this->productRepository->getCategories(),
            'subCategories' => $this->productRepository->getSubCategories(),
        ]);
    }

    /**
     * Update Product
     */
    public function update(ProductFormRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['slider']      = $request->boolean('slider');

        $this->productRepository->saveOrUpdate($validated, $id);

        return redirect()
            ->route('sysadmin.catalog.product.index')
            ->with('success', 'Product updated successfully.');
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
}
