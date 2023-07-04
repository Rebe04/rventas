<script>
    document.addEventListener('DOMContentLoaded', function(){
        $(".tblscroll").niceScroll({
        cursorcolor: "#515365",
        cursorwidth: "5px",
        background: "rgba(20,20,20,0.3)",
        cursorborder: "0px",
        cursorborderradius: 3
        });
    })
    function confirm(id, eventName, text)
    {
        swal({
            title: 'ATENCIÓN',
            text: text,
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'Aceptar',
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit(eventName, id)
                swal.close();
            }
        })
    }
    
</script>