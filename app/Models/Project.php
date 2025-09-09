<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','company_id','user_id','days'];


    /////////////////////////////////////////////////////////////////////////////


    public function company(){
        $this->belongsTo('App\Models\Company'::class);
    }

    public function users(){
        $this->belongsToMany('App\Models\User'::class);
    }


    /////////////////////////////////////////////////////////////////////////////


}