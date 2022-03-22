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
            $('.er').css('display', 'none');
            $('#theModal').modal('hide');
        });

        window.livewire.on('show-modal', msg => {
            $('.er').css('display', 'none');
            $('#theModal').modal('show');
        });

        $("#theModal").on('hidden.bs.modal', msg => {
            $('.er').css('display', 'none');
        });

        window.livewire.on('error-delete', msg => {
            Swal.fire({
                icon: 'error',
                title: '¡¡Aviso!!',
                text: msg
            })
        });

        flatpickr(document.getElementsByClassName('flatpickr'), {
            enabledTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstdayOfWeek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                },
                months: {
                shorthand: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                longhand: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                },
            }
        })
    });

    function Confirm(id, valor = 0)
    {
        if(valor > 0)
        {
            Swal.fire({
                icon: 'error',
                title: '¡¡Aviso!!',
                text: '¡¡No se puede eliminar porque tiene registros relacionados!!'
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
