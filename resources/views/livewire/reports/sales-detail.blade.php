<div wire:ignore.self class="modal fade" id="modalDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Detalle de venta # {{$saleId}}</b>
                </h5>
                <h6 wire:loading class="text-center text-warning"> Por favor espere</h6>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background:#3b3f5c;">
                            <tr>
                                <th class="table-th text-white text-center">FOLIO</th>
                                <th class="table-th text-white text-center">PRODUCTO</th>
                                <th class="table-th text-white text-center">PRECIO</th>
                                <th class="table-th text-white text-center">CANTIDAD</th>
                                <th class="table-th text-white text-center">IMPORTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $detail)
                            <tr>
                                <td class="text-center">{{$detail->id}}</td>
                                <td class="text-center">{{$detail->product}}</td>
                                <td class="text-center">{{number_format($detail->price, 2)}}</td>
                                <td class="text-center">{{number_format($detail->quantity, 0)}}</td>
                                <td class="text-center">{{number_format($detail->price * $detail->quantity, 2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <h5 class="text-center font-weight-bold">TOTALES</h5>
                                </td>
                                <td>

                                    <h5 class="text-center">{{$countDetails}}</h5>
                                </td>
                                <td>
                                    <h5 class="text-center">{{number_format($sumDetails,2)}}</h5>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light close-modal" data-dismiss="modal">
                    CERRAR
                </button>
            </div>
        </div>
    </div>
</div>