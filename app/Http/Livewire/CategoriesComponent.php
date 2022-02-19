<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

use illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class CategoriesComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name;
    public $search;
    public $image;
    public $selected_id;
    public $pageTitle;
    public $componentName;
    private $pagination = 2;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorías';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate($this->pagination);

        if(strlen($this->search) > 0)
        {
            $categories = Category::where('name', 'LIKE', '%'.$this->search.'%')->paginate($this->pagination);
        }

        return view('livewire.category.categories', compact('categories'))
                ->extends('layouts.theme.app')
                ->section('content');
    }
}
