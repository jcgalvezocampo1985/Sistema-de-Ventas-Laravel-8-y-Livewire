@can('products_index')
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    @can('products_create')
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                    @endcan
                </ul>
            </div>
            @can('products_search')
            @include('common.searchBox')
            @endcan
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c;">
                            <tr>
                                <th class="table-th text-white text-center">Nombre</th>
                                <th class="table-th text-white text-center">Barcode</th>
                                <th class="table-th text-white text-center">Categoría</th>
                                <th class="table-th text-white text-center">Precio</th>
                                <th class="table-th text-white text-center">Costo</th>
                                <th class="table-th text-white text-center">Stock</th>
                                <th class="table-th text-white text-center">Inv. Mín.</th>
                                <th class="table-th text-white text-center">Imagen</th>
                                <th class="table-th text-white text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $product):
                            <tr>
                                <td><h6>{{ $product->name }}</h6></td>
                                <td><h6>{{ $product->barcode }}</h6></td>
                                <td><h6>{{ $product->category->name }}</h6></td>
                                <td><h6>{{ $product->price }}</h6></td>
                                <td><h6>{{ $product->cost }}</h6></td>
                                <td><h6>{{ $product->stock }}</h6></td>
                                <td><h6>{{ $product->alerts }}</h6></td>
                                <td class="text-center"><span><img src="{{ asset('storage/products/'.$product->imagen) }}" alt="Imagen de ejemplo" height="70" width="80" class="rounded" /></span></td>
                                <td class="text-center">
                                    @can('products_update')
                                        <a href="javascript:void(0)" wire:click="edit({{ $product->category->id }})"class="btn btn-dark mtmobile" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('products_destroy')
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $product->category->id }}', '{{ $product->sale_details->count() }}')" class="btn btn-dark" title="Delete"><i class="fas fa-trash"></i></a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.products.form');
</div>
@else
{{ abort(403) }}
@endcan

@include('common.scripts');
