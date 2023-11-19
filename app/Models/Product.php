<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category() {

        return $this->belongsTo(Category::class);
    
    }

    public function brand() {

        return $this->belongsTo(Brand::class);
    
    }


    public function users() {

        return $this->belongsToMany(User::class,'alerts');
    }
    
}
