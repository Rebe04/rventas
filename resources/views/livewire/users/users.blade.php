<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    @can('User_Create')
                    <li>
                        <a href="javascript:void(0)" class="tab-menu bg-dark" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                    @endcan
                </ul>
            </div>
            @can('User_Search')
            @include('common.searchbox')
            @endcan
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background:#3b3f5c;">
                            <tr>
                                <th class="table-th text-white">IMAGEN</th>
                                <th class="table-th text-white">USUARIO</th>
                                <th class="table-th text-white">TELÉFONO</th>
                                <th class="table-th text-white">EMAIL</th>
                                <th class="table-th text-white">STATUS</th>
                                <th class="table-th text-white">PERFIL</th>
                                <th class="table-th text-white">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td class="text-center">
                                    <span>
                                        <img src="{{asset('storage/' . $user->imagen)}}" alt="Imagen"
                                            class="rounded-circle" style="object-fit: cover;" width="80" height="80">
                                    </span>
                                </td>
                                <td>
                                    <h6>
                                        {{$user->name}}
                                    </h6>
                                </td>
                                <td>
                                    <h6>
                                        {{$user->phone}}
                                    </h6>
                                </td>
                                <td>
                                    <h6>
                                        {{$user->email}}
                                    </h6>
                                </td>
                                <td>
                                    <span
                                        class="badge {{$user->status == 'Active' ? 'badge-success' : 'badge-danger'}} text-uppercase">
                                        {{$user->status}}
                                    </span>
                                </td>
                                <td>
                                    <h6 class="text-uppercase">
                                        {{$user->profile}}
                                    </h6>
                                </td>
                                <td>
                                    @can('User_Update')
                                    <a href="javascript:void(0)" wire:click="edit({{$user->id}})"
                                        class="btn btn-dark mtmobile" title="Editar Registro">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('User_Destroy')
                                    <a href="javascript:void(0)" onclick="confirm('{{$user->id}}')"
                                        class="btn btn-danger" title="Eliminar registro">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$users->links()}}
                </div>
            </div>
        </div>
    </div>
    @can('User_Create')
    @include('livewire.users.form')
    @endcan
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        window.livewire.on('user-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        })

        window.livewire.on('user-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        })

        window.livewire.on('user-deleted', msg => {
            noty(msg)
        })

        window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide');
        })

        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });

        window.livewire.on('users-withsales', msg => {
            noty(msg)
        })

    })

    function confirm(id)
    {
        swal({
            title: 'ATENCIÓN',
            text: '¿Estás seguro de que deseas eliminar este usuario?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'Aceptar',
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                swal.close();
            }
        })
    }
</script>