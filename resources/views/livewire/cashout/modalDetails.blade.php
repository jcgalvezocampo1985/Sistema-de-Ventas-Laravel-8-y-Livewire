<div wire:ignore.self id="theModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Detalle ventas</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c;">
                            <tr>
                                <th class="table-th text-center text-white">Producto</th>
                                <th class="table-th text-center text-white">Cantidad</th>
                                <th class="table-th text-center text-white">Precio</th>
                                <th class="table-th text-center text-white">Importe</th>
                                <th class="table-th text-center text-white"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $myTotal = 0; @endphp
                            @foreach($details as $d)
                            @php $myTotal += $d->quantity * $d->price; @endphp
                            <tr>
                                <td class="text-center"><h6>{{ $d->product->name }}</h6></td>
                                <td class="text-center"><h6>{{ $d->quantity }}</h6></td>
                                <td class="text-center"><h6>${{ number_format($d->price, 2) }}</h6></td>
                                <td class="text-center"><h6>{{ number_format($d->quantity * $d->price, 2) }}</h6></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td class="text-right"><h6 class="text-info">Totales:</h6></td>
                            <td class="text-center">
                                @if($details)
                                    <h6 class="text-info">{{ $details->sum('quantity') }}</h6>
                                @endif
                            </td>
                            @if($details)
                                <td></td>
                                <td class="text-center"><h6 class="text-info">${{ number_format($myTotal, 2) }}</h6></td>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
