<?php 
	$prefixkantor = $rulekantor[strlen($antrian['antrikantor'])];
	$kantor=$prefixkantor.$antrian['antrikantor'];
	$textkantor=$kantor[0].",. ".$kantor[1]." ".$kantor[2]." ".$kantor[3];
?>
<br>
<div class="container">
	<div class="row">
		<div class="col-12 text-center p-3">
			<input id="antrian" type="hidden" value="<?= $antrian['antrikantor'];?>">
			<input id="antrianmax" type="hidden" value="<?= $antrian['kantor'];?>">
			<button type="button" class="btn btn-light btn-lg round25" onclick="play('Antrian Nomor. <?= $textkantor?>, Silahkan ke Teler 1.')">
				<h1>Panggil Antrian</h1>
				<p class="card-text">Antrian kantor</p>
				<h1><div id="prefixantrian" class="d-inline" ><?= $prefixkantor.$antrian['antrikantor']; ?></div>/<div id="prefixantrianmax" class="d-inline" ><?= $prefixkantor.$antrian['kantor']; ?></div></h1>
			</button>
		</div>
		<div class="col-6 text-center">
			<button type="button" class="btn btn-warning btn-lg round25" onclick="sebelumnya()">
				<h1>Pilih Antrian</h1>
				<p class="card-text">Sebelumnya</p>
				<h1 id="prefixantrianprev"><?= $prefixkantor.($antrian['antrikantor']-1); ?></h1>
			</button>
		</div>
		<div class="col-6 text-center">
			<button type="button" class="btn btn-success btn-lg round25" onclick="berikutnya()">
				<h1>Pilih Antrian</h1>
				<p class="card-text">Berikutnya</p>
				<h1 id="prefixantriannext"><?= $prefixkantor.($antrian['antrikantor']+1); ?></h1>
			</button>
		</div>
	</div>
</div>
<br>
<script>
	var prefix = ['','B00','B0','B'];
	var antrian = $('#antrian');
	var antrianmax = $('#antrianmax');
	
	function play (txt){
		//alert($('#antrian').val());
		var len = antrian.val().length;
		noantri = prefix[len]+antrian.val(); 
		var txt = "Antrian Nomor. "+ noantri[0] + ",. "+noantri[1]+" "+noantri[2]+" "+noantri[3]+", Silahkan ke Loket kantor.";
		//alert(txt);
		responsiveVoice.speak(
		txt,
		"Indonesian Female",
		{
			pitch: 1, 
			rate: 0.8, 
			volume: 1
		}
		);
		$.ajax({url: "<?= base_url(); ?>/addantrikantor/<?= $antrian['id'].'/'.$antrian['antrikantor']?>", success: function(data){
			//alert("data");
		}});

	}
	
	function berikutnya()
	{
		var a = parseInt(antrian.val());
		var b = parseInt(antrianmax.val());
		if (a<b){
			antrian.val(a+1);
			penerapan();
		}
	}
	
	function sebelumnya()
	{
		var a = parseInt(antrian.val());
		antrian.val(a-1);
		penerapan();
	}
	
	function penerapan()
	{
		var a = parseInt(antrian.val());
		var len = antrian.val().length;
		$('#prefixantrian').html(prefix[len] + a);
		$('#prefixantrianprev').html(prefix[len] + (a-1));
		$('#prefixantriannext').html(prefix[len] + (a+1));
		
	}
	
	setInterval(function(){
		$.ajax({url: "<?= base_url(); ?>/getlastkantor", success: function(data){
			//alert(data);
			var a = parseInt(data);
			var len = data.length;
			$('#antrianmax').val(data);
			$('#prefixantrianmax').html(prefix[len] + a);
		
		}});
	}, 5000);
	

	
</script>