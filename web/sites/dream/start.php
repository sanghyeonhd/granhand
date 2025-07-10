<script src="https://scert.mobile-ok.com/resources/js/index.js"></script>
<script>
const protocol = window.location.protocol.replace(':', ''); // 'http' 또는 'https'
		const domain = window.location.hostname;
    window.onload = function(){
        MOBILEOK.process(protocol+"://"+domain+"/dream/mok_std_requestm.php", "WB", "");	
    }
</script>
