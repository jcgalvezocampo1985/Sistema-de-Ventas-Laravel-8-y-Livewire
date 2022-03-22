<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SaleDetail;
use App\Models\Product;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'items', 'cash', 'change', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sale_details()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_details');
    }
}
