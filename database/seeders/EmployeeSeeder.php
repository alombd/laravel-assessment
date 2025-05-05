<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Department;
use App\Models\EmployeeDetail;
use Illuminate\Support\Str;


class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $departmentIds = Department::pluck('id')->toArray();

        $batchSize = 1000; // Laravel handles 1000 per insert well
        $total = 100000;

        for ($i = 0; $i < $total / $batchSize; $i++) {
            $employees = [];
            $details = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $uuid = (string) Str::uuid();

                $employees[] = [
                    'id' => $uuid,
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'department_id' => $faker->randomElement($departmentIds),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $details[] = [
                    'employee_id' => $uuid,
                    'designation' => $faker->jobTitle,
                    'salary' => $faker->randomFloat(2, 30000, 100000),
                    'address' => $faker->address,
                    'joined_date' => $faker->date(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Employee::insert($employees);
            EmployeeDetail::insert($details);
        }
    }
}
