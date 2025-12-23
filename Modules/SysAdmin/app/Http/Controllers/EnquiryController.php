<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Modules\SysAdmin\Interfaces\EnquiryInterface;
use Modules\SysAdmin\DataTables\EnquiryDataTable;
use Modules\SysAdmin\Requests\EnquiryFormRequest;

class EnquiryController extends Controller
{
    public function __construct(
        protected EnquiryInterface $enquiryRepository
    ) {}

    /**
     * Enquiry listing
     */
    public function index(EnquiryDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::enquiry.index');
    }

    /**
     * Create enquiry page
     */
    public function create()
    {
        return view('sysadmin::enquiry.create')->with([
            'statuses' => $this->enquiryRepository->getStatuses(),
        ]);
    }

    /**
     * Store enquiry
     */
    public function store(EnquiryFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $this->enquiryRepository->saveOrUpdate($validatedData);

        return redirect()->route('sysadmin.enquiry.index');
    }

    /**
     * View enquiry
     */
    public function show($id)
    {
        try {
            $enquiry = $this->enquiryRepository
                ->with(['category', 'product'])
                ->findOrFail($id);

            return view('sysadmin::enquiry.view')->with([
                'enquiry' => $enquiry,
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        }
    }

    /**
     * Edit enquiry
     */
    public function edit($id)
    {
        $enquiry = $this->enquiryRepository
            ->with(['category', 'product'])
            ->findOrFail($id);

        return view('sysadmin::enquiry.edit')->with([
            'enquiry'  => $enquiry,
            'statuses' => $this->enquiryRepository->getStatuses(),
        ]);
    }

    /**
     * Update enquiry
     */
    public function update(EnquiryFormRequest $request, $id): RedirectResponse
    {
        try {
            $validatedData = $request->validated();

            $this->enquiryRepository->saveOrUpdate($validatedData, $id);

            return redirect()->route('sysadmin.enquiry.index');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        }
    }

    /**
     * Delete enquiry
     */
    public function destroy($id): RedirectResponse
    {
        $this->enquiryRepository->delete($id);

        return redirect()->route('sysadmin.enquiry.index');
    }
}
