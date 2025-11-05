<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Modules\SysAdmin\DataTables\SliderDataTable;
use Modules\SysAdmin\Interfaces\SliderInterface;
use Modules\SysAdmin\Interfaces\SliderItemInterface;
use Modules\SysAdmin\Requests\SliderFormRequest;

class SliderController extends Controller
{
    public function __construct(
        protected SliderInterface $sliderRepository,
        protected SliderItemInterface $sliderItemRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sysadmin::slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->sliderRepository->saveOrUpdate($validatedData);
        return redirect()->route('sysadmin.slider.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $page = $this->sliderRepository->findOrFail($id)->toArray();
        return view('sysadmin::slider.view')->with([
            'page' => $page,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $block = $this->sliderRepository->findOrFail($id);
        return view('sysadmin::slider.edit', compact('block'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderFormRequest $request, $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $page = $this->sliderRepository->saveOrUpdate($validatedData, $id);
        return redirect()->route('sysadmin.slider.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->sliderRepository->delete($id);
        return redirect()->route('sysadmin.slider.index');
    }
}
