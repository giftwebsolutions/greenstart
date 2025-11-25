<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Modules\SysAdmin\Interfaces\AttributeInterface;
use Modules\SysAdmin\Interfaces\AttributeValueInterface;
use Modules\SysAdmin\DataTables\AttributeDataTable;
use Modules\SysAdmin\Requests\AttributeFormRequest;

class AttributeController extends Controller
{
    public function __construct(
        protected AttributeInterface $attributeRepository,
        protected AttributeValueInterface $attributeValueRepository
    ) {}

    public function index(AttributeDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::catalog.attribute.index');
    }

    public function create()
    {
        return view('sysadmin::catalog.attribute.create')->with([
            'groups'   => $this->attributeRepository->getAttributeSets(),
            'types'    => $this->attributeRepository->getAttributeTypes(),
            'statuses' => $this->attributeRepository->getStatus(),
        ]);
    }

    public function store(AttributeFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        // 1) Create Attribute
        $attribute = $this->attributeRepository->saveOrUpdate($validatedData);

        // 2) If values[] sent (for select / checkbox) → create attribute_values
        $values = $request->input('values', []);
        if (!empty($values) && is_array($values)) {
            $sort = 0;
            foreach ($values as $value) {
                $value = trim((string) $value);

                if ($value === '') {
                    continue;
                }

                $this->attributeValueRepository->create([
                    'attribute_id' => $attribute->id,
                    'value'        => $value,
                    'sort_order'   => $sort++,
                ]);
            }
        }

        return redirect()->route('sysadmin.catalog.attribute.index');
    }

    public function show($id)
    {
        try {
            $page = $this->attributeRepository->with(['parent'])->findOrFail($id)->toArray();

            return view('sysadmin::catalog.attribute.view')->with([
                'page' => $page,
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        }
    }

    public function edit($id)
    {
        $page = $this->attributeRepository->findOrFail($id);

        // load existing values for this attribute (for edit form)
        $values = $page->values()->orderBy('sort_order')->pluck('value')->toArray() ?? [];

        return view('sysadmin::catalog.attribute.edit', compact('page', 'values'))->with([
            'parents'        => $this->attributeRepository->getParents(),
            'attributeTypes' => $this->attributeRepository->getAttributeTypes(),
            'statuses'       => $this->attributeRepository->getStatus(),
        ]);
    }

    public function update(AttributeFormRequest $request, $id): RedirectResponse
    {
        try {
            $validatedData = $request->validated();

            // 1) Update attribute
            $attribute = $this->attributeRepository->saveOrUpdate($validatedData, $id);

            // 2) Sync values (simple strategy: delete & recreate)
            $this->attributeValueRepository->deleteWhere(['attribute_id' => $attribute->id]);

            $values = $request->input('values', []);
            if (!empty($values) && is_array($values)) {
                $sort = 0;
                foreach ($values as $value) {
                    $value = trim((string) $value);

                    if ($value === '') {
                        continue;
                    }

                    $this->attributeValueRepository->create([
                        'attribute_id' => $attribute->id,
                        'value'        => $value,
                        'sort_order'   => $sort++,
                    ]);
                }
            }

            return redirect()->route('sysadmin.catalog.attribute.index');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        }
    }

    public function destroy($id)
    {
        $this->attributeRepository->delete($id);

        return redirect()->route('sysadmin.catalog.attribute.index');
    }
}
