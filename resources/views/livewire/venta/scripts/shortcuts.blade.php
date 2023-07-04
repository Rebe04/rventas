<script>
    var listener = new window.keypress.Listener();

    listener.simple_combo("f9", function() {
        livewire.emit("saveSale");
    });

    listener.simple_combo("f8", function() {
        document.getElementById("hiddenTotal").value='';
        document.getElementById("cash").value='';
        document.getElementById("cash").focus();
        livewire.emit("clearChangeCash");
    });

    listener.simple_combo("f4", function() {
        var total = parseFloat(document.getElementById("hiddenTotal").value)
        if (total > 0) {
            confirm(0, 'clearCart', '¿Seguro que quieres eliminar el carrito?')   
        }else{
            noty('Agrega productos a la venta')
        }
    });

</script>