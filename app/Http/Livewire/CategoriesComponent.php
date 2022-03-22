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
    private $pagination = 5;

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorías';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }

    public function render()
    {
        $data = Category::orderBy('id', 'DESC')->paginate($this->pagination);

        if(strlen($this->search) > 0)
        {
            $data = Category::where('name', 'LIKE', '%'.$this->search.'%')->paginate($this->pagination);
        }

        return view('livewire.category.component', compact('data'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|unique:categories|min:3'
        ];

        $messages = [
            'name.required' => 'Requerido',
            'name.unique' => 'Ya existe la categoría',
            'name.min' => 'Debe contener mínimo 3 carácteres'
        ];

        $this->validate($rules, $messages);

        $category = Category::create([
            'name' => $this->name
        ]);

        $customFileName;
        if($this->image)
        {
            $customFileName = uniqid().'_.'.$this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);
            $category->image = $customFileName;
            $category->save();
        }

        $this->resetUI();
        $this->emit('item-added', 'Categoría registrada');
    }

    public function edit($id)
    {
        $record = Category::findOrFail($id, ['id','name', 'image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
    }

    public function update()
    {
        $rules = [
            'name' => "required|min:3|unique:categories,name,{$this->selected_id}"
        ];

        $messages = [
            'name.required' => 'Requerido',
            'name.min' => 'Debe contener mínimo 3 carácteres',
            'name.unique' => 'Ya existe la categoría'
        ];

        $this->validate($rules, $messages);

        $category = Category::find($this->selected_id);
        $category->update(['name' => $this->name]);

        if($this->image)
        {
            $customFileName = uniqid().'_.'.$this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);
            $imageName = $category->image;

            $category->image = $customFileName;
            $category->save();

            if($imageName != "")
            {
                if(file_exists('storage/categories/'.$imageName))
                {
                    unlink('storage/categories/'.$imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('item-updated', 'Categoría actualizada');
    }

    public function destroy(Category $category)
    {
        if ($category->products->count() == 0)
        {
            $imageName = $category->image;//Imagen temporal
            $category->delete();

            if ($imageName != null)
            {
                unlink('storage/categories/'.$imageName);
            }

            $this->resetUI();
            $this->emit('item-deleted', 'Categoría eliminada');
        }
        else
        {
            $this->resetUI();
            $this->emit('error-delete', '¡¡No se puede eliminar la categoria porque tiene productos relacionados!!');
        }
    }
}
