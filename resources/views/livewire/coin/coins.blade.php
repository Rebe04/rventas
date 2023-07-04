<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    @can('Coin_Create')
                    <li>
                        <a href="javascript:void(0)" class="tab-menu bg-dark" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                    @endcan
                </ul>
            </div>
            @can('Coin_Search')
            @include('common.searchbox')
            @endcan
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background:#3b3f5c;">
                            <tr>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-white text-center">TIPO</th>
                                <th class="table-th text-white text-center">VALOR</th>
                                <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coins as $coin)
                            <tr>
                                <td class="text-center">
                                    <span>
                                        <img src="{{asset('storage/' . $coin->imagen)}}" alt="Imagen" width="80"
                                            class="rounded">
                                    </span>
                                </td>
                                <td class="text-center">
                                    <h6>{{$coin->type}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>${{number_format($coin->value, 2)}}</h6>
                                </td>
                                <td class="text-center">
                                    @can('Coin_Update')
                                    <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Edit"
                                        wire:click.prevent="edit({{$coin->id}})">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('Coin_Destroy')
                                    <a href="javascript:void(0)" class="btn btn-danger mtmobile"
                                        onclick="confirm('{{$coin->id}}')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$coins->links()}}
                </div>
            </div>
        </div>
    </div>
    @can('Coin_Create')
    @include('livewire.coin.form')
    @endcan
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

window.livewire.on('item-added', msg => {
    $('#theModal').modal('hide');
    noty(msg);
});

window.livewire.on('item-updated', msg => {
    $('#theModal').modal('hide');
    noty(msg);
});

window.livewire.on('item-deleted', msg => {
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
swal({
    title: 'ATENCIÓN',
    text: '¿Estás seguro de que deseas eliminar este producto?',
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