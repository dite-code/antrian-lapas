<?php
	$height = 538;
?>
<div class="container">
	<div class="row">
		<div class="col-7 text-center">
			<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
				<div class="carousel-inner  m-3">
					<div class="carousel-item active">
						<img src="images/slide/img1.jpeg" height="<?= $height;?>" class="d-block w-100 round25" alt="...">
					</div>
					<div class="carousel-item">
						<img src="images/slide/img2.jpeg" height="<?= $height;?>" class="d-block w-100 round25" alt="...">
					</div>
					<div class="carousel-item">
						<img src="images/slide/img3.jpeg" height="<?= $height;?>" class="d-block w-100 round25" alt="...">
					</div>
					<div class="carousel-item">
						<img src="images/slide/img4.jpeg" height="<?= $height;?>" class="d-block w-100 round25" alt="...">
					</div>
					<div class="carousel-item">
						<img src="images/slide/img5.jpeg" height="<?= $height;?>" class="d-block w-100 round25" alt="...">
					</div>
					<div class="carousel-item">
						<img src="images/slide/img6.jpeg" height="<?= $height;?>" class="d-block w-100 round25" alt="...">
					</div>
				</div>

			</div>
			
		</div>
		<div class="col-5 text-center">
			<div class="col-12 text-center bg-warning m-2 round25">
				<h3>Kunjungan Virtual</h3>
				<b><div id="txtvirtual" class="text60"><?= $prefixvirtual.$antrian['antrivirtual']; ?></div></b>
			</div>
			<div class="col-12 text-center bg-warning m-2 round25">
				<h3>Penitipan Barang</h3>
				<b><div id="txtbarang" class="text60"><?= $prefixbarang.$antrian['antribarang']; ?></div></b>
			</div>
			<div class="col-12 text-center bg-warning m-2 round25">
				<h3>Layanan Integrasi</h3>
				<b><div id="txtwbp" class="text60"><?= $prefixwbp.$antrian['antriwbp']; ?></div></b>
			</div>
			<div class="col-12 text-center bg-warning m-2 round25">
				<h3>Tamu Dinas</h3>
				<b><div id="txtkantor" class="text60"><?= $prefixkantor.$antrian['antrikantor']; ?></div></b>
			</div>
		</div>
	</div>
</div>

<audio id="myAudio">
  <source src="virtual000.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>

<?php
    //Inisialisasi nilai variabel awal
    $indeks = array(
	1=>"Sangat Puas",
	2=>"Puas",
	3=>"Kurang Puas",
	4=>"Tidak Puas"
	);
	$namaindeks="";
    $jumlah=null;
	$i=0;
	//dd($ikm);
	while ($i < count($ikm))
	{
		$a=$ikm[$i]['indeks'];
		$namaindeks .= "'". $indeks[$a]. "', ";
		$jumlah .= $ikm[$i]['jumlah']-1 . ", ";
		$i++;
	}
	
?>
<script>
	
	var audio = '<?= base_url(); ?>/audio/';
	var x = document.getElementById("myAudio"); 
	var prefixvirtual = ['','A00','A0','A'];
	var prefixbarang = ['','B00','B0','B'];
	var prefixwbp = ['','C00','C0','C'];
	var prefixkantor = ['','D00','D0','D'];
	
	
	function tts(txt){
		responsiveVoice.speak(
			txt,
			"Indonesian Female",
			{
				pitch: 1, 
				rate: 0.8, 
				volume: 1
			}
		);
	}
	
	
	setInterval(function(){
		$.ajax({url: "<?= base_url(); ?>/ajaxantrian", success: function(data){
			//alert(data);
			var databaru = data.split("|");
			$('#txtvirtual').html(prefixvirtual[databaru[0].length]+databaru[0]);
			$('#txtbarang').html(prefixbarang[databaru[1].length]+databaru[1]);
			$('#txtwbp').html(prefixwbp[databaru[2].length]+databaru[2]);
			$('#txtkantor').html(prefixkantor[databaru[3].length]+databaru[3]);
			if (databaru[4]!=""){
				//if(responsiveVoice.isPlaying()){alert("play");}
				//responsiveVoice.speak(databaru[4],"Indonesian Female",{pitch: 1, rate: 0.9, volume: 1});
				//tts(databaru[4]);
				//x.src = audio + databaru[4] + ".mp3";
				//alert(x.src);
				//x.play();
			}
		}});
	}, 1000);
		
		
		//setTimeout(responsiveVoice.speak("Test Suara Sukses", "Indonesian Female"),50);
</script>		