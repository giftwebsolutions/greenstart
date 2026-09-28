<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Existing admin validation prevents new invalid prices. Normalize old
        // rows by retaining the selling price and raising MRP to match it.
        DB::table('product')
            ->whereColumn('sales_price', '>', 'mrp')
            ->update(['mrp' => DB::raw('sales_price')]);
    }

    public function down(): void
    {
        // Historical MRP values cannot be reconstructed safely.
    }
};
