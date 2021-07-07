<?php
	$prefixwbp = $rulewbp[strlen($antrian['wbp'])];
	$prefixkantor = $rulekantor[strlen($antrian['kantor'])];
	//echo $chart;
?>
<br>
<div class="container">
	<div class="row">
		<div class="col-7 text-center">
			<div class="col-12 text-center bg-light m-3 p-1 round25">
				<h2>INDEKS KEPUASAN MASYARAKAT</h2>
			</div>
			
			<canvas id="myChart" class="bg-light m-2 round25" height="222"></canvas>
		</div>
		<div class="col-5 text-center">
						
			<div class="col-12 text-center bg-light m-2 round25">
				<h3>Pengunjung Virtual</h3>
				<b><div id="txtvirtual" class="text60"><?= $antrian['virtual']-1; ?></div></b>
			</div>
			<div class="col-12 text-center bg-light m-2 round25">
				<h3>Penitipan Barang</h3>
				<b><div id="txtbarang" class="text60"><?= $antrian['barang']-1; ?></div></b>				
			</div>			
			<div class="col-12 text-center bg-light m-2 round25">
				<h3>Pelayanan Integrasi</h3>
				<b><div id="txtwbp" class="text60"><?= $antrian['wbp']-1; ?></div></b>
			</div>
			
			<div class="col-12 text-center bg-light m-2 round25">
				<h3>Tamu Dinas</h3>
				<b><div id="txtkantor" class="text60"><?= $antrian['kantor']-1; ?></div></b>
			</div>

		</div>
	</div>
</div>
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
	/*
	while ($i < count($ikm))
	{
		$a=$ikm[$i]['indeks'];
		$namaindeks .= "'". $indeks[$a]. "', ";
		$jumlah .= $ikm[$i]['jumlah']-1 . ", ";
		$i++;
	}
	*/
	
?>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var datachart = <?= $chart;?>;
	var optionsNoAnimation = {title: {display: false,text: 'Indeks Kepuasan Masyarakat'}};
	//var barchart = new Chart(ctx);
	//alert({title: {display: false,text: 'Indeks Kepuasan Masyarakat'}});
	//barchart.Bar(datachart, optionsAnimation); 
	var barchart = new Chart(ctx, {
		type: 'bar',
			data: datachart,
			options: optionsNoAnimation	
		});
		
	//alert(barchart.data.datasets[1].data[0]);
	//barchart.data.datasets[0].data[0] = 50;
	//barchart.update();
	
	
	setInterval(function(){
		$.ajax({url: "<?= base_url(); ?>/ajaxikm", success: function(data){
			//alert(data);
			var databaru = data.split(",");
			barchart.data.datasets[0].data[0] = databaru[0];
			barchart.data.datasets[1].data[0] = databaru[1];
			barchart.data.datasets[2].data[0] = databaru[2];
			barchart.data.datasets[3].data[0] = databaru[3];
			barchart.update();
			//alert(databaru[4]);
			$('#txtvirtual').html(databaru[4]);
			$('#txtbarang').html(databaru[5]);
			$('#txtwbp').html(databaru[6]);
			$('#txtkantor').html(databaru[7]);
		}});
	}, 3000);
	
</script>