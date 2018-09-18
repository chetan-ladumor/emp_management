<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Designation;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserstableSeeder::class);
        $this->call(DesignationstableSeeder::class);
    }
}
