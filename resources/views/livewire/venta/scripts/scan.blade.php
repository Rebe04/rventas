<script>
    try {
        onScan.attachTo(document, {
        suffixKeyCodes: [13],
        osScan: function(barcode) {
            console.log(barcode);
            window.livewire.emit('scan-code', barcode);
        },
        onScanError: function(e) {
            console.log(e);
        }
    })
    console.log('Scanner ready!')
    } catch (e) {
        console.log('Error de lectura' + e);
    }
</script>