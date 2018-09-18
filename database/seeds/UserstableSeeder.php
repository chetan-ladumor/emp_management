<?php

use Illuminate\Database\Seeder;
use App\User;
class UserstableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'username'=>'ladumorchetan@yahoo.com',
        	'password'=>bcrypt('AisChetan'),
        ]);
    }
}
