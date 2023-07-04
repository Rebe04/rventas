<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center">
                    <b>{{$componentName}}</b>
                </h4>
            </div>
            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="row">
                            <div class="col-sm-12">
                                @can('Reportes_Select_User')
                                <h6>Elige el usuario</h6>
                                <div class="form-group">
                                    <select wire:model="userId" class="form-control">
                                        <option value="0">Todos</option>
                                        @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endcan
                            </div>
                            <div class="col-sm-12">
                                @can('Reportes_Select_Type')
                                <h6>Elige el Tipo de reporte</h6>
                                <div wire:model="reportType" class="form-group">
                                    <select class="form-control">
                                        <option value="0">Ventas del día</option>
                                        <option value="1">Ventas por fecha</option>
                                    </select>
                                </div>
                                @endcan
                            </div>
                            <div class="col-sm-12">
                                @can('Reportes_F_Ini')
                                <h6>Fecha desde</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateFrom" class="form-control flatpickr"
                                        placeholder="Click para elegir">
                                </div>
                                @endcan
                            </div>
                            <div class="col-sm-12">
                                @can('Reportes_F_Fin')
                                <h6>Fecha hasta</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateTo" class="form-control flatpickr"
                                        placeholder="Click para elegir">
                                </div>
                                @endcan
                            </div>
                            <div class="col-sm-12">
                                @can('Reportes_Consultar')
                                <button class="btn btn-dark btn-block" wire:click="$refresh">
                                    Consultar
                                </button>
                                @endcan
                                @can('Reportes_Generate_PDF')
                                <a class="btn btn-danger btn-block {{count($data) < 1 ? 'disabled' : ''}}"
                                    target="_blank"
                                    href="{{route('reporte-pdf', ['user' => $userId, 'type' => $reportType, 'f1' => $dateFrom, 'f2' => $dateTo])}}">
                                    Generar PDF
                                </a>
                                @endcan
                                @can('Reportes_Generate_Excel')
                                <a class="btn btn-success btn-block {{count($data) < 1 ? 'disabled' : ''}}"
                                    target="_blank"
                                    href="{{route('reporte-excel', ['user' => $userId, 'type' => $reportType, 'f1' => $dateFrom, 'f2' => $dateTo])}}">
                                    Exportar a excel
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        {{-- TABLA --}}
                        @can('Reportes_View_Data')
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-1">
                                <thead class="text-white" style="background:#3b3f5c;">
                                    <tr>
                                        <th class="table-th text-white text-center">FOLIO</th>
                                        <th class="table-th text-white text-center">TOTAL</th>
                                        <th class="table-th text-white text-center">ITEMS</th>
                                        <th class="table-th text-white text-center">ESTADO</th>
                                        <th class="table-th text-white text-center">USUARIO</th>
                                        <th class="table-th text-white text-center">FECHA</th>
                                        <th class="table-th text-white text-center" width="50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) < 1) <tr>
                                        <td colspan="7">
                                            <h5>Sin resultados</h5>
                                        </td>
                                        </tr>
                                        @else
                                        @foreach ($data as $d)
                                        <tr>
                                            <td class="text-center">
                                                <h6>{{$d->id}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>${{number_format($d->total, 2)}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->items}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->status}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->user}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{\Carbon\Carbon::parse($d->created_at)->format('d-m-Y')}}</h6>
                                            </td>
                                            <td class="text-center" width="50px">
                                                @can('Reportes_View_Details')
                                                <button wire:click.prevent="getDetails({{$d->id}})"
                                                    class="btn btn-dark btn-sm">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                </tbody>
                            </table>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
    @can('Reportes_View_Details')
    @include('livewire.reports.sales-detail')
    @endcan
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                longhand: [
                "Domingo",
                "Lunes",
                "Martes",
                "Miércoles",
                "Jueves",
                "Viernes",
                "Sábado",
                ],
            },
            months: {
                shorthand: [
                "Ene",
                "Feb",
                "Mar",
                "Abr",
                "May",
                "Jun",
                "Jul",
                "Ago",
                "Sep",
                "Oct",
                "Nov",
                "Dic",
                ],
                longhand: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre",
                ],
            },
            }
        })

        // eventos
        window.livewire.on('show-modal', msj => {
            $('#modalDetails').modal('show');
        })
    })
</script>