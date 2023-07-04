<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    @can('Permission_Create')
                    <li>
                        <a href="javascript:void(0)" class="tab-menu bg-dark" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                    @endcan
                </ul>
            </div>
            @can('Permission_Search')
            @include('common.searchbox')
            @endcan
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background:#3b3f5c;">
                            <tr>
                                <th class="table-th text-white">ID</th>
                                <th class="table-th text-white">DESCRIPCIÓN</th>
                                <th class="table-th text-white">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td class="text-center">
                                    <h6>
                                        {{$permission->id}}
                                    </h6>
                                </td>
                                <td>
                                    <h6>
                                        {{$permission->name}}
                                    </h6>
                                </td>
                                <td class="text-center">
                                    @can('Permission_Update')
                                    <a href="javascript:void(0)" wire:click="edit({{$permission->id}})"
                                        class="btn btn-dark mtmobile" title="Editar Registro">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('Permission_Destroy')
                                    <a href="javascript:void(0)" onclick="confirm('{{$permission->id}}')"
                                        class="btn btn-danger" title="Eliminar registro">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$permissions->links()}}
                </div>
            </div>
        </div>
    </div>
    @can('Permission_Create')
    @include('livewire.permisos.form')
    @endcan
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('permiso-added', msg => {
            $('#theModal').modal('hide');
            noty(msg);
        });

        window.livewire.on('permiso-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg);
        });

        window.livewire.on('permiso-deleted', msg => {
            noty(msg);
        });

        window.livewire.on('permiso-exists', msg => {
            noty(msg);
        });

        window.livewire.on('permiso-error', msg => {
            noty(msg);
        });

        window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
    })

    function confirm(id)
    {
        swal({
            title: 'ATENCIÓN',
            text: '¿Estás seguro de que deseas eliminar este permiso?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'Aceptar',
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('destroy', id)
                swal.close();
            }
        })
    }
</script>