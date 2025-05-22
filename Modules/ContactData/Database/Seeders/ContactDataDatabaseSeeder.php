<?php

namespace Modules\ContactData\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ContactData\Database\Seeders\SeedPlacePublishSeeder;

class ContactDataDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(SeedPlacePublishSeeder::class);
    }
}
