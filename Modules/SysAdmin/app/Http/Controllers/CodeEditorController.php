<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CodeEditorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sysadmin::code-editor.robot');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:65535'],
        ]);
        $content = str_replace(["\r\n", "\r"], "\n", trim($validated['content']));
        File::replace(public_path('robots.txt'), $content."\n");

        return redirect()->route('sysadmin.media.code.robot')->with('success', 'robots.txt saved.');
    }
}
