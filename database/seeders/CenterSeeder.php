<?php

namespace Database\Seeders;

use App\Models\Center;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Center::create([
            'name' => 'Ibn Rushd Center',
            'email' => 'centerA@example.com',
            'phone' => '123-456-7890',
            'address' => 'Qatar',
            'commission_ranges' => [
                ['min' => 0, 'max' => 19999, 'percentage' => 40],
                
                ['min' => 20000, 'max' => null, 'percentage' => 50],
            ],
        ]);
    }
}
