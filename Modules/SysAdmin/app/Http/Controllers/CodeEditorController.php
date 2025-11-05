<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CodeEditorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Example file path
        $filePath = base_path('.env');

        // Read file content
        $content = file_get_contents($filePath);

        return view('sysadmin::code-editor.robot', compact('content'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Example file path
        $filePath = base_path('.env');

        // Save content to file
        file_put_contents($filePath, $request->input('content'));

        return redirect()->route('sysadmin.code.robot')->with('success', 'File saved successfully!');
    }

     
}
