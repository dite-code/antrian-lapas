<br>
<div class="container">
	<div class="row">
		<div class="col-5 text-right">
			<button type="button" class="btn btn-primary btn-lg shadow-sm round25 col-8" onclick="PrintVirtual()">
				<h3>KUNJUNGAN<BR>VIRTUAL<br><div id="txtvirtual"><?= $prefixvirtual.$antrian['virtual']; ?></div></h3>
				<input type="hidden" id="novirtual" value="<?= $antrian['virtual']; ?>" />
			</button>
		</div>
		<div class="col-2 text-center">
		</div>
		<div class="col-5 text-left">
			<button type="button" class="btn btn-primary btn-lg shadow-sm round25 col-8" onclick="PrintBarang()">
				<h3>PENITIPAN<BR>BARANG<br><div id="txtbarang"><?= $prefixbarang.$antrian['barang']; ?></div></h3>
				<input type="hidden" id="nobarang" value="<?= $antrian['barang']; ?>" />
			</button>
		</div>
	</div>
</div>
<BR>
<div class="container">
	<div class="row">
		<div class="col-4 text-left">
			<button type="button" class="btn btn-primary btn-lg round25 col-10" onclick="PrintWBP()">
				<h3>PELAYANAN<BR>WBP<br><div id="txtwbp"><?= $prefixwbp.$antrian['wbp']; ?></div></h3>
				<input type="hidden" id="nowbp" value="<?= $antrian['wbp']; ?>" />
			</button>
		</div>
		<div class="col-4 text-center">
			<span class="badge bg-warning text-dark round25 p-3"><h4>PELAYANAN KOMUNIKASI<BR>MASYARAKAT<BR>(YANKOMAS)</h4></span>
		</div>
		<div class="col-4 text-right">
			<button type="button" class="btn btn-primary btn-lg round25 col-10" onclick="PrintKantor()">
				<h3>TAMU<BR>DINAS<br><div id="txtkantor"><?= $prefixkantor.$antrian['kantor']; ?></div></h3>
				<input type="hidden" id="nokantor" value="<?= $antrian['kantor']; ?>" />
			</button>
		</div>
	</div>
</div>
<br>
<br>
<div class="container">
	<div class="row">
		<div class="col-12 text-center text-uppercase fs-3 fw-bolder text-white">
			bagaimana penilaian anda terhadap pelayanan kami?
		</div>
		<div class="col-3 text-center">
			<img class="btn btn-light round25" data-bs-toggle="modal" 
			data-bs-target="#aksi_menu"
			data-ket="1" src="images/ikm/1.png"width="150">
		</div>
		<div class="col-3 text-center">
			<img class="btn btn-light round25" data-bs-toggle="modal" 
			data-bs-target="#aksi_menu"
			data-ket="2" src="images/ikm/2.png"width="150">
		</div>
		<div class="col-3 text-center">
			<img class="btn btn-light round25" data-bs-toggle="modal" 
			data-bs-target="#aksi_menu"
			data-ket="3" src="images/ikm/3.png"width="150">
		</div>
		<div class="col-3 text-center">
			<img class="btn btn-light round25" data-bs-toggle="modal" 
			data-bs-target="#aksi_menu"
			data-ket="4" src="images/ikm/4.png"width="150">
		</div>
	</div>
</div>

<div class="modal animated zoomInDown" id="aksi_print" role="dialog" aria-labelledby="editlabel">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content  bg-warning">
            <div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
			<div class="modal-body text-center">
                <h3 class="modal-title">Terima Kasih</h3>
				<div class="bigtext">Silahkan Beri Penilaian Pada Kami Di Bawah Ini</div>
				
			</div>
		</div>
	</div>
</div>


<div class="modal animated zoomInUp" id="aksi_menu" role="dialog" aria-labelledby="editlabel">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content bg-warning">
            <div class="modal-header">
                <h5 class="modal-title" id="modallabel"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
			<div class="modal-body text-center">
				<div id="infomodal" class="bigtext"></div>
				
			</div>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	var type = 'RECEIPT';
	
	function PrintVirtual() {
		$('#aksi_print').modal("show");
		
		var url="<?= base_url(); ?>/tiketantrian/Kunjungan%20Virtual/" + $('#txtvirtual').html();
		var evt = document.createEvent('CustomEvent');
		evt.initCustomEvent('chromeHardwareEvent', true, false, {action: 'print', type: type, 'url': url});
		document.dispatchEvent(evt);
		window.close();
	
		$.ajax({url: "<?= base_url(); ?>/addvirtual/<?= $antrian['id']; ?>/" + $('#novirtual').val(), success: function(data){
			var databaru = data.split(",");
			if (databaru[0] == 'true') {
				$('#txtvirtual').html(databaru[1]+databaru[2]);
				$('#novirtual').val(databaru[2]);	
				//window.location.reload();
			} 
			else {
				alert(data);
			}
		}});
		setTimeout(function(){ $('#aksi_print').modal("hide"); }, 3000);
	}

	function PrintBarang() {
		$('#aksi_print').modal("show");
		var url="<?= base_url(); ?>/tiketantrian/Penitipan%20Barang/" + $('#txtbarang').html();
		var evt = document.createEvent('CustomEvent');
		evt.initCustomEvent('chromeHardwareEvent', true, false, {action: 'print', type: type, 'url': url});
		document.dispatchEvent(evt);
		window.close();
	
		$.ajax({url: "<?= base_url(); ?>/addbarang/<?= $antrian['id']; ?>/" + $('#nobarang').val(), success: function(data){
			var databaru = data.split(",");
			if (databaru[0] == 'true') {
				$('#txtbarang').html(databaru[1]+databaru[2]);
				$('#nobarang').val(databaru[2]);	
				//window.location.reload();
			} 
			else {
				alert(data);
			}
		}});
	}

	function PrintWBP() {
		$('#aksi_print').modal("show");
		var url="<?= base_url(); ?>/tiketantrian/Pelayanan%20WBP/" + $('#txtwbp').html();
		var evt = document.createEvent('CustomEvent');
		evt.initCustomEvent('chromeHardwareEvent', true, false, {action: 'print', type: type, 'url': url});
		document.dispatchEvent(evt);
		window.close();
	
		$.ajax({url: "<?= base_url(); ?>/addwbp/<?= $antrian['id']; ?>/" + $('#nowbp').val(), success: function(data){
			var databaru = data.split(",");
			if (databaru[0] == 'true') {
				$('#txtwbp').html(databaru[1]+databaru[2]);
				$('#nowbp').val(databaru[2]);	
				//window.location.reload();
			} 
			else {
				alert(data);
			}
		}});
	}

	function PrintKantor() {
		$('#aksi_print').modal("show");
		var url="<?= base_url(); ?>/tiketantrian/Tamu%20Dinas/" + $('#txtkantor').html();
		var evt = document.createEvent('CustomEvent');
		evt.initCustomEvent('chromeHardwareEvent', true, false, {action: 'print', type: type, 'url': url});
		document.dispatchEvent(evt);
		window.close();
	
		$.ajax({url: "<?= base_url(); ?>/addkantor/<?= $antrian['id']; ?>/" + $('#nokantor').val(), success: function(data){
			var databaru = data.split(",");
			if (databaru[0] == 'true') {
				$('#txtkantor').html(databaru[1]+databaru[2]);
				$('#nokantor').val(databaru[2]);	
				//window.location.reload();
			} 
			else {
				alert(data);
			}
		}});
	}


$('#aksi_menu').on('shown.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var ket = button.data('ket');
	//alert(ket);
	if (ket==1){
		$('#infomodal').html("Yeay, Terima Kasih Telah Memberikan Nilai Terbaik");
	//$('#modallabel').html("Terima Kasih");
	}
	else if(ket==2){
	$('#infomodal').html("Terima Kasih, Telah Menilai Kami");
	//$('#modallabel').html("Terima Kasih");
	}
	else if(ket==3){
	$('#infomodal').html("Cukup Puas");
	//$('#modallabel').html("Terima Kasih");
	}
	else if(ket==4){
	$('#infomodal').html("Tidak Puas");
	//$('#modallabel').html("Terima Kasih");
	}
	//alert(ket);
	$.ajax({url: "<?= base_url(); ?>/addikm/"+ket, success: function(data){/*alert(data);*/}});
	setTimeout(function(){ $('#aksi_menu').modal("hide"); }, 3000);
	})
	
	setInterval(function(){
		$.ajax({url: "<?= base_url(); ?>/ajaxantrian", success: function(data){
			//alert(data);
			var databaru = data.split("|");
			if (databaru[4]!=""){
				//if(responsiveVoice.isPlaying()){alert("play");}
				responsiveVoice.speak(databaru[4],"Indonesian Female",{pitch: 1, rate: 0.9, volume: 1});
				//tts(databaru[4]);
				//x.src = audio + databaru[4] + ".mp3";
				//alert(x.src);
				//x.play();
			}
		}});
	}, 500);
	
	setTimeout(function(){
		//if(responsiveVoice.isPlaying()){alert("play");}
		//responsiveVoice.speak("Inisiasi Suara Sukses", "Indonesian Female")
		//if(responsiveVoice.isPlaying()) {alert("I hope you are listening");}
		responsiveVoice.speak("Inisiasi Suara Sukses", "Indonesian Female");
	},50);
	
</script>					