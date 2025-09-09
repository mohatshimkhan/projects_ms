<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name','company_id','project_id','user_id','days','hours'];


    //////////////////////////////////////////////////////////

    public function company(){
        $this->belongsTo('App\Models\Company'::class);
    }

    public function project(){
        $this->belongsTo('App\Models\User'::class);
    }

    public function users(){
    	$this->belongsToMany('App\Models\User'::class);
    }

    
	///////////////////////////////////////////////////////

}