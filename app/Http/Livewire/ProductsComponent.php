<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductsComponent extends Component
{
    public function render()
    {
        return view('livewire.products');
    }
}
