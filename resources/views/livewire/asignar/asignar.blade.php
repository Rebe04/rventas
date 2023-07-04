<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}}</b>
                </h4>
            </div>
            <div class="widget-content">
                <div class="form-inline">
                    <div class="form-group mr-5">
                        @can('Asignar_Select_Role')
                        <select class="form-control" wire:model="role">
                            <option value="Elegir" selected>Seleccione el Role</option>
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        @endcan
                    </div>
                    @can('Asignar_All')
                    <button type="button" class="btn btn-dark mbmobile inblock mr-5" wire:click.prevent="syncAll()">
                        Sincronizar todos
                    </button>
                    @endcan
                    @can('Asignar_Revocar_All')
                    <button type="button" class="btn btn-dark mbmobile inblock mr-5" onclick="revocar()">
                        Revocar todos
                    </button>
                    @endcan
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-1">
                                <thead class="text-white" style="background:#3b3f5c;">
                                    <tr>
                                        <th class="table-th text-white text-center">ID</th>
                                        <th class="table-th text-white text-center">PERMISO</th>
                                        <th class="table-th text-white text-center">ROLES ASIGNADOS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permisos as $permiso)
                                    <tr>
                                        <td>
                                            <h6 class="text-center">
                                                {{$permiso->id}}
                                            </h6>
                                        </td>
                                        <td class="text-left">
                                            <div class="n-check">
                                                <label class="new-control new-checkbox checkbox-primary">
                                                    @can('Asignar_Check')
                                                    <input type="checkbox"
                                                        wire:change="syncPermiso($('#p' + {{ $permiso->id }}).is(':checked'), '{{ $permiso->name }}')"
                                                        id="p{{ $permiso->id }}" value="{{ $permiso->id }}"
                                                        class="new-control-input" {{$permiso->checked == 1 ? 'checked' :
                                                    ''}}>
                                                    <span class="new-control-indicator mr-3">
                                                    </span>
                                                    @endcan
                                                    <h6>
                                                        {{$permiso->name}}
                                                    </h6>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <h6>
                                                {{ \App\Models\User::permission($permiso->name)->count() }}
                                            </h6>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>

                                    </tr>
                                </tbody>
                            </table>
                            {{$permisos->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('sync-error', msj => {
            noty(msj)
        })

        window.livewire.on('permi', msj => {
            noty(msj)
        })

        window.livewire.on('syncall', msj => {
            noty(msj)
        })

        window.livewire.on('removeall', msj => {
            noty(msj)
        })
    })

    function revocar()
    {
        swal({
            title: 'ATENCIÓN',
            text: '¿Estás seguro de que deseas revocar todos los permisos?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'Aceptar',
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('revokeall')
                swal.close();
            }
        })
    }
</script>