<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Reporte de Ventas</title>
        <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}" />
    </head>
    <body>
        <section class="header" style="top: -287px;">
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td colspan="2" class="text-center">
                        <span style="font-size: 25px; font-weight: bold;">Sistema LWPOS</span>
                    </td>
                </tr>
                <tr>
                    <td width="30%" style="vertical-align: top; padding-top: 10px; position: relative;">
                        <img src="{{ asset('assets/img/livewire.png') }}" alt="" class="invoice-logo" />
                    </td>
                    <td width="70%" class="text-left text-company" style="vertical-align: top;padding-top: 10px;">
                        @if($reportType == 0)
                            <span style="font-size: 16px;"><strong>Reporte de ventas del día</strong></span>
                        @else
                            <span style="font-size: 16px;"><strong>Reporte de ventas por fecha</strong></span>
                        @endif
                        <br />
                        @if($reportType != 0)
                            <span style="font-size: 16px;"><strong>Fecha de consulta: {{ $dateFrom }} al {{ $dateTo }}</strong></span>
                        @else
                            <span style="font-size: 16px;"><strong>Fecha de consulta: {{ \Carbon\Carbon::now()->format('d-M-Y') }}</strong></span>
                        @endif
                        <br />
                    <span style="font-size: 14px;">Usuario: {{ $user->name }}</span>
                    </td>
                </tr>
            </table>
        </section>
        <section style="margin-top: -110px;">
            <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
                <thead>
                    <tr>
                        <th width="10%">Folio</th>
                        <th width="12%">Importe</th>
                        <th width="10%">Items</th>
                        <th width="12%">Estatus</th>
                        <th>Usuario</th>
                        <th width="18%"">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td align="center">{{ $item->id }}</td>
                        <td align="center">${{ number_format($item->total, 2) }}</td>
                        <td align="center">{{ $item->items }}</td>
                        <td align="center">{{ $item->status }}</td>
                        <td align="center">{{ $item->user->name }}</td>
                        <td align="center">{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y h:i:s')}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-center">
                            <span><b>Totales</b></span>
                        </td>
                        <td colspan="1" class="text-center">
                            <span><b>${{ number_format($data->sum('total'), 2) }}</b></span>
                        </td>
                        <td class="text-center">
                            {{ $data->sum('items') }}
                        </td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        </section>
        <section class="footer">
            <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
                <tr>
                    <td width="20%"><span>Sistema LWPOS v1</span></td>
                    <td width="60%">@Galvez</td>
                    <td width="20%" class="text-center">
                        Página <span class="pagenum"></span>
                    </td>
                </tr>
            </table>
        </section>
    </body>
</html>