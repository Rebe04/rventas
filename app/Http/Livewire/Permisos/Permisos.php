<?php

namespace App\Http\Livewire\Permisos;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permisos extends Component
{

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $permissionName, $search, $selected_id, $pageTitle, $componentName;
    protected $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Permisos';
    }

    public function render()
    {
        if (strlen($this->search)) {
            $permissions = Permission::where('name', 'LIKE', '%' . $this->search . '%')
                ->paginate($this->pagination);
        } else {
            $permissions = Permission::orderBy('name', 'asc')
                ->paginate($this->pagination);
        }
        return view('livewire.permisos.permisos', compact('permissions'))
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createPermission()
    {
        $rules = [
            'permissionName' => 'required|min:2|unique:permissions,name'
        ];

        $messages = [
            'permissionName.required' => 'El nombre del permiso es requerido',
            'permissionName.unique' => 'El nombre del permiso ya existe',
            'permissionName.min' => 'El nombre del permiso debe tener minimo 2 caracteres'
        ];

        $this->validate($rules, $messages);

        Permission::create([
            'name' => $this->permissionName,
        ]);

        $this->emit('permiso-added', 'Se registró el permiso con éxito');
        $this->resetUI();
    }

    public function edit(Permission $permission)
    {
        $this->selected_id = $permission->id;
        $this->permissionName = $permission->name;

        $this->emit('show-modal', 'Show modal');
    }

    public function updatePermission()
    {
        $rules = [
            'permissionName' => "required|min:2|unique:permissions,name, {$this->selected_id}"
        ];

        $messages = [
            'permissionName.required' => 'El nombre del permiso es requerido',
            'permissionName.unique' => 'El nombre del permiso ya existe',
            'permissionName.min' => 'El nombre del permiso debe tener minimo 2 caracteres'
        ];

        $this->validate($rules, $messages);

        $permission = Permission::find($this->selected_id);

        $permission->name = $this->permissionName;
        $permission->save();

        $this->emit('permiso-updated', 'Se actualizó el permiso con éxito');
        $this->resetUI();
    }

    protected $listeners = [
        'destroy' => 'destroy'
    ];

    public function destroy(Permission $permission)
    {
        $rolesCount = $permission->getRoleNames()->count();

        if ($rolesCount > 0) {
            $this->emit('permiso-error', 'No se puede eliminar el permiso porque tiene roles asociados');
            return;
        }

        $permission->delete();
        $this->emit('permiso-deleted', 'Se eliminó el permiso con éxito');
    }

    public function resetUI()
    {
        $this->permissionName = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
