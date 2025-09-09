<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Post;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','description','image','is_active','created_at','updated_at'];


    public function posts(){
    	$this->hasMany(Post::class);
    }    
}