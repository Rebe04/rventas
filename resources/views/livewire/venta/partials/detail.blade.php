@can('Ventas_List')
<div class="connect-sorting">
    <div class="connect-sorting-content">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                @if ($total > 0)
                <div class="table-responsive tblscroll" style="max-height: 650px; overflow: hidden">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c">
                            <tr>
                                <th width="10%"></th>
                                <th class="table-th text-left text-white">DESCRIPCIÓN</th>
                                <th class="table-th text-center text-white">PRECIO</th>
                                <th width="13%" class="table-th text-center text-white">CANT</th>
                                <th class="table-th text-center text-white">IMPORTE</th>
                                <th class="table-th text-center text-white">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $product)
                            <tr>
                                <td class="text-center table-th">
                                    @if (count($product->attributes) > 0)
                                    <span>
                                        <img src="{{asset('storage/products/' . $product->attributes[0])}}" alt="Imagen"
                                            width="90" class="rounded">
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <h6>{{$product->name}}</h6>
                                </td>
                                <td class="text-center">
                                    ${{number_format($product->price, 2)}}
                                </td>
                                <td>
                                    <input type="number" id="r{{$product->id}}"
                                        wire:change="updateQty({{$product->id}}, $('#r' + {{$product->id}}).val())"
                                        style="font-size: 1rem !important" class="for-control text-center"
                                        value="{{$product->quantity}}">
                                </td>
                                <td class="text-center">
                                    <h6>
                                        ${{number_format($product->price * $product->quantity, 2)}}
                                    </h6>
                                </td>
                                <td class="text-center">
                                    <button href="javascript:void(0)" class="btn btn-danger mbmobile"
                                        onclick="confirm('{{$product->id}}', 'removeItem', '¿Seguro que quieres eliminar este producto de la lista?')"
                                        title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                    <button wire:click.orevent="decreaseQty({{$product->id}})"
                                        class="btn btn-dark mbmobile">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                    <button wire:click.orevent="increaseQty({{$product->id}})"
                                        class="btn btn-dark mbmobile">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-plus-circle">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="16"></line>
                                            <line x1="8" y1="12" x2="16" y2="12"></line>
                                        </svg>
                                    </button>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <h5 class="text-center text-muted">Agrega productos a la venta</h5>
                @endif
                <div wire:loading.inline wire:target="saveSale">
                    <h4 class="text-danfer text-center">Guardando venta...</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan