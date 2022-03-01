<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;

use illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductsComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name;
    public $barcode;
    public $cost;
    public $price;
    public $stock;
    public $alerts;
    public $image;
    public $category_id;
    public $selected_id;
    public $pageTitle;
    public $search;
    public $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos';
        $this->category_id = 'Seleccionar';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        $data = Product::with('category')->paginate($this->pagination);
        $categories = Category::orderBy('name', 'ASC')->get();

        if(strlen($this->search) > 0)
        {
            $data = Product::whereHas('category', function($q){
                        return $q->where('products.name', 'LIKE', '%'.$this->search.'%')
                                 ->orWhere('products.barcode', 'LIKE', '%'.$this->search.'%')
                                 ->orWhere('products.cost', 'LIKE', '%'.$this->search.'%')
                                 ->orWhere('products.price', 'LIKE', '%'.$this->search.'%')
                                 ->orWhere('products.stock', 'LIKE', '%'.$this->search.'%')
                                 ->orWhere('products.alerts', 'LIKE', '%'.$this->search.'%')
                                 ->orWhere('categories.name', 'LIKE', '%'.$this->search.'%');
            })->paginate($this->pagination);
        }

        return view('livewire.products.component', compact('data', 'categories'))
                ->extends('layouts.theme.app')
                ->section('content');
    }
}
