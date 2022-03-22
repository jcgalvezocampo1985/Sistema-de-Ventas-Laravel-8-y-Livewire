@can('denominations_index')
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                @can('denominations_create')
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0);" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                </ul>
                @endcan
            </div>
            @can('denominations_search')
            @include('common.searchBox');
            @endcan
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c;">
                            <tr>
                                <th class="table-th text-white text-center">Tipo</th>
                                <th class="table-th text-white text-center">Valor</th>
                                <th class="table-th text-white text-center">Imagen</th>
                                <th class="table-th text-white text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $denomination)
                            <tr>
                                <td><h6>{{ $denomination->type }}</h6></td>
                                <td><h6>${{ number_format($denomination->value, 2) }}</h6></td>
                                <td class="text-center">
                                    <span>
                                        <img src="{{ asset('storage/denominations/'.$denomination->imagen) }}"alt="Imagen de ejemplo" height="50" width="60" class="rounded" />
                                    </span>
                                </td>
                                <td class="text-center">
                                    @can('denominations_update')
                                        <a href="javascript:void(0);" wire:click="edit({{ $denomination->id }})" class="btn btn-dark mtmobile" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('denominations_destroy')
                                        <a href="javascript:void(0);" onclick="Confirm('{{ $denomination->id }}')" class="btn btn-dark" title="Delete"><i class="fas fa-trash"></i></a>
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
    @include('livewire.denominations.form');
</div>
@else
{{ abort(403) }}
@endcan
@include('common.scripts');