<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
	protected $primaryKey ="employee_id";
    protected $fillable= ['employee_id','employee_name','designation_id','dob','age'];
    public $timestamps  = false;
    

    public function designation()
    {
        return $this->belongsTo('App\Designation');
    }
}
