<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\SysAdmin\Models\Settings;
use Modules\SysAdmin\DataTables\SettingsDataTable;
use Modules\SysAdmin\Interfaces\SettingInterface;
use Modules\SysAdmin\Requests\SettingsFormRequest;

class SettingsController extends Controller
{
    public function __construct(
        protected SettingInterface $settingRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SettingsDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::settings.custom');
    }

    /**
     * Show the form for load ajax form .
     */
    public function ajaxForm(Request $request)
    {
        $id = $request->get('id', 0);
        // Fetch data from database or other source
        $setting = [];
        if ($id !== 0) {
            $setting = $this->settingRepository->findOrFail($id)->toArray();
        }
        // Replace with your logic
        // Generate HTML for the modal content
        $modalContent = view('sysadmin::settings.form')->with([
            'id' => $id,
            'types' => Settings::$types,
            'setting' => $setting
        ])->render();
        return response()->json($modalContent);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sysadmin::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function ajaxStore(SettingsFormRequest $request)
    {
        $id = request()->get('id', 0);
        try {
            $validatedData = $request->validated();
            $this->settingRepository->saveOrUpdate($validatedData, $id);
            return redirect()->route('sysadmin.settings.index');
        } catch (ValidationException $e) {
            dd($e->validator->errors());
            return back()->withErrors($e->validator->errors());
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('sysadmin.settings.index');
    }

    /**
     * Show the specified resource.
     */
    public function ajaxShow($id)
    {
        $data = $this->settingRepository->findOrFail($id)->toArray();
        $modalContent = view('sysadmin::settings.ajax-view', compact('data'))->render();
        return response()->json($modalContent);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $user = $this->settingRepository->findOrFail($id)->toArray();
        return view('sysadmin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('sysadmin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return redirect()->route('sysadmin.settings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->settingRepository->delete($id);
        return redirect()->route('sysadmin.settings.index');
    }
}
