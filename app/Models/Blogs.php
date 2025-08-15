<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    protected $fillable = ['title', 'date', 'image', 'desciption', 'status', 'created_at', 'updated_at','deleted_at'];

    
}
