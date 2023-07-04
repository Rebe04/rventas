<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title text-center"> <b>Corte de caja</b> </h4>
            </div>
            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        @can('Cortes_Select_User')
                        <div class="form-group">
                            <label>Usuario</label>
                            <select class="form-control" wire:model="userid">
                                <option value="0" disabled>Elegir</option>
                                @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                            @error('userid')
                            <span clas="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        @endcan
                    </div>
                    <div class="col-sm-12 col-md-3">
                        @can('Cortes_F_Ini')
                        <div class="form-group">
                            <label>Fecha inicial</label>
                            <input type="date" class="form-control" wire:model.lazy="fromDate">
                            @error('fromDate')
                            <span clas="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        @endcan
                    </div>
                    <div class="col-sm-12 col-md-3">
                        @can('Cortes_F_Fin')
                        <div class="form-group">
                            <label>Fecha final</label>
                            <input type="date" class="form-control" wire:model.lazy="toDate">
                            @error('toDate')
                            <span clas="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        @endcan
                    </div>
                    <div class="col-sm-12 col-md-3 align-self-center d-flex justify-content-around">
                        @can('Cortes_Consultar')
                        @if ($userid > 0 && $fromDate != null && $toDate != null)
                        <button wire:click.prevent="consultar" type="button" class="btn btn-dark">
                            <i class="fas fa-search mr-2"></i> Consultar
                        </button>
                        @endif
                        @endcan
                        @can('Cortes_Imprimir')
                        @if ($total > 0)
                        <button wire:click.prevent="print()" type="button" class="btn btn-secondary">
                            <i class="fas fa-print mr-2"></i> Imprimir
                        </button>
                        @endif
                        @endcan
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                @can('Cortes_Totales')
                <div class="col-sm-12 col-md-4 mbmobile">
                    <div class="connect-sorting bg-dark">
                        <h5 class="text-white">
                            Ventas totales: ${{number_format($total,2)}}
                        </h5>
                        <h5 class="text-white">
                            Artículos: {{$items}}
                        </h5>
                    </div>
                </div>
                @endcan
                <div class="col-sm-12 col-md-8">
                    @can('Cortes_T_Total')
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt1">
                            <thead class="text-white" style="background: #3b3f5f">
                                <tr>
                                    <th class="table-th text-center text-white">
                                        FOLIO
                                    </th>
                                    <th class="table-th text-center text-white">
                                        TOTAL
                                    </th>
                                    <th class="table-th text-center text-white">
                                        ITEMS
                                    </th>
                                    <th class="table-th text-center text-white">
                                        FECHA
                                    </th>
                                    <th class="table-th text-center text-white" width="10">
                                        ACTIONS
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($total <= 0) <tr>
                                    <td colspan="5">
                                        <h6 class="text-center">No hay ventas en la fecha seleccionada</h6>
                                    </td>
                                    </tr>
                                    @endif

                                    @foreach ($sales as $sale)
                                    <tr>
                                        <td class="text-center">
                                            <h6>{{$sale->id}}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>${{number_format($sale->total,2)}}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{$sale->items}}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{$sale->created_at}}</h6>
                                        </td>
                                        <td class="text-center">
                                            <button wire:click.prevent="viewDetails({{$sale}})"
                                                class="btn btn-dark btn-sm">
                                                <i class="fas fa-list"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    @can('Cortes_Modal_Details')
    @include('livewire.cashout.modal-details')
    @endcan
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('show-modal', msj => {
            $('#modal-details').modal('show');
        })
    })
</script>