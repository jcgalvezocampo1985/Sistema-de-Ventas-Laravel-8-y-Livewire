<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bd-dark" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                </ul>
            </div>
            @include('common.searchBox');
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c;">
                            <tr>
                                <th class="table-th text-white">Descripción</th>
                                <th class="table-th text-white">Imagen</th>
                                <th class="table-th text-white">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>
                                    <h6>{{ $category->name }}</h6>
                                </td>
                                <td class="text-center"><span><img src="{{ asset('storage/categories/'.$category->image) }}" alt="Imagen de ejemplo" height="50" width="60" class="rounded" /></span></td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click="Edit({{ $category->id }})" class="btn btn-dark mtmobile" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="javascript:void(0)" onclick="Confirm('{{ $category->id }}','{{ $category->products->count() }}')" class="btn btn-dark" title="Delete"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.category.form');
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('category-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('category-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('category-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('hidden.bs.modal', msg => {
            $('.err').css('display', 'none');
        });
    });

    function Confirm(id, products)
    {
        if(products > 0)
        {
            Swal.fire({
                icon: 'error',
                title: '¡¡Aviso!!',
                text: '¡No se puede eliminar la categoria porque tiene productos relacionados!'
            })
            return;
        }
        swal({
            title: 'Confirmar',
            text: '¿Deseas eliminar el registro?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#3b3f5c',
        }).then(function(result){
            if(result.value){
                window.livewire.emit('deleteRow', id);
                swal.close();
            }
        })
    }
</script>
