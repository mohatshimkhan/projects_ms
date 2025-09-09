<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','is_active'];


    /////////////////////////////////////////////////////////

    public function user(){
        $this->belongsTo('App\Models\User'::class);
    }

    public function projects(){
        $this->hasMany('App\Models\Project'::class);
    }

    ////////////////////////////////////////////////////////




}