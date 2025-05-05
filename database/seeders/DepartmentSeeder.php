<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $departments = ['HR', 'Finance', 'Marketing', 'IT', 'Sales', 'Logistics', 'Admin', 'Support', 'R&D', 'Operations'];

        foreach ($departments as $dept) {
            DB::table('departments')->insert([
                'name' => $dept,
                'description' => $dept . ' Department',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
