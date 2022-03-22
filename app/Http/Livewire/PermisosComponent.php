<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;

class PermisosComponent extends Component
{
    use WithPagination;

    public $name;
    public $search;
    public $selected_id;
    public $pageTitle;
    public $componentName;
    private $pagination = 10;

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Permisos';
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
        $data = Permission::orderBy('name', 'ASC')->paginate($this->pagination);

        if(strlen($this->search) > 0)
        {
            $data = Permission::where('name', 'LIKE', '%'.$this->search.'%')->paginate($this->pagination);
        }

        return view('livewire.permisos.component', compact('data'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min:2|unique:permissions,name'
        ];

        $messages = [
            'name.required' => 'Requerido',
            'name.unique' => 'Ya existe el Permiso',
            'name.min' => 'Debe contener mínimo 2 carácteres'
        ];

        $this->validate($rules, $messages);

        $permiso = Permission::create([
            'name' => $this->name
        ]);

        $this->resetUI();
        $this->emit('item-added', 'Permiso registrado');
    }

    public function edit(Permission $permiso)
    {
        $this->name = $permiso->name;
        $this->selected_id = $permiso->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function update()
    {
        $rules = [
            'name' => "required|min:2|unique:permissions,name,{$this->selected_id}"
        ];

        $messages = [
            'name.required' => 'Requerido',
            'name.unique' => 'Ya existe el Permiso',
            'name.min' => 'Debe contener mínimo 2 carácteres'
        ];

        $this->validate($rules, $messages);

        $rol = Permission::find($this->selected_id);
        $rol->update(['name' => $this->name]);

        $this->resetUI();
        $this->emit('item-updated', 'Permiso actualizado');
    }

    public function destroy(Permission $permiso)
    {
        if ($permiso->roles->count() == 0)
        {
            $permiso->delete();

            $this->emit('item-deleted', 'Permiso eliminado');
        }
        else
        {
            $this->emit('error-delete', '¡¡No se puede eliminar el permiso porque tiene roles relacionados!!');
        }
    }
}
