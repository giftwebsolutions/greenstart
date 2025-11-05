<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Modules\SysAdmin\DataTables\GalleryDataTable;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Interfaces\GalleryInterface;
use Modules\SysAdmin\Interfaces\GalleryItemInterface;
use Modules\SysAdmin\Requests\GalleryFormRequest;
use Illuminate\Http\Request;
use DateTime;

class GalleryController extends Controller
{
    public function __construct(
        protected GalleryInterface $galleryRepository,
        protected GalleryItemInterface $galleryItemRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(GalleryDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::gallery.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sysadmin::gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $result = $this->galleryRepository->saveOrUpdate($validatedData);
        return redirect()->route('sysadmin.gallery.view', $result->id);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $items = [];
        $images = [];
        $gallery = $this->galleryRepository->findOrFail($id)->toArray();
        $query = $this->galleryItemRepository->select('id', 'path', 'created_at')->where('gallery_id', $gallery['id']);
        $count = $query->count();
        if ($count > 0) {
            $items = $query->get()->toArray();
            $i = 0;
            foreach ($items as $item) {
                $images[$i]['id'] = $item['id'];
                $images[$i]['name'] = $item['path'];
                $images[$i]['url'] = trim(ImageUploader::getFilePath($item['path'], $gallery['created_at'], 'thumbnail'));
                $images[$i]['size'] = filesize(ImageUploader::getFileRootPath($item['path'], $gallery['created_at']));
                $images[$i]['accepted'] = true;
                $i++;
            }
        }
        //dd($images);
        return view('sysadmin::gallery.view')->with([
            'gallery' => $gallery,
            'items' => $images,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $items = [];
        $images = [];
        $gallery = $this->galleryRepository->findOrFail($id)->toArray();
        $query = $this->galleryItemRepository->select('id', 'path', 'created_at')->where('gallery_id', $gallery['id']);
        $count = $query->count();
        if ($count > 0) {
            $items = $query->get()->toArray();
            $i = 0;
            foreach ($items as $item) {
                $images[$i]['id'] = $item['id'];
                $images[$i]['name'] = $item['path'];
                $images[$i]['url'] = trim(ImageUploader::getFilePath($item['path'], $item['created_at'], 'thumbnail'));
                $images[$i]['size'] = filesize(ImageUploader::getFileRootPath($item['path'], $item['created_at']));
                $images[$i]['accepted'] = true;
                $i++;
            }
        }
        //dd($gallery);
        return view('sysadmin::gallery.edit')->with([
            'gallery' => $gallery,
            'items' => $images,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GalleryFormRequest $request, $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->galleryRepository->saveOrUpdate($validatedData, $id);
        return redirect()->route('sysadmin.gallery.view', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->galleryRepository->delete($id);
        return redirect()->route('sysadmin.gallery.index');
    }

    public function uploadItem($gallery_id, $created_at, Request $request)
    {
        $file = $request->all();
        $datetime = new DateTime($created_at);
        $formattedDatetime = $datetime->format('Y-m-d H:i:s');

        $data['name']  = ImageUploader::upload($file['file'], $formattedDatetime);
        $data['path'] = ImageUploader::getFilePath($data['name'], $formattedDatetime);
        $item = $this->galleryItemRepository->saveOrUpdate([
            'gallery_id' => $gallery_id,
            'path' => $data['name'],
            'timestamp' => $formattedDatetime
        ]);

        if ($item !== NULL) {
            $item['path'] = $data['path'];
            // Handle successful upload (e.g., save file path to database)
            return response()->json(['success' => true, 'message' => 'File uploaded successfully!', 'item' => $item]);
        } else {
            // Handle upload failure
            return response()->json(['success' => false, 'message' => 'Failed to upload file!'], 500);
        }
    }

    public function removeItem($id)
    {
        $item = $this->galleryItemRepository->findOrFail($id);
        ImageUploader::remove($item->path, $item->timestamp);
        $this->galleryItemRepository->delete($id);
        return true;
    }
}
