<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Preserve the original IDs because existing attributes reference them.
        DB::table('attribute_type')->where('attribute_type_id', 1)->update([
            'type_name' => 'Text',
            'identifier' => 'text',
        ]);
        DB::table('attribute_type')->where('attribute_type_id', 2)->update([
            'type_name' => 'Dropdown / Enum',
            'identifier' => 'select',
        ]);
        DB::table('attribute_type')->where('attribute_type_id', 3)->update([
            'type_name' => 'Multi Select',
            'identifier' => 'multiselect',
        ]);

        foreach ([
            ['type_name' => 'Long Text', 'identifier' => 'textarea', 'status' => '1'],
            ['type_name' => 'Yes / No', 'identifier' => 'boolean', 'status' => '1'],
            ['type_name' => 'Date', 'identifier' => 'date', 'status' => '1'],
            ['type_name' => 'Date & Time', 'identifier' => 'datetime', 'status' => '1'],
            ['type_name' => 'Number', 'identifier' => 'number', 'status' => '1'],
            ['type_name' => 'Price', 'identifier' => 'price', 'status' => '1'],
        ] as $type) {
            DB::table('attribute_type')->updateOrInsert(
                ['identifier' => $type['identifier']],
                $type,
            );
        }
    }

    public function down(): void
    {
        DB::table('attribute_type')->whereIn('identifier', [
            'textarea', 'boolean', 'date', 'datetime', 'number', 'price',
        ])->whereDoesntExist(function ($query) {
            $query->selectRaw('1')
                ->from('attribute')
                ->whereColumn('attribute.type', 'attribute_type.attribute_type_id');
        })->delete();

        DB::table('attribute_type')->where('attribute_type_id', 1)->update(['type_name' => 'Text filed', 'identifier' => 'text']);
        DB::table('attribute_type')->where('attribute_type_id', 2)->update(['type_name' => 'Select', 'identifier' => 'select']);
        DB::table('attribute_type')->where('attribute_type_id', 3)->update(['type_name' => 'Multi Select', 'identifier' => 'Multi Select']);
    }
};
