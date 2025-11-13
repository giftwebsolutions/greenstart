<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\SysAdmin\DataTables\ProductCategoryDataTable;
use Modules\SysAdmin\Interfaces\ProductCategoryInterface;
use Modules\SysAdmin\Requests\ProductFormRequest;

class ProductCategoryController extends Controller
{
    public function __construct(
        protected ProductCategoryInterface $productRepository
    ) {}

    /**
     * Display Product Category Listing (DataTable)
     */
    public function index(ProductCategoryDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::catalog.productcategory.index');
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('sysadmin::catalog.productcategory.create', [
            'statuses'      => $this->productRepository->getStatuses(),
            'categories'    => $this->productRepository->getCategories(),
            'subCategories' => $this->productRepository->getSubCategories(),
        ]);
    }

    /**
     * Store new product category
     */
    public function store(ProductFormRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->productRepository->saveOrUpdate($validated);

        return redirect()
            ->route('sysadmin.catalog.productcategory.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Edit product category
     */
    public function edit(int $id)
    {
        $category = $this->productRepository->find($id);

        return view('sysadmin::catalog.productcategory.edit', [
            'category'      => $category,
            'statuses'      => $this->productRepository->getStatuses(),
            'categories'    => $this->productRepository->getCategories(),
            'subCategories' => $this->productRepository->getSubCategories(),
        ]);
    }

    /**
     * Update product category
     */
    public function update(ProductFormRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();
        $this->productRepository->saveOrUpdate($validated, $id);

        return redirect()
            ->route('sysadmin.catalog.productcategory.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Delete product category
     */
    public function destroy(int $id): RedirectResponse
    {
        $category = $this->productRepository->find($id);
        $category->delete();

        return redirect()
            ->route('sysadmin.catalog.productcategory.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Show single category details
     */
    public function show(int $id)
    {
        $category = $this->productRepository->find($id);

        return view('sysadmin::catalog.productcategory.view', [
            'category' => $category,
            'status'   => $category->status_label ?? null,
            'parent'   => $category->parent ?? null,
        ]);
    }
}
