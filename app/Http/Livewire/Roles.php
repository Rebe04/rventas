<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Spatie\Permission\Models\Role;

class Roles extends Component
{

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $roleName, $search, $selected_id, $pageTitle, $componentName;
    protected $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Roles';
    }

    public function render()
    {
        if (strlen($this->search)) {
            $roles = Role::where('name', 'LIKE', '%' . $this->search . '%')
                ->paginate($this->pagination);
        } else {
            $roles = Role::orderBy('name', 'asc')
                ->paginate($this->pagination);
        }

        return view('livewire.roles.roles', compact('roles'))
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createRole()
    {
        $rules = [
            'roleName' => 'required|min:2|unique:roles,name'
        ];

        $messages = [
            'roleName.required' => 'El nombre del role es requerido',
            'roleName.unique' => 'El nombre del role ya existe',
            'roleName.min' => 'El nombre del role debe tener minimo 2 caracteres'
        ];

        $this->validate($rules, $messages);

        Role::create([
            'name' => $this->roleName,
        ]);

        $this->emit('role-added', 'Se registró el role con éxito');
        $this->resetUI();
    }

    public function edit(Role $role)
    {
        $this->selected_id = $role->id;
        $this->roleName = $role->name;

        $this->emit('show-modal', 'Show modal');
    }

    public function updateRole()
    {
        $rules = [
            'roleName' => "required|min:2|unique:roles,name, {$this->selected_id}"
        ];

        $messages = [
            'roleName.required' => 'El nombre del role es requerido',
            'roleName.unique' => 'El nombre del role ya existe',
            'roleName.min' => 'El nombre del role debe tener minimo 2 caracteres'
        ];

        $this->validate($rules, $messages);

        $role = Role::find($this->selected_id);

        $role->name = $this->roleName;
        $role->save();

        $this->emit('role-updated', 'Se actualizó el role con éxito');
        $this->resetUI();
    }

    protected $listeners = [
        'destroy' => 'destroy'
    ];

    public function destroy(Role $role)
    {
        $permissionsCount = $role->permissions->count();

        if ($permissionsCount > 0) {
            $this->emit('role-error', 'No se puede eliminar el role porque tiene permisos asociados');
            return;
        }

        $role->delete();
        $this->emit('role-deleted', 'Se eliminó el role con éxito');
    }

    public function resetUI()
    {
        $this->roleName = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
