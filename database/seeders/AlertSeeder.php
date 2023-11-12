<?php

namespace Database\Seeders;

use App\Models\Alert;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{

    public function run(): void
    {
        Alert::factory()->count(10)->create();
    }
}
