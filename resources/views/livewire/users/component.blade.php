@can('users_index')
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    @can('users_create')
                    <li>
                        <a href="javascript:void(0);" class="tabmenu bg-dark" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                    @endcan
                </ul>
            </div>
            @can('users_search')
            @include('common.searchBox');
            @endcan
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c;">
                            <tr>
                                <th class="table-th text-white text-center">Usuario</th>
                                <th class="table-th text-white text-center">Teléfono</th>
                                <th class="table-th text-white text-center">Email</th>
                                <th class="table-th text-white text-center">Perfil</th>
                                <th class="table-th text-white text-center">Estatus</th>
                                <th class="table-th text-white text-center">Imagen</th>
                                <th class="table-th text-white text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $user)
                            <tr>
                                <td><h6>{{ $user->name }}</h6></td>
                                <td class="text-center"><h6>{{ $user->phone }}</h6></td>
                                <td class="text-center"><h6>{{ $user->email }}</h6></td>
                                <td class="text-center"><h6>{{ $user->role }}</h6></td>
                                <td class="text-center">
                                    <span class="badge {{ $user->status == 'Active' ?  'badge-success' : 'badge-danger' }} text-uppercase">{{
                                        $user->status }}</span>
                                </td>
                                <td class="text-center">
                                    @if($user->image != null)
                                        <img src="{{ asset('storage/users/'.$user->imagen) }}" height="90" alt="Imagen" class="card-img-top" />
                                    @endif
                                </td>
                                <td class="text-center">
                                    @can('users_update')
                                        <a href="javascript:void(0);" wire:click="edit({{ $user->id }})" class="btn btn-dark mtmobile" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('users_destroy')
                                        <a href="javascript:void(0);" onclick="Confirm('{{ $user->id }}', '{{ $user->sales->count() }}')" class="btn btn-dark" title="Delete"><i class="fas fa-trash"></i></a>
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
    @include('livewire.users.form');
</div>
@else
{{ abort(403) }}
@endcan
@include('common.scripts');
