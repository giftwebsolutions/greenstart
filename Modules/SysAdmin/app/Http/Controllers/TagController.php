<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\SysAdmin\DataTables\TagDataTable;
use Modules\SysAdmin\Interfaces\TagInterface;
use Modules\SysAdmin\Requests\TagFormRequest;

class TagController extends Controller
{
    public function __construct(
        protected TagInterface $tagRepository
    ) {}

    /**
     * Search tags for Select2 AJAX.
     */
    public function search(Request $request): JsonResponse
    {
        $term = $request->get('term', '');
        $tags = $this->tagRepository->getModel()
            ->where('name', 'like', "%{$term}%")
            ->get(['id', 'name']);

        $data = $tags->map(fn($tag) => ['id' => $tag->id, 'text' => $tag->name])->values()->toArray();

        return response()->json(['items' => $data]);
    }

    /**
     * Display a listing of tags.
     */
    public function index(TagDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::tags.index');
    }

    /**
     * Show the form for creating a new tag.
     */
    public function create()
    {
        return view('sysadmin::tags.create');
    }

    /**
     * Store a newly created tag.
     */
    public function store(TagFormRequest $request): RedirectResponse
    {
        $this->tagRepository->saveOrUpdate($request->validated());
        return redirect()->route('sysadmin.blog.tags.index')->with('success', 'Tag created successfully.');
    }

    /**
     * Show the specified tag.
     */
    public function show($id)
    {
        $tag = $this->tagRepository->findOrFail($id)->toArray();
        return view('sysadmin::tags.view', compact('tag'));
    }

    /**
     * Show the form for editing the specified tag.
     */
    public function edit($id)
    {
        $tag = $this->tagRepository->findOrFail($id);
        return view('sysadmin::tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag.
     */
    public function update(TagFormRequest $request, $id): RedirectResponse
    {
        $this->tagRepository->saveOrUpdate($request->validated(), $id);
        return redirect()->route('sysadmin.blog.tags.index')->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified tag.
     */
    public function destroy($id): RedirectResponse
    {
        $this->tagRepository->delete($id);
        return redirect()->route('sysadmin.blog.tags.index')->with('success', 'Tag deleted successfully.');
    }
}
