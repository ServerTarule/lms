<?php

namespace Database\Seeders;

use App\Models\DynamicMain;
use App\Models\DynamicValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateRangeId = DynamicMain::updateOrCreate(['id' => 99, 'name' => 'Date Range']);
        DynamicValue::updateOrCreate(['name' => '7 DAYS', 'parent_id' => $dateRangeId->id ]);
        DynamicValue::updateOrCreate(['name' => '14 DAYS', 'parent_id' => $dateRangeId->id ]);
        DynamicValue::updateOrCreate(['name' => '1 MONTH', 'parent_id' => $dateRangeId->id ]);
        DynamicValue::updateOrCreate(['name' => '2 MONTHS', 'parent_id' => $dateRangeId->id ]);
    }
}
