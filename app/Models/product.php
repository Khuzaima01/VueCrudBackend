<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{



    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'image',
    ];

    public function productImage()
    {
        return $this->hasOne(productImage::class, 'product_id');
    }
}
