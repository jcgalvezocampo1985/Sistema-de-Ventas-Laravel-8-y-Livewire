<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0);" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                </ul>
            </div>
            @include('common.searchBox');
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
                                    <a href="javascript:void(0);" wire:click="edit({{ $denomination->id }})" class="btn btn-dark mtmobile" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="javascript:void(0);" onclick="Confirm('{{ $denomination->id }}')" class="btn btn-dark" title="Delete"><i class="fas fa-trash"></i></a>
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
<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('item-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('show-modal', function() {
            $('.er').css('display', 'none');
            $('#theModal').modal('show');
        });
        $("#theModal").on('hidden.bs.modal', msg => {
            $('.er').css('display', 'none');
        });
    });

    function Confirm(id)
    {
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
