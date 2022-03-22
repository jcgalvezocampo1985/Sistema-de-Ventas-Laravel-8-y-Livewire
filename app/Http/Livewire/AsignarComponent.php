<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class AsignarComponent extends Component
{
    use WithPagination;

    public $role;
    public $componentName;
    public $permisosSelected = [];
    public $old_permissions = [];
    private $pagination = 10;

    protected $listeners = [
        'revokeAll' => 'removeAll'
    ];

    public function mount()
    {
        $this->role = '';
        $this->componentName = 'Asignar Permisos';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        $permisos = Permission::select('name', 'id', DB::raw("0 as checked"))
                            ->orderBy('name', 'ASC')
                            ->paginate($this->pagination);
        $roles = Role::orderBy('name', 'ASC')->get();

        if ($this->role != "")
        {
            $list = Permission::join('role_has_permissions as rp', 'rp.permission_id', 'permissions.id')
                              ->where('role_id', $this->role)
                              ->pluck('permissions.id')
                              ->toArray();
            $this->old_permissions = $list;

            foreach ($permisos as $permiso)
            {
                $role = Role::find($this->role);
                $tienePermiso = $role->hasPermissionTo($permiso->name);

                if ($tienePermiso)
                {
                    $permiso->checked = 1;
                }
            }
        }

        return view('livewire.asignar.component', compact('roles', 'permisos'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function removeAll()
    {
        if($this->role == "")
        {
            $this->emit("sync-error", "Selecciona un rol válido");
            return;
        }

        $role = Role::find($this->role);
        $role->syncPermissions([0]);

        $this->emit("remove-all", "Permisos revocados al rol $role->name");
    }

    public function SyncAll()
    {
        if($this->role == "")
        {
            $this->emit("sync-error", "Selecciona un rol válido");
            return;
        }

        $role = Role::find($this->role);
        $permisos = Permission::pluck('id')->toArray();
        $role->syncPermissions($permisos);
        $this->emit("sync-all", "Se sincronizaron todos los permisos al role $role->name");
    }

    public function SyncPermiso($state, $permisoName)
    {
        if($this->role != "")
        {
            $roleName = Role::find($this->role);

            if($state)
            {
                $roleName->givePermissionTo($permisoName);
                $this->emit("permiso", "Permiso asignado correctamente");
            }
            else
            {
                $roleName->revokePermissionTo($permisoName);
                $this->emit("permiso", "Permiso eliminado correctamente");
            }
        }
        else
        {
            $this->emit("permiso", "Elige un rol válido");
        }
    }
}
