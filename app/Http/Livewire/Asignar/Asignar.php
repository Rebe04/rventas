<?php

namespace App\Http\Livewire\Asignar;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Asignar extends Component
{

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $role, $componentName, $permisosSelected = [], $old_permissions = [];
    private $pagination = 10;

    public function mount()
    {
        $this->role = 'Elegir';
        $this->componentName = 'Asignar permisos';
    }

    public function render()
    {
        $permisos = Permission::select('name', 'id', DB::raw("0 as checked"))
            ->orderBy('name', 'asc')
            ->paginate($this->pagination);

        if ($this->role != 'Elegir') {
            $list = Permission::join('role_has_permissions as rp', 'rp.permission_id', 'permissions.id')
                ->where('role_id', $this->role)
                ->pluck('permissions.id')
                ->toArray();

            $this->old_permissions = $list;
        }

        if ($this->role != 'Elegir') {
            foreach ($permisos as $permiso) {
                $role = Role::find($this->role);
                $tienePermiso = $role->hasPermissionTo($permiso->name);

                if ($tienePermiso) {
                    $permiso->checked = 1;
                }
            }
        }

        $roles = Role::orderBy('name', 'asc')->get();

        return view('livewire.asignar.asignar', compact('permisos', 'roles'))
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public $listeners = [
        'revokeall' => 'removeAll'
    ];

    public function removeAll()
    {
        if ($this->role == 'Elegir') {
            $this->emit('sync-error', 'Selecciona un role válido');
            return;
        }

        $role = Role::find($this->role);

        $role->syncPermissions([0]);
        $this->emit('removeall', "todos los permisos del rol $role->name han sido revocados");
    }

    public function syncAll()
    {
        if ($this->role == 'Elegir') {
            $this->emit('sync-error', 'Selecciona un role válido');
            return;
        }

        $role = Role::find($this->role);
        $permisos = Permission::pluck('id')->toArray();

        $role->syncPermissions($permisos);
        $this->emit('syncall', "todos los permisos del rol $role->name han sido sincronizados");
    }

    public function syncPermiso($state, $permisoName)
    {
        if ($this->role != 'Elegir') {
            $roleName = Role::find($this->role);

            if ($state) {
                $roleName->givePermissionTo($permisoName);
                $this->emit('permi', "Permiso asignado correctamente");
            } else {
                $roleName->revokePermissionTo($permisoName);
                $this->emit('permi', "Permiso revocado correctamente");
            }
        } else {
            $this->emit('permi', 'Elige un role válido');
        }
    }
}
