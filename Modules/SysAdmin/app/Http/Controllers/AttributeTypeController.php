<?php

namespace Modules\SysAdmin\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\SysAdmin\Interfaces\AttributeInterface;
use Modules\SysAdmin\DataTables\AttributeDataTable;
use Modules\SysAdmin\Requests\AttributeFormRequest;

class AttributeTypeController extends Controller
{

    public function __construct(
        protected AttributeInterface $attributeRepository
    ) {}

    public function index(AttributeDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::catalog.attributetype.index');
    }

    public function create()
    {
        return view('sysadmin::attribute.create')->with([
            'attributeSets' => $this->attributeRepository->getAttributeSets(),
            'attributeTypes' => $this->attributeRepository->getAttributeTypes(),
        ]);
    }

    public function store(AttributeFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->attributeRepository->saveOrUpdate($validatedData);
        return redirect()->route('sysadmin.catalog.attribute.index');
    }
}
