<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Investor;

class InvestorSeeder extends Seeder
{
    public function run(): void
    {
        Investor::factory()->count(5)->create();
    }
}
