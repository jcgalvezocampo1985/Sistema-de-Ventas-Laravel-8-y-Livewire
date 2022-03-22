<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;

use illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UsersComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name;
    public $phone;
    public $email;
    public $status;
    public $password;
    public $image;
    public $roleid;
    public $selected_id;
    public $search;
    public $pageTitle;
    public $componentName;
    private $pagination = 5;

    protected $listeners = [
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI'
    ];

    public function mount()
    {
        $this->pageTitle = "Listado";
        $this->componentName = "Usuarios";
        $this->roleid = "";
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function resetUI()
    {
        $this->resetValidation();
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->status = '';
        $this->password = '';
        $this->image = null;
        $this->roleid = '';
        $this->search = '';
        $this->selected_id = 0;
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = User::join('roles', 'roles.id', 'users.role_id')
                        ->select('users.id', 'users.name', 'users.phone', 'users.email', 'users.status', 'users.image', 'roles.name AS role')
                        ->where('users.name', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('users.phone', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('users.email', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('users.status', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('roles.name', 'LIKE', '%'.$this->search.'%')
                        ->orderBy('users.name', 'ASC')
                        ->paginate($this->pagination);
        }
        else
        {
            $data = User::join('roles', 'roles.id', 'users.role_id')
                        ->select('users.id', 'users.name', 'users.phone', 'users.email', 'users.status', 'users.image', 'users.role_id', 'roles.name AS role')
                        ->orderBy('users.name', 'ASC')
                        ->paginate($this->pagination);
        }

        $roles = Role::orderBy('name', 'ASC')->get();

        return view('livewire.users.component', compact('data', 'roles'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'status' => 'required',
            'roleid' => 'required',
            'password' => 'required|min:3'
        ];

        $messages = [
            'name.required' => 'Requerido',
            'name.min' => 'Debe contener mínimo 3 carácteres',
            'email.required' => 'Requerido',
            'email.unique' => 'Email ya existe',
            'email.email' => 'Formato no válido',
            'status.required' => 'Requerido',
            'roleid.required' => 'Requerido',
            'password.required' => 'Requerido',
            'password.min' => 'Mímimo 3 caracteres'
        ];

        $this->validate($rules, $messages);

        $user = User::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
            'password' => bcrypt($this->password),
            'role_id' => $this->roleid
        ]);

        $user->syncRoles($this->roleid); //Sincroniza en la tabla model_has_roles el role_idpara que los roles se apliquen correctamente

        if($this->image)
        {
            $customFileName = uniqid().'_.'.$this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $user->image = $customFileName;
            $user->save();
        }

        $this->resetUI();
        $this->emit('item-added', 'Usuario registrado');
    }

    public function edit(User $user)
    {
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->roleid = $user->role_id;
        $this->status = $user->status;
        $this->password = "";
        $this->image = null;
        $this->selected_id = $user->id;

        $this->emit("show-modal", "show modal!");
    }

    public function update()
    {
        $rules = [
            'name' => 'required|min:3',
            'phone' => 'numeric',
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'status' => 'required',
            'roleid' => 'required',
            'password' => 'required|min:3'
        ];

        $messages = [
            'name.required' => 'Requerido',
            'name.min' => 'Debe contener mínimo 3 carácteres',
            'phone' => 'Solo números',
            'email.required' => 'Requerido',
            'email.unique' => 'Email ya existe',
            'email.email' => 'Formato no válido',
            'status.required' => 'Requerido',
            'roleid.required' => 'Requerido',
            'password.required' => 'Requerido',
            'password.min' => 'Mímimo 3 caracteres'
        ];

        $this->validate($rules, $messages);

        $user = User::find($this->selected_id);

        $user->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
            'password' => bcrypt($this->password),
            'role_id' => $this->roleid
        ]);

        $user->syncRoles($this->roleid);

        if($this->image)
        {
            $customFileName = uniqid().'_.'.$this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $imageName = $user->image;

            $user->image = $customFileName;
            $user->save();

            if($imageName != "")
            {
                if(file_exists('storage/users/'.$imageName))
                {
                    unlink('storage/users/'.$imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('item-updated', 'Usuario actualizado');
    }

    public function destroy(User $user)
    {
        if ($user->sales->count() == 0)
        {
            $imageName = $user->image;//Imagen temporal
            $user->delete();

            if ($imageName != null)
            {
                unlink('storage/users/'.$imageName);
            }

            $this->resetUI();
            $this->emit('item-deleted', 'Usuario eliminado');
        }
        else
        {
            $this->resetUI();
            $this->emit('error-delete', '¡¡No se puede eliminar el usuario porque tiene ventas relacionadas!!');
        }
    }
}
