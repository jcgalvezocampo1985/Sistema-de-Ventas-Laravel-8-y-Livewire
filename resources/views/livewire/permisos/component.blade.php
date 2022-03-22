@can('permisos_index')
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    @can('permisos_create')
                    <li>
                        <a href="javascript:void(0);" class="tabmenu bg-dark" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                    @endcan
                </ul>
            </div>
            @can('permisos_search')
            @include('common.searchBox');
            @endcan
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c;">
                            <tr>
                                <th class="table-th text-white text-center">ID</th>
                                <th class="table-th text-white text-center">Nombre</th>
                                <th class="table-th text-white text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $permiso)
                            <tr>
                                <td>
                                    <h6>{{ $permiso->id }}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{ $permiso->name }}</h6>
                                </td>
                                <td class="text-center">
                                    @can('permisos_update')
                                        <a href="javascript:void(0);" wire:click="edit({{ $permiso->id }})" class="btn btn-dark mtmobile" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('permisos_destroy')
                                        <a href="javascript:void(0);" onclick="Confirm('{{ $permiso->id }}','{{ $permiso->roles->count() }}')" class="btn btn-dark" title="Delete"><i class="fas fa-trash"></i></a>
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
    @include('livewire.permisos.form');
</div>
@else
{{ abort(403) }}
@endcan
@include('common.scripts');
