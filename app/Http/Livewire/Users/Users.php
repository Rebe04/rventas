<?php

namespace App\Http\Livewire\Users;

use App\Models\Sale;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Users extends Component
{

    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = "bootstrap";

    public $componentName, $pageTitle, $search, $name, $phone, $email, $status, $image, $password, $selected_id, $fileLoaded, $profile;
    private $pagination = 5;

    public function mount()
    {
        $this->componentName = "Usuarios";
        $this->pageTitle = "Listado";
        $this->status = "Elegir";
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $users = User::where('name', 'LIKE', '%' . $this->search . '%')
                ->orderBy('name', 'asc')
                ->paginate($this->pagination);
        } else {
            $users = User::orderBy('name', 'asc')
                ->paginate($this->pagination);
        }

        $roles = Role::orderBy('name', 'asc')->get();

        return view('livewire.users.users', compact('users', 'roles'))
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetUI()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->image = null;
        $this->search = '';
        $this->status = 'Elegir';
        $this->selected_id = 0;
        $this->profile = 'Elegir';
        $this->resetValidation();
        $this->resetPage();
    }

    public function edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->phone = $user->phone;
        $this->image = null;
        $this->profile = $user->profile;
        $this->status = $user->status;

        $this->emit('show-modal', 'Open modal');
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI',
    ];

    public function store()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|unique:users,email|email',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3'
        ];

        $messages = [
            'name.required' => 'Ingresa el nombre',
            'name.min' => 'El nombre del usuario debe ser mayor a 3 caracteres',
            'email.required' => 'Ingresa un correo',
            'email.unique' => 'Este correo ya se encuentra asignado a otro usuario',
            'email.email' => 'Ingrese un email válido ej: useremil@example.com',
            'status.required' => 'Seleccione el estatus para le usuario',
            'ststus.not_in' => 'Seleccione un estatus válido',
            'profile.required' => 'Seleccione el role del usuario',
            'profile.not_in' => 'Seleccione un role válido',
            'password.required' => 'Ingrese la contraseña',
            'password.min' => 'La contraseña debe ser mayor a 3 caracteres'
        ];

        $this->validate($rules, $messages);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password)
        ]);

        $user->syncRoles($this->profile);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $user->image = $customFileName;
            $user->save();
        }

        $this->resetUI();
        $this->emit('user-added', 'Usuario registrado');
    }

    public function update()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3'
        ];

        $messages = [
            'name.required' => 'Ingresa el nombre',
            'name.min' => 'El nombre del usuario debe ser mayor a 3 caracteres',
            'email.required' => 'Ingresa un correo',
            'email.unique' => 'Este correo ya se encuentra asignado a otro usuario',
            'email.email' => 'Ingrese un email válido ej: useremil@example.com',
            'status.required' => 'Seleccione el estatus para le usuario',
            'ststus.not_in' => 'Seleccione un estatus válido',
            'profile.required' => 'Seleccione el role del usuario',
            'profile.not_in' => 'Seleccione un role válido',
            'password.required' => 'Ingrese la contraseña',
            'password.min' => 'La contraseña debe ser mayor a 3 caracteres'
        ];

        $this->validate($rules, $messages);

        $user = User::find($this->selected_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password)
        ]);

        $user->syncRoles($this->profile);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $imageTemp = $user->image;
            $user->image = $customFileName;
            $user->save();

            if ($imageTemp != null) {
                if (file_exists('storage/users/' . $imageTemp)) {
                    unlink('storage/users/' . $imageTemp);
                }
            }
        }

        $this->resetUI();
        $this->emit('user-updated', 'Usuario actualizado');
    }

    public function destroy(User $user)
    {
        if ($user) {
            $sales = Sale::where('user_id', $user->id)->count();
            if ($sales > 0) {
                $this->emit('user-withsales', 'No es posible eliminar el usuario porque tiene ventas registradas');
            } else {
                $user->delete();
                $this->resetUI();
                $this->emit('user-deleted', 'Usuario eliminado');
            }
        }
    }
}
