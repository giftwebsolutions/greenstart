<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\SysAdmin\DataTables\TestimonialDataTable;
use Modules\SysAdmin\Interfaces\TestimonialInterface;
use Modules\SysAdmin\Requests\TestimonialFormRequest;

class TestimonialController extends Controller
{
    protected TestimonialInterface $testimonialRepository;

    public function __construct(TestimonialInterface $testimonialRepository)
    {
        $this->testimonialRepository = $testimonialRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TestimonialDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::testimonial.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sysadmin::testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->testimonialRepository->saveOrUpdate($validatedData);
        return redirect()->route('sysadmin.testimonial.index')
                         ->with('success', 'Testimonial created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $testimonial = $this->testimonialRepository->findOrFail($id);
        return view('sysadmin::testimonial.view', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $testimonial = $this->testimonialRepository->findOrFail($id);
        return view('sysadmin::testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TestimonialFormRequest $request, $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->testimonialRepository->saveOrUpdate($validatedData, $id);
        return redirect()->route('sysadmin.testimonial.index')
                         ->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $this->testimonialRepository->delete($id);
        return redirect()->route('sysadmin.testimonial.index')
                         ->with('success', 'Testimonial deleted successfully.');
    }
}
