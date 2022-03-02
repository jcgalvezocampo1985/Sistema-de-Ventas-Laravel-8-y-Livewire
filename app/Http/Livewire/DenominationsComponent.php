<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;

use illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DenominationsComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $type;
    public $value;
    public $image;
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
        $this->componentName = 'Denominaciones';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function resetUI()
    {
        $this->type = '';
        $this->value = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }

    public function render()
    {
        $data = Denomination::orderBy('type', 'DESC')->paginate($this->pagination);
        $denominations = ['BILLETE', 'MONEDA', 'OTRO'];

        if(strlen($this->search) > 0)
        {
            $data = Denomination::where('type', 'LIKE', '%'.$this->search.'%')
                                ->orWhere('value', 'LIKE', '%'.$this->search.'%')
                                ->paginate($this->pagination);
        }

        return view('livewire.denominations.component', compact('data', 'denominations'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function store()
    {
        $rules = [
            'type' => 'required',
            'value' => 'required|numeric|unique:denominations'
        ];

        $messages = [
            'type.required' => 'Requerido',
            'value.required' => 'Requerido',
            'value.numeric' => 'Solo números',
            'value.unique' => 'Ya existe el valor'
        ];

        $this->validate($rules, $messages);

        $denomination = Denomination::create([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if($this->image)
        {
            $customFileName = uniqid().'_.'.$this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $denomination->image = $customFileName;
            $denomination->save();
        }

        $this->resetUI();
        $this->emit('item-added', 'Denominación registrada');
    }

    public function edit(Denomination $denomination)
    {
        $this->selected_id = $denomination->id;
        $this->type = $denomination->type;
        $this->value = $denomination->value;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
    }

    public function update()
    {
        $rules = [
            'type' => 'required|min:1',
            'value' => "required|numeric|unique:denominations,value,{$this->selected_id}"
        ];

        $messages = [
            'type.required' => 'Requerido',
            'type.min' => 'Debe contener mínimo 1 carácter',
            'value.required' => 'Requerido',
            'value.numeric' => 'Solo números',
            'value.unique' => 'El valor ya existe'
        ];

        $this->validate($rules, $messages);

        $denomination = Denomination::find($this->selected_id);
        $denomination->update([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if($this->image)
        {
            $customFileName = uniqid().'_.'.$this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $imageName = $denomination->image;

            $denomination->image = $customFileName;
            $denomination->save();

            if($imageName != "")
            {
                if(file_exists('storage/denominations/'.$imageName))
                {
                    unlink('storage/denominations/'.$imageName);
                }
            }
        }
        $this->resetUI();
        $this->emit('item-updated', 'Denominación actualizada');
    }

    public function destroy(Denomination $denomination)
    {
        $imageName = $denomination->image;//Imagen temporal
        $denomination->delete();

        if ($imageName != null)
        {
            unlink('storage/denominations/'.$imageName);
        }

        $this->resetUI();
        $this->emit('item-deleted', 'Denominación eliminada');
    }
}
