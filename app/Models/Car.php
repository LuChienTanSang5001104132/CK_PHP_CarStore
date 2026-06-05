<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Brand;

class Car extends Model
{
   protected $fillable = [
        'brand_id',
        'name',
        'slug',
        'price',
        'year',
        'color',
        'type',
        'quantity',
        'mileage',
        'fuel_type',
        'transmission',
        'engine_capacity',
        'seats',
        'description',
        'featured_image',
        'status',
        'views'
    ];
   public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class); 
    }
}