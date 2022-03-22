@can('category_index')
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    
                    @can('category_create')
                    <li>
                        <a href="javascript:void(0);" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                    @endcan
                </ul>
            </div>
            @can('category_search')
            @include('common.searchBox');
            @endcan
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c;">
                            <tr>
                                <th class="table-th text-white text-center">Descripción</th>
                                <th class="table-th text-white text-center">Imagen</th>
                                <th class="table-th text-white text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $category)
                            <tr>
                                <td>
                                    <h6>{{ $category->name }}</h6>
                                </td>
                                <td class="text-center"><span><img src="{{ asset('storage/categories/'.$category->imagen) }}" alt="Imagen de ejemplo" height="50" width="60" class="rounded" /></span></td>
                                <td class="text-center">
                                    @can('category_update')
                                    <a href="javascript:void(0);" wire:click="edit({{ $category->id }})" class="btn btn-dark mtmobile" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('category_destroy')
                                    <a href="javascript:void(0);" onclick="Confirm('{{ $category->id }}','{{ $category->products->count() }}')" class="btn btn-dark" title="Delete"><i class="fas fa-trash"></i></a>
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
    @include('livewire.category.form');
</div>
@else
{{ abort(403) }}
@endcan
@include('common.scripts');
