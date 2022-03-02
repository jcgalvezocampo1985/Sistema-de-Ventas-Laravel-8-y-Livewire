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
    public $categoryid;
    public $selected_id;
    public $pageTitle;
    public $search;
    public $componentName;
    private $pagination = 5;

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

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

    public function resetUI()
    {
        $this->name = '';
        $this->barcode = '';
        $this->cost = '';
        $this->price = '';
        $this->stock = '';
        $this->alerts = '';
        $this->categoryid = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
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

    public function store()
    {
        $rules = [
            'name' => 'required|unique:products|min:3',
            'barcode' => 'required|numeric',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'alerts' => 'required|numeric',
            'categoryid' => 'required'
        ];

        $messages = [
            'name.required' => 'Requerido',
            'name.unique' => 'Ya existe el producto',
            'name.min' => 'Debe contener mínimo 3 carácteres',
            'barcode.required' => 'Requerido',
            'barcode.numeric' => 'Solo números',
            'cost.required' => 'Requerido',
            'cost.numeric' => 'Solo números',
            'price.required' => 'Requerido',
            'price.numeric' => 'Solo números',
            'stock.required' => 'Requerido',
            'stock.numeric' => 'Solo números',
            'alerts.required' => 'Requerido',
            'alerts.numeric' => 'Solo números',
            'categoryid.required' => 'Requerido'
        ];

        $this->validate($rules, $messages);

        $category = Product::create([
            'name' => $this->name,
            'barcode' => $this->barcode,
            'cost' => $this->cost,
            'price' => $this->price,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->categoryid
        ]);

        if($this->image)
        {
            $customFileName = uniqid().'_.'.$this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $category->image = $customFileName;
            $category->save();
        }

        $this->resetUI();
        $this->emit('product-added', 'Producto registrado');
    }

    public function edit(Product $product)
    {
        $this->selected_id = $product->id;
        $this->name = $product->name;
        $this->barcode = $product->barcode;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->alerts = $product->alerts;
        $this->categoryid = $product->category_id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
    }

    public function update()
    {
        $rules = [
            'name' => "required|min:3|unique:products,name,{$this->selected_id}",
            'barcode' => 'required|numeric',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'alerts' => 'required|numeric',
            'categoryid' => 'required'
        ];

        $messages = [
            'name.required' => 'Requerido',
            'name.unique' => 'Ya existe el producto',
            'name.min' => 'Debe contener mínimo 3 carácteres',
            'barcode.required' => 'Requerido',
            'barcode.numeric' => 'Solo números',
            'cost.required' => 'Requerido',
            'cost.numeric' => 'Solo números',
            'price.required' => 'Requerido',
            'price.numeric' => 'Solo números',
            'stock.required' => 'Requerido',
            'stock.numeric' => 'Solo números',
            'alerts.required' => 'Requerido',
            'alerts.numeric' => 'Solo números',
            'categoryid.required' => 'Requerido'
        ];

        $this->validate($rules, $messages);

        $product = Product::find($this->selected_id);
        $product->update([
            'name' => $this->name,
            'barcode' => $this->barcode,
            'cost' => $this->cost,
            'price' => $this->price,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->categoryid
        ]);

        if($this->image)
        {
            $customFileName = uniqid().'_.'.$this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $imageName = $product->image;

            $product->image = $customFileName;
            $product->save();

            if($imageName != "")
            {
                if(file_exists('storage/products/'.$imageName))
                {
                    unlink('storage/products/'.$imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('product-updated', 'Producto actualizado');
    }

    public function destroy(Product $product)
    {
        if ($product->sale_details->count() == 0)
        {
            $imageName = $product->image;//Imagen temporal
            $product->delete();

            if ($imageName != null)
            {
                unlink('storage/products/'.$imageName);
            }

            $this->resetUI();
            $this->emit('product-deleted', 'Producto eliminado');
        }
        else
        {
            $this->resetUI();
            $this->emit('error-delete', '¡¡No se puede eliminar el producto porque tiene ventas relacionadas!!');
        }
    }
}
