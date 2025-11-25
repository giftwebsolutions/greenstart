<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Modules\SysAdmin\Interfaces\AttributeInterface;
use Modules\SysAdmin\Interfaces\AttributeValueInterface;
use Modules\SysAdmin\DataTables\AttributeDataTable;
use Modules\SysAdmin\Requests\AttributeFormRequest;
use Modules\SysAdmin\Models\AttributeValue;
use Modules\SysAdmin\Models\ProductVariantValue;

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
        $attribute = $this->attributeRepository->findOrFail($id);

        // load existing values for this attribute (id + value)
        $values = $attribute->values()
            ->orderBy('sort_order')
            ->get(['id', 'value'])
            ->map(function ($v) {
                return [
                    'id'    => $v->id,
                    'value' => $v->value,
                ];
            })
            ->toArray();

        //dd($this->attributeRepository->getAttributeSets());
        return view('sysadmin::catalog.attribute.edit', compact('attribute', 'values'))->with([
            'groups'   => $this->attributeRepository->getAttributeSets(),
            'types'    => $this->attributeRepository->getAttributeTypes(),
            'statuses' => $this->attributeRepository->getStatus(),
        ]);
    }


    public function update(AttributeFormRequest $request, $id): RedirectResponse
    {
        try {
            $validatedData = $request->validated();

            // 1) Update attribute
            $attribute = $this->attributeRepository->saveOrUpdate($validatedData, $id);

            // 2) Handle values WITHOUT deleting everything
            $submittedValues = $request->input('values', []); // each: ['id' => ?, 'value' => ?]
            $submittedIds    = [];

            $sort = 0;

            foreach ($submittedValues as $row) {
                $valueText = trim((string) ($row['value'] ?? ''));

                if ($valueText === '') {
                    continue;
                }

                $id = $row['id'] ?? null;

                if ($id) {
                    // UPDATE existing value
                    $submittedIds[] = (int) $id;

                    $this->attributeValueRepository->update([
                        'value'      => $valueText,
                        'sort_order' => $sort++,
                    ], $id);
                } else {
                    // CREATE new value
                    $value = $this->attributeValueRepository->create([
                        'attribute_id' => $attribute->id,
                        'value'        => $valueText,
                        'sort_order'   => $sort++,
                    ]);

                    $submittedIds[] = $value->id;
                }
            }

            // 3) Handle removed values (present in DB, not in submittedIds)
            $existingValues = AttributeValue::where('attribute_id', $attribute->id)->get();

            foreach ($existingValues as $existing) {
                if (in_array($existing->id, $submittedIds, true)) {
                    continue; // still in use
                }

                // Check if this value is used in product variants
                $isUsed = ProductVariantValue::where('attribute_value_id', $existing->id)->exists();

                if ($isUsed) {
                    // SOFT DELETE / DISABLE (recommended)
                    $existing->status = 0;   // make sure 'status' column exists
                    $existing->save();
                } else {
                    // SAFE to hard delete
                    $existing->delete();
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
