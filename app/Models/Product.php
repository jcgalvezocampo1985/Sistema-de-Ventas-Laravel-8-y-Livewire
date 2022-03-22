<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SaleDetail;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'barcode', 'cost', 'price', 'stock', 'alerts', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sale_details()
    {
        return $this->hasMany(SaleDetail::class, 'product_id');
    }

    public function getImagenAttribute()
    {
        if(file_exists('storage/products/'.$this->image) && $this->image != "")
        {
            return $this->image;
        }
        else
        {
            return 'noimg.jpg';
        }
    }
}
