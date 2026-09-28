<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Modules\SysAdmin\Interfaces\EnquiryInterface;
use Modules\SysAdmin\Models\Enquiry;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Models\ProductCategory;
use Modules\SysAdmin\Requests\EnquiryFormRequest;

class EnquiryController extends Controller
{
    public function __construct(
        protected EnquiryInterface $enquiryRepository
    ) {}

    /**
     * Enquiry listing
     */
    public function index()
    {
        return view('sysadmin::enquiry.index');
    }

    /**
     * Create enquiry page
     */
    public function create()
    {
        return view('sysadmin::enquiry.create', $this->formOptions());
    }

    /**
     * Store enquiry
     */
    public function store(EnquiryFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $enquiry = $this->enquiryRepository->saveOrUpdate($validatedData);

        return redirect()->route('sysadmin.enquiry.view', $enquiry->id)->with('success', 'Enquiry created.');
    }

    /**
     * View enquiry
     */
    public function show($id)
    {
        $enquiry = $this->enquiryRepository->findOrFail($id);

        return view('sysadmin::enquiry.view', compact('enquiry'));
    }

    /**
     * Edit enquiry
     */
    public function edit($id)
    {
        $enquiry = $this->enquiryRepository
            ->with(['category', 'product'])
            ->findOrFail($id);

        return view('sysadmin::enquiry.edit', ['enquiry' => $enquiry, ...$this->formOptions()]);
    }

    /**
     * Update enquiry
     */
    public function update(EnquiryFormRequest $request, $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->enquiryRepository->saveOrUpdate($validatedData, $id);

        return redirect()->route('sysadmin.enquiry.view', $id)->with('success', 'Enquiry updated.');
    }

    /**
     * Delete enquiry
     */
    public function destroy($id): RedirectResponse
    {
        $this->enquiryRepository->delete($id);

        return redirect()->route('sysadmin.enquiry.index');
    }

    public function appointments()
    {
        return view('sysadmin::enquiry.appointments.index');
    }

    private function formOptions(): array
    {
        return [
            'statuses' => $this->enquiryRepository->getStatuses(),
            'priorities' => Enquiry::$priorities,
            'categories' => ProductCategory::query()->orderBy('name')->pluck('name', 'id'),
            'products' => Product::query()->orderBy('title')->get(['id', 'title', 'product_category']),
            'users' => User::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']),
        ];
    }
}
