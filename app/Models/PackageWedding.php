<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageWedding extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'location',
        'price',
        'pax',
        'category_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function package_photos(){
        return $this->hasMany(PackagePhoto::class);
    }
}
