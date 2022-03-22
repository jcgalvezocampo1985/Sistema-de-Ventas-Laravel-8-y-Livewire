<script>
    try{
        onScan.attachTo(document, {
            suffixKeyCodes: [13], // enter-key expected at the end of a scan
            onScan: function(barcode) { // Alternative to document.addEventListener('scan')
                console.log(barcode);
                windows.livewire.emit('scan-code', barcode);
            },
            onScanError: function(e){
                console.log(e);
            }
        });

        console.log('Scanner ready!');
    }
    catch(e){
        console.log('Error de lectura: ', e);
    }
</script>