<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class RolesComponent extends Component
{
    use WithPagination;

    public $name;
    public $search;
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
        $this->componentName = 'Roles';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function resetUI()
    {
        $this->resetValidation();
        $this->name = '';
        $this->search = '';
        $this->selected_id = 0;
    }

    public function render()
    {
        $data = Role::orderBy('name', 'ASC')->paginate($this->pagination);

        if(strlen($this->search) > 0)
        {
            $data = Role::where('name', 'LIKE', '%'.$this->search.'%')->paginate($this->pagination);
        }

        return view('livewire.roles.component', compact('data'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min:2|unique:roles,name'
        ];

        $messages = [
            'name.required' => 'Requerido',
            'name.unique' => 'Ya existe el Rol',
            'name.min' => 'Debe contener mínimo 2 carácteres'
        ];

        $this->validate($rules, $messages);

        $rol = Role::create([
            'name' => $this->name
        ]);

        $this->resetUI();
        $this->emit('item-added', 'Rol registrado');
    }

    public function edit(Role $rol)
    {
        $this->name = $rol->name;
        $this->selected_id = $rol->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function update()
    {
        $rules = [
            'name' => "required|min:2|unique:roles,name,{$this->selected_id}"
        ];

        $messages = [
            'name.required' => 'Requerido',
            'name.unique' => 'Ya existe el Rol',
            'name.min' => 'Debe contener mínimo 2 carácteres'
        ];

        $this->validate($rules, $messages);

        $rol = Role::find($this->selected_id);
        $rol->update(['name' => $this->name]);

        $this->resetUI();
        $this->emit('item-updated', 'Rol actualizado');
    }

    public function destroy(Role $rol)
    {
        if ($rol->permissions->count() == 0)
        {
            $rol->delete();

            $this->emit('item-deleted', 'Rol eliminado');
        }
        else
        {
            $this->emit('error-delete', '¡¡No se puede eliminar el rol porque tiene permisos relacionados!!');
        }
    }
}
