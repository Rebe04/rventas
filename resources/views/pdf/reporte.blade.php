<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>reporte de ventas</title>
    <link rel="stylesheet" href="{{asset('css/custom_pdf.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom_page.css')}}">
</head>

<body>
    <section class="header" style="top: -287px">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td colspan="2" class="text-center">
                    <span style="font-size: 25px; font-weight: bold">
                        Sistema RVentas
                    </span>
                </td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top; padding-top: 10px; position: relative">
                    <img class="invoice-logo" src="{{asset('assets/img/Logo.png')}}" alt="">
                </td>

                <td class="text-left text-company" style="vertical-align: top; padding-top: 10px" width="70%">
                    @if ($reportType == 0)
                    <span style="font-size: 16px">
                        <strong>Reporte de ventas por día</strong>
                    </span>
                    @else
                    <span style="font-size: 16px">
                        <strong>Reporte de ventas por fechas</strong>
                    </span>
                    @endif
                    <br>
                    @if ($reportType != 0)
                    <span style="font-size: 16px">
                        <strong>Fecha de consulta: {{$dateFrom}} - {{$dateTo}}</strong>
                    </span>
                    @else
                    <span style="font-size: 16px">
                        <strong>Fecha de consulta: {{\Carbon\Carbon::now()->format('d-M-Y')}}</strong>
                    </span>
                    @endif
                    <br>
                    <span style="font-size: 14px">
                        Usuario: {{$user}}
                    </span>
                </td>
            </tr>
        </table>

    </section>

    <section style="margin-top: -110px">
        <table cellspacing="0" cellpadding="0" width="100%" class="table-items">
            <thead>
                <tr>
                    <th width="10%">FOLIO</th>
                    <th width="12%">IMPORTE</th>
                    <th width="10%">ITEMS</th>
                    <th width="12%">STATUS</th>
                    <th>USUARIO</th>
                    <th width="18%">FECHA</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td align="center">{{$item->id}}</td>
                    <td align="center">{{number_format($item->id)}}</td>
                    <td align="center">{{$item->items}}</td>
                    <td align="center">{{$item->status}}</td>
                    <td align="center">{{$item->user}}</td>
                    <td align="center">{{\Carbon\Carbon::parse($item->created_at)->format('d-M-Y')}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center">
                        <span><b>TOTALES</b></span>
                    </td>
                    <td class="text-center" colspan="1">
                        <span>
                            <strong>
                                ${{number_format($data->sum('total', 2))}}
                            </strong>
                        </span>
                    </td>
                    <td class="text-center">
                        {{$data->sum('items')}}
                    </td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
    </section>

    <section class="footer">
        <table cellspacing="0" cellpadding="0" width="100%" class="table-items">
            <tr>
                <td width="20%">
                    <span>Sistema RVentas V1.0</span>
                </td>
                <td class="text-center" width="60%">
                    estebanbenitezdev.com
                </td>
                <td class="text-center" width="20%">
                    página <span class="pagenum"></span>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>
