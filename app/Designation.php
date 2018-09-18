<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $primaryKey ="id"; 
    protected $fillable= ['designation_name'];
    public $timestamps  = false;

    public function employees()
    {
    	return $this->hasMany('App\Employee');
    }

}
