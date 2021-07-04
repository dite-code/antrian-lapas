<?php 
	$prefixwbp = $rulewbp[strlen($antrian['antriwbp'])];
	$wbp=$prefixwbp.$antrian['antriwbp'];
	$textwbp=$wbp[0].",. ".$wbp[1]." ".$wbp[2]." ".$wbp[3];
?>
<div class="container">
	<div class="row">
		<div class="col-12 text-center p-3">
			<input id="antrian" type="hidden" value="<?= $antrian['antriwbp'];?>">
			<input id="antrianmax" type="hidden" value="<?= $antrian['wbp'];?>">
			<button type="button" class="btn btn-light btn-lg round25" onclick="play('Antrian Nomor. <?= $textwbp;?>, Silahkan ke Teler 1.')">
				<h1>Panggil Antrian</h1>
				<p class="card-text">Antrian WBP</p>
				<h1><div id="prefixantrian" class="d-inline" ><?= $prefixwbp.$antrian['antriwbp']; ?></div>/<div id="prefixantrianmax" class="d-inline" ><?= $prefixwbp.$antrian['wbp']; ?></div></h1>
			</button>
		</div>
		<div class="col-6 text-center">
			<button type="button" class="btn btn-warning btn-lg round25" onclick="sebelumnya()">
				<h1>Pilih Antrian</h1>
				<p class="card-text">Sebelumnya</p>
				<h1 id="prefixantrianprev"><?= $prefixwbp.($antrian['antriwbp']-1); ?></h1>
			</button>
		</div>
		<div class="col-6 text-center">
			<button id="btnext" type="button" class="btn btn-success btn-lg round25" onclick="berikutnya()">
				<h1>Pilih Antrian</h1>
				<p class="card-text">Berikutnya</p>
				<h1 id="prefixantriannext"><?= $prefixwbp.($antrian['antriwbp']+1); ?></h1>
			</button>
		</div>
	</div>
</div>
<br>
<script>
	var prefix = ['','A00','A0','A'];
	var antrian = $('#antrian');
	var antrianmax = $('#antrianmax');
	
	function play (){
		//alert($('#antrian').val());
		var len = antrian.val().length;
		noantri = prefix[len]+antrian.val(); 
		var txt = "Antrian Nomor. "+ noantri[0] + ",. "+noantri[1]+" "+noantri[2]+" "+noantri[3]+", Silahkan ke Loket 1.";
		//alert(txt);
		
		tts(txt);
		//$.ajax({url: "<?= base_url(); ?>/addantriwbp/<?= $antrian['id'].'/';?>"+antrian.val(), success: function(data){		//alert("data");}});
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
		
		$.ajax({url: "<?= base_url(); ?>/nextwbp/<?= $antrian['id'].'/';?>"+(a), success: function(data){
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
			var txt = "Antrian Nomor. "+ noantri[0] + ",. "+noantri[1]+" "+noantri[2]+" "+noantri[3]+", Silahkan ke Loket 1.";
			tts(txt);
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
		$.ajax({url: "<?= base_url(); ?>/getlastwbp", success: function(data){
			//alert(data);
			var a = parseInt(data);
			var len = data.length;
			if(data > parseInt(antrianmax.val())){
				//alert();
				$('#btnext').prop('disabled',false);
				$('#antrianmax').val(data);
			}
			
			$('#prefixantrianmax').html(prefix[len] + a);
		}});
	}, 3000);
	
</script>