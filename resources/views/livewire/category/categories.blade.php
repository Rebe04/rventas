<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    @can('Category_Create')
                    <li>
                        <a href="javascript:void(0)" class="tab-menu bg-dark" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                    @endcan
                </ul>
            </div>
            @can('Category_Search')
            @include('common.searchbox')
            @endcan
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background:#3b3f5c;">
                            <tr>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-white">NOMBRE DE CATEGORÍA</th>
                                <th class="table-th text-white text-center" colspan="2">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td class="text-center" width="20px">
                                    <span>
                                        <img src="{{asset('storage/categories/' . $category->imagen)}}" alt="Imagen"
                                            width="80" class="rounded">
                                    </span>
                                </td>
                                <td>
                                    <h6>{{$category->name}}</h6>
                                </td>
                                <td class="text-center" width="50px">
                                    @can('Category_Update')
                                    <a href="javascript:void(0)" class="btn btn-dark btn-sm mt-mobile" title="Edit"
                                        wire:click="edit({{$category->id}})">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                </td>
                                <td class="text-center" width="50px">
                                    @can('Category_Destroy')
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger" title="Delete"
                                        onclick="confirm('{{$category->id}}', '{{$category->products->count()}}')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$categories->links()}}
                </div>
            </div>
        </div>
    </div>
    @can('Category_Create')
    @include('livewire.category.form')
    @endcan
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('category-added', msg => {
            $('#theModal').modal('hide');
            noty(msg);
        });

        window.livewire.on('category-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg);
        });

        window.livewire.on('category-deleted', msg => {
            noty(msg);
        });

        window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });

    });

    function confirm(id, products)
    {
        if (products > 0) {
            swal('No se puede eliminar la categoría porque tiene productos relacionados')
            return;
        }
        swal({
            title: 'ATENCIÓN',
            text: '¿Estás seguro de que deseas eliminar esta categoría?',
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