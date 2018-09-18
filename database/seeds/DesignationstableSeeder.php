<?php

use Illuminate\Database\Seeder;
use App\Designation;
class DesignationstableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Designation::insert([

        	['designation_name'=>'Trainee Engineer'],
        	['designation_name'=>'Software Engineer'],
        	['designation_name'=>'Senior Software Engineer'],
        	['designation_name'=>'Project Lead'],
        	['designation_name'=>'Director'],

        ]);
    }
}
