<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    // Cấp quyền cho phép insert dữ liệu vào các cột này
    protected $fillable = ['name', 'description']; 

    // Mối quan hệ: 1 Hãng xe có nhiều Xe
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}