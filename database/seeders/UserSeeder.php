<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyId = DB::table('companies')->pluck('id');

        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => 'Semih' . $i,
                'surname' => 'Yucel' . $i,
                'email' => 'semih' . $i . '.yucel' . $i . '@deneme.com',
                'phone' => '05556668877' . $i,
                'password' => '123456' , //güvenliksiz
                'company_id' => $companyId->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
