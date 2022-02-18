<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

use illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name;
    public $search;
    public $image;
    public $selected_id;
    public $pageTitle;
    public $componentName;
    private $pagination = 5;

    public function render()
    {
        $categories = Category::all();

        return view('livewire.category.categories', compact('categories'))
                ->extends('layouts.theme.app')
                ->section('content');
    }
}
