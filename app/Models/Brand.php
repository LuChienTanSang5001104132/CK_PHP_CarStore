<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    // Cho phép thêm nhanh các trường này vào DB
    protected $fillable = ['name', 'slug'];

    // (Tùy chọn) Định nghĩa mối quan hệ ngược lại: Một hãng có nhiều Xe
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}