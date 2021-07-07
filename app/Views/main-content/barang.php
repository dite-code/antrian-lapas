<div class="container">
	<div class="row">
		<div class="col-12 text-center p-3">
			<button id="btnext" type="button" class="btn btn-success btn-lg round25 col-12" onclick="berikutnya()" disabled>
				<h2>Panggil Antrian</h2>
				<p class="card-text">Berikutnya</p>
				<h1 id="prefixantriannext"><?= $prefixbarang.($antrian['antribarang']+1); ?></h1>
			</button>
		</div>
		<div class="col-12 text-center p-3">
			<input id="antrian" type="hidden" value="<?= $antrian['antribarang'];?>">
			<input id="antrianmax" type="hidden" value="<?= $antrian['barang'];?>">
			<button type="button" class="btn btn-light btn-lg round25 col-12" onclick="play('Antrian Nomor. <?= $textbarang;?>, Silahkan ke Teler 1.')">
				<h2>Panggil Antrian</h2>
				<p class="card-text">Antrian barang</p>
				<h1><div id="prefixantrian" class="d-inline" ><?= $prefixbarang.$antrian['antribarang']; ?></div>/<div id="prefixantrianmax" class="d-inline" ><?= $prefixbarang.$antrian['barang']; ?></div></h1>
			</button>
		</div>
		<div class="col-12 text-center p-3">
			<button type="button" class="btn btn-warning btn-lg round25 col-12" onclick="sebelumnya()">
				<h2>Pilih Antrian</h2>
				<p class="card-text">Sebelumnya</p>
				<h1 id="prefixantrianprev"><?= $prefixbarang.($antrian['antribarang']-1); ?></h1>
			</button>
		</div>
	</div>
</div>
<br>
<script>
	var prefix = ['','B00','B0','B'];
	var antrian = $('#antrian');
	var antrianmax = $('#antrianmax');
	
	function play (){
		//alert($('#antrian').val());
		var len = antrian.val().length;
		noantri = prefix[len]+antrian.val(); 
		var txt = "Antrian Nomor. "+ noantri[0] + ",. "+noantri[1]+" "+noantri[2]+" "+noantri[3]+", Silahkan ke Loket Penitipan Barang.";
		//alert(txt);
		
		//tts(txt);
		//alert("<?= base_url(); ?>/addtts/<?= $antrian['id'];?>/"+txt,);
		$.ajax({url: "<?= base_url(); ?>/addtts/<?= $antrian['id'];?>/"+txt, success: function(data){ if(data!="true"){alert(data);}}});
		
		//$.ajax({url: "<?= base_url(); ?>/addantribarang/<?= $antrian['id'].'/';?>"+antrian.val(), success: function(data){		//alert("data");}});
	}

	function tts(txt){
		responsiveVoice.speak(
			txt,
			"Indonesian Female",
			{
				pitch: 1, 
				rate: 0.9, 
				volume: 1
			}
		);
	}

	function berikutnya()
	{
		var a = parseInt(antrian.val());
		var b = parseInt(antrianmax.val());
		
		$.ajax({url: "<?= base_url(); ?>/nextbarang/<?= $antrian['id'].'/';?>"+(a), success: function(data){
			//alert(data);
			var databaru = data.split(",");;
			antrian.val(databaru[0]);
			antrianmax.val(databaru[1]);
			var a = parseInt(databaru[1]);
			var len = databaru[1].length;
			$('#prefixantrianmax').html(prefix[len] + a);
			penerapan();
			if (parseInt(antrianmax.val()) <= parseInt(antrian.val())){
				//alert(parseInt(antrianmax.val())+" | "+antrian.val());
				$('#btnext').prop('disabled',true);
			}
			var len = antrian.val().length;
			noantri = prefix[len]+antrian.val(); 
			var txt = "Antrian Nomor. "+ noantri[0] + ",. "+noantri[1]+" "+noantri[2]+" "+noantri[3]+", Silahkan ke Loket Penitipan Barang.";
			//var txt = "barang"+noantri[1]+noantri[2]+noantri[3];
			//tts(txt);
			$.ajax({url: "<?= base_url(); ?>/addtts/<?= $antrian['id'];?>/"+txt, success: function(data){ if(data!="true"){alert(data);}}});
			
		}});

	}
	
	function sebelumnya()
	{
		var a = parseInt(antrian.val());
		if(a>1){
		antrian.val(a-1);
		var len = antrian.val().length;
			$('#prefixantrian').html(prefix[len] + (a-1));
			$('#prefixantrianprev').html(prefix[len] + (a-1));
		}
		
	}
	
	function penerapan()
	{
		var a = parseInt(antrian.val());
		var len = antrian.val().length;
		$('#prefixantrian').html(prefix[len] + a);
		if(a>0){
			$('#prefixantrianprev').html(prefix[len] + (a-1));
		}
		$('#prefixantriannext').html(prefix[len] + (a+1));
		
	}
	
	setInterval(function(){
		$.ajax({url: "<?= base_url(); ?>/getlastbarang", success: function(data){
			//alert(data);
			var a = parseInt(data);
			var len = data.length;
			if(data > parseInt(antrianmax.val())){
				//alert();
				$('#antrianmax').val(data);
			}
			else if (data <= parseInt(antrian.val())){
				$('#btnext').prop('disabled',true);
			}
			else {
				$('#btnext').prop('disabled',false);
			}
			$('#prefixantrianmax').html(prefix[len] + a);
		}});
	}, 1000);
	
</script>