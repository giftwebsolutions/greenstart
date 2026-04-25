<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Modules\SysAdmin\DataTables\SliderDataTable;
use Modules\SysAdmin\Interfaces\SliderInterface;
use Modules\SysAdmin\Interfaces\SliderItemInterface;
use Modules\SysAdmin\Requests\SliderFormRequest;
use Modules\SysAdmin\Requests\SliderItemFormRequest;
use Modules\SysAdmin\Helpers\ImageUploader;

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
    public function slideritemcreate()
    {
        return view('sysadmin::slider.view');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        //dd($validatedData);
        $this->sliderRepository->saveOrUpdate($validatedData);
        return redirect()->route('sysadmin.slider.index');
    }
    public function slideritemstore(SliderItemFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->sliderItemRepository->saveOrUpdate($validatedData);
        return redirect()->route('sysadmin.slider.view');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $slider = $this->sliderRepository->with('sliderItems')->findOrFail($id)->toArray();
        //dd($slider);
        return view('sysadmin::slider.view')->with([
            'slider' => $slider
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $slider = $this->sliderRepository->findOrFail($id);
        return view('sysadmin::slider.edit', compact('slider'));
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
    public function itemCreate(SliderItemFormRequest $request, $id): RedirectResponse
    {
        //dd($request);
        $validatedData = $request->validated();
        $this->sliderItemRepository->save($validatedData);

        return redirect()->route('sysadmin.slider.view', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $slider = $this->sliderRepository->where('id', $id)->with('sliderItems')->first();

        if ($slider) {

            foreach ($slider->sliderItems as $item) {
                ImageUploader::remove($item->created_at, $item->file);
            }
            $this->sliderItemRepository->where('slider_id', $slider->id)->delete();
            if ($slider->thumbnail) {
                ImageUploader::remove($slider->created_at, $slider->thumbnail);
            }
            $slider->delete();
        }

        return redirect()->route('sysadmin.slider.index');
    }

    public function itemDelete($id)
    {
        $item = $this->sliderItemRepository->where('id', $id)->first();
        if ($item) {
            ImageUploader::remove($item->created_at, $item->file);
            $item->delete();
        }
        return redirect()->route('sysadmin.slider.view', $item->slider_id);
    }
}
