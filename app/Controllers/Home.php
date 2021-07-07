<?php
	namespace App\Controllers;
	use Mpdf;
	use \MikrotikAPI\RouterosAPI;
	
	class Home extends BaseController
	{
		protected $migrate, $forge;
		protected $tabelantrian, $tabelikm;
		protected $rulewbp, $rulekantor;
		
		public function __construct()
		{
			$this->rulevirtual = array(
				1=>'A00',
				2=>'A0',
				3=>'A'
			);
			$this->rulebarang = array(
				1=>'B00',
				2=>'B0',
				3=>'B'
			);
			$this->rulewbp = array(
				1=>'C00',
				2=>'C0',
				3=>'C'
			);
			$this->rulekantor = array(
				1=>'D00',
				2=>'D0',
				3=>'D'
			);
			$this->migrate = \Config\Services::migrations();
			$this->tabelantrian = new \App\Models\AntrianModel();
			$this->tabelikm = new \App\Models\IKMModel();
			$this->forge = \Config\Database::forge();
		}
		
		public function tes(){
			$txt="setingan";
			$txt=htmlspecialchars($txt);
			$txt=rawurlencode($txt);
			$audio=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=en-IN');
			$speech="<audio controls='controls' autoplay></audio>";
			echo $speech;
		}
		
		public function index()
		{
			?>
			<script>
				//window.location.replace("<?= base_url(); ?>");
				//setTimeout(function(){window.location.replace("<?= base_url(); ?>/kiosk");}, 1000);
				//window.location.assign("https://www.w3schools.com")
				setTimeout(function(){ window.location.assign("<?= base_url(); ?>/kiosk") }, 1000);
			</script>
			<?php
		}
		
		public function kiosk()
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			if (count($antrian)==0){$antrian = $this->antrianbaru();}
			$data['prefixvirtual'] = $this->rulevirtual[strlen($antrian[0]['virtual'])];
			$data['prefixbarang']=$this->rulebarang[strlen($antrian[0]['barang'])];
			$data['prefixwbp']=$this->rulewbp[strlen($antrian[0]['wbp'])];
			$data['prefixkantor']=$this->rulekantor[strlen($antrian[0]['kantor'])];
			$data['title'] = ucfirst("home"); // Capitalize the first letter
			$data['isi'] = "home";
			$data['antrian']=$antrian[0];
			return view('main-layout/wraper',$data);
		}

		public function ikm()
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			$ikm = $this->tabelikm
				->groupBy('indeks')
				->select("*")
				->select("count(*) as jumlah")
				->findAll();
			$data['prefixvirtual'] = $this->rulevirtual[strlen($antrian[0]['antrivirtual'])];
			$data['prefixbarang']=$this->rulebarang[strlen($antrian[0]['antribarang'])];
			$data['prefixwbp']=$this->rulewbp[strlen($antrian[0]['antriwbp'])];
			$data['prefixkantor']=$this->rulekantor[strlen($antrian[0]['antrikantor'])];
			$data['title'] = ucfirst("ikm"); // Capitalize the first letter
			$data['isi'] = "ikm";
			$data['ikm']=$ikm;
			$data['antrian']=$antrian[0];
			return view('main-layout/wraper',$data);
		}

		public function kalapas()
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			$ikm = $this->tabelikm
				->groupBy('indeks')
				->select("*")
				->select("count(*) as jumlah")
				->findAll();
			$ikmhari = $this->tabelikm
				->where('year(tanggal)',date('Y'))
				->groupBy('tanggal')
				->groupBy('indeks')
				->orderBy('tanggal desc')
				->orderBy('indeks asc')
				->select("*")
				->select("count(*) as jumlah")
				->findAll();
			
			//dd ($ikmhari);
			$data['chart'] = datatochart7($ikmhari);
			
			$data['rulewbp']=$this->rulewbp;
			$data['rulekantor']=$this->rulekantor;
			$data['title'] = ucfirst("kalapas"); // Capitalize the first letter
			$data['isi'] = "kalapas";
			$data['ikm']=$ikm;
			$data['antrian']=$antrian[0];
			return view('main-layout/wraper',$data);
		}

		public function loket($no=1)
		{
			$data['title'] = ucfirst("Loket"); // Capitalize the first letter
			$data['isi'] = "loket";
			return view('main-layout/wraper-android',$data);
		}

		public function virtual($no=1)
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			$prefixvirtual = $this->rulevirtual[strlen($antrian[0]['antrivirtual'])];
			$virtual=$prefixvirtual.$antrian[0]['antrivirtual'];
			$textvirtual=$virtual[0].",. ".$virtual[1]." ".$virtual[2]." ".$virtual[3];
	
			if (count($antrian)==0){$antrian = $this->antrianbaru();}
			$data['antrian']=$antrian[0];
			$data['nowbp']=$no;
			$data['prefixvirtual']=$prefixvirtual;
			$data['textvirtual']=$textvirtual;
			$data['rulevirtual']=$this->rulevirtual;
			$data['title'] = ucfirst("virtual"); // Capitalize the first letter
			$data['isi'] = "virtual";
			return view('main-layout/wraper-android',$data);
		}
		
		
		public function addantrivirtual($id, $kode=0)
		{
			$data['id']=$id;
			$data['antrivirtual']=$kode;
			$this->tabelantrian->save($data);
			echo "true";
		}
		
		public function nextvirtual($id, $kode=0)
		{
			
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			if($kode<$antrian[0]['virtual']){
				echo ($antrian[0]['antrivirtual']+1).",".$antrian[0]['virtual'];
				$data['id']=$id;
				$data['antrivirtual']=$antrian[0]['antrivirtual']+1;
				$this->tabelantrian->save($data);
				//echo ",".$kode;
			}
			else{ 
				echo ($antrian[0]['antrivirtual']).",".$antrian[0]['virtual'];
				echo ",false";
			}
		}
		
		public function getlastvirtual()
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			echo $antrian[0]['virtual'];
		}


		public function barang($no=1)
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			$prefixbarang = $this->rulebarang[strlen($antrian[0]['antribarang'])];
			$barang=$prefixbarang.$antrian[0]['antribarang'];
			$textbarang=$barang[0].",. ".$barang[1]." ".$barang[2]." ".$barang[3];
	
			if (count($antrian)==0){$antrian = $this->antrianbaru();}
			$data['antrian']=$antrian[0];
			$data['nowbp']=$no;
			$data['prefixbarang']=$prefixbarang;
			$data['textbarang']=$textbarang;
			$data['rulebarang']=$this->rulebarang;
			$data['title'] = ucfirst("barang"); // Capitalize the first letter
			$data['isi'] = "barang";
			return view('main-layout/wraper-android',$data);
		}
		
		
		public function addantribarang($id, $kode=0)
		{
			$data['id']=$id;
			$data['antribarang']=$kode;
			$this->tabelantrian->save($data);
			echo "true";
		}
		
		public function nextbarang($id, $kode=0)
		{
			
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			if($kode<$antrian[0]['barang']){
				echo ($antrian[0]['antribarang']+1).",".$antrian[0]['barang'];
				$data['id']=$id;
				$data['antribarang']=$antrian[0]['antribarang']+1;
				$this->tabelantrian->save($data);
				//echo ",".$kode;
			}
			else{ 
				echo ($antrian[0]['antribarang']).",".$antrian[0]['barang'];
				echo ",false";
			}
		}
		
		public function getlastbarang()
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			echo $antrian[0]['barang'];
		}

		public function wbp($no=1)
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			$prefixwbp = $this->rulewbp[strlen($antrian[0]['antriwbp'])];
			$wbp=$prefixwbp.$antrian[0]['antriwbp'];
			$textwbp=$wbp[0].",. ".$wbp[1]." ".$wbp[2]." ".$wbp[3];
	
			if (count($antrian)==0){$antrian = $this->antrianbaru();}
			$data['antrian']=$antrian[0];
			$data['nowbp']=$no;
			$data['prefixwbp']=$prefixwbp;
			$data['textwbp']=$textwbp;
			$data['rulewbp']=$this->rulewbp;
			$data['title'] = ucfirst("wbp"); // Capitalize the first letter
			$data['isi'] = "wbp";
			return view('main-layout/wraper-android',$data);
		}
		
		
		public function addantriwbp($id, $kode=0)
		{
			$data['id']=$id;
			$data['antriwbp']=$kode;
			$this->tabelantrian->save($data);
			echo "true";
		}
		
		public function nextwbp($id, $kode=0)
		{
			
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			if($kode<$antrian[0]['wbp']){
				echo ($antrian[0]['antriwbp']+1).",".$antrian[0]['wbp'];
				$data['id']=$id;
				$data['antriwbp']=$antrian[0]['antriwbp']+1;
				$this->tabelantrian->save($data);
				//echo ",".$kode;
			}
			else{ 
				echo ($antrian[0]['antriwbp']).",".$antrian[0]['wbp'];
				echo ",false";
			}
		}
		
		public function getlastwbp()
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			echo $antrian[0]['wbp'];
		}


		public function kantor($no=1)
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			$prefixkantor = $this->rulekantor[strlen($antrian[0]['antrikantor'])];
			$kantor=$prefixkantor.$antrian[0]['antrikantor'];
			$textkantor=$kantor[0].",. ".$kantor[1]." ".$kantor[2]." ".$kantor[3];
	
			if (count($antrian)==0){$antrian = $this->antrianbaru();}
			$data['antrian']=$antrian[0];
			$data['nowbp']=$no;
			$data['prefixkantor']=$prefixkantor;
			$data['textkantor']=$textkantor;
			$data['rulekantor']=$this->rulekantor;
			$data['title'] = ucfirst("kantor"); // Capitalize the first letter
			$data['isi'] = "kantor";
			return view('main-layout/wraper-android',$data);
		}
		
		
		public function addantrikantor($id, $kode=0)
		{
			$data['id']=$id;
			$data['antrikantor']=$kode;
			$this->tabelantrian->save($data);
			echo "true";
		}
		
		public function nextkantor($id, $kode=0)
		{
			
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			if($kode<$antrian[0]['kantor']){
				echo ($antrian[0]['antrikantor']+1).",".$antrian[0]['kantor'];
				$data['id']=$id;
				$data['antrikantor']=$antrian[0]['antrikantor']+1;
				$this->tabelantrian->save($data);
				//echo ",".$kode;
			}
			else{ 
				echo ($antrian[0]['antrikantor']).",".$antrian[0]['kantor'];
				echo ",false";
			}
		}
		
		public function getlastkantor()
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			echo $antrian[0]['kantor'];
		}

	
		public function wbp1($no=1)
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			if (count($antrian)==0){$antrian = $this->antrianbaru();}
			$data['antrian']=$antrian[0];
			$data['nowbp']=$no;
			$data['rulewbp']=$this->rulewbp;
			$data['title'] = ucfirst("Loket 2 wbp"); // Capitalize the first letter
			$data['isi'] = "wbp1";
			return view('main-layout/wraper',$data);
		}

		public function wbp2($no=1)
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			if (count($antrian)==0){$antrian = $this->antrianbaru();}
			$data['antrian']=$antrian[0];
			$data['nowbp']=$no;
			$data['rulewbp']=$this->rulewbp;
			$data['title'] = ucfirst("Loket 2 wbp"); // Capitalize the first letter
			$data['isi'] = "wbp2";
			return view('main-layout/wraper',$data);
		}


		
		public function addtts($id, $kode="")
		{
			$data['id']=$id;
			$data['tts']=$kode;
			$this->tabelantrian->save($data);
			echo "true";
		}
		
		public function ajaxikm()
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			$ikmhari = $this->tabelikm
				->where('tanggal',$tanggal)
				->groupBy('tanggal')
				->groupBy('indeks')
				->orderBy('tanggal desc')
				->orderBy('indeks asc')
				->select("*")
				->select("count(*) as jumlah")
				->findAll();
			//dd ($ikmhari);
			$data = array(1=>0,2=>0,3=>0,4=>0);
			$i=0;
			while ($i < count($ikmhari)){ 
				$j=1;
				while ($j < 5){
					if ($ikmhari[$i]['indeks']==$j){
						$data[$j] = $ikmhari[$i]['jumlah'];
					}
					$j++;
				}
				$i++;
			}
			//dd($data);
			echo $data[1].",".$data[2].",".$data[3].",".$data[4].",".($antrian[0]['virtual']-1).",".($antrian[0]['barang']-1).",".($antrian[0]['wbp']-1).",".($antrian[0]['kantor']-1);
		}
		
		public function ajaxantrian()
		{
			$tanggal = date('Y-m-d');
			$antrian = $this->tabelantrian->where("tanggal", $tanggal)->findAll();
			if (count($antrian)==0){$antrian = $this->antrianbaru();}
			$data['id']=$antrian[0]['id'];
			$data['tts']="";
			$this->tabelantrian->save($data);
			echo $antrian[0]['antrivirtual']."|".$antrian[0]['antribarang']."|".$antrian[0]['antriwbp']."|".$antrian[0]['antrikantor']."|".$antrian[0]['tts'];
		}
		
		
		public function login()
		{
			$data['title'] = ucfirst("login"); // Capitalize the first letter
			return view('login',$data);
		}
		
		public function tiketantrian($kunjungan, $no='')
		{
			$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => [58, 3276],
			'orientation' => 'P',
			'margin_top' => 2,
			'margin_left' => 2,
			'margin_right' => 5,
			'margin_bottom' => 1
			]);
			ob_start();
		?>
		<table border="0">
			<tr>
				<td><img src="images/pengayoman.png" width="60"></td>
				<td align="center"><font size="4">Lapas Kelas II B Lubuk Pakam</font><br><font size="1"><?php echo tglindo();?></font></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><font size="5">Nomor Antrian</font><br><font size="7"><H1><?php echo $no; ?></H1></font></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><font size="5"><?php echo $kunjungan;?></font></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><font size="2">Terima Kasih Telah Menunggu</font></td>
			</tr>
		</table>
		
		<?php
			$html = ob_get_contents();
			ob_end_clean();
			$mpdf->WriteHTML($html);
			return redirect()->to($mpdf->Output("filename.pdf", "I"));
		}
		
		public function addvirtual($id, $kode=0)
		{
			$tanggal = date('Y-m-d');
			$data['id']=$id;
			$data['virtual']=$kode+1;
			$this->tabelantrian->save($data);
			
			$antrian = $this->tabelantrian->where("id", $id)->findAll();
			$prefix = $this->rulevirtual[strlen($antrian[0]['virtual'])];
			echo "true,".$prefix.",".$antrian[0]['virtual'];
		}
		
		public function addbarang($id, $kode=0)
		{
			$tanggal = date('Y-m-d');
			$data['id']=$id;
			$data['barang']=$kode+1;
			$this->tabelantrian->save($data);
			
			$antrian = $this->tabelantrian->where("id", $id)->findAll();
			$prefix = $this->rulebarang[strlen($antrian[0]['barang'])];
			echo "true,".$prefix.",".$antrian[0]['barang'];
		}
		
		public function addwbp($id, $kode=0)
		{
			$tanggal = date('Y-m-d');
			$data['id']=$id;
			$data['wbp']=$kode+1;
			$this->tabelantrian->save($data);
			
			$antrian = $this->tabelantrian->where("id", $id)->findAll();
			$prefix = $this->rulewbp[strlen($antrian[0]['wbp'])];
			echo "true,".$prefix.",".$antrian[0]['wbp'];
		}
		
		public function addkantor($id, $kode=0)
		{
			$tanggal = date('Y-m-d');
			$data['id']=$id;
			$data['kantor']=$kode+1;
			$this->tabelantrian->save($data);
			
			$antrian = $this->tabelantrian->where("id", $id)->findAll();
			$prefix = $this->rulekantor[strlen($antrian[0]['kantor'])];
			echo "true,".$prefix.",".$antrian[0]['kantor'];
		}
		
		public function addikm($kode=0)
		{
			//$data['id']=$id;
			$data['tanggal']=date('Y-m-d');
			$data['indeks']=$kode;
			$this->tabelikm->save($data);
			echo "true";
		}
		
		public function antrianbaru()
		{
			$data['tanggal']=date('Y-m-d');
			$data['virtual']=1;
			$data['antrivirtual']=1;
			$data['barang']=1;
			$data['antribarang']=1;
			$data['wbp']=1;
			$data['antriwbp']=1;
			$data['kantor']=1;
			$data['antrikantor']=1;
			$this->tabelantrian->save($data);
			return $this->tabelantrian->where('tanggal', date('Y-m-d'))->findAll();
		}

	}
	
	function tglindo()
	{
		$hari = date ("D");
		$bulan = date ("m");
		
		$listday = array(
		'Sun' => 'Minggu',
		'Mon' => 'Senin',
		'Tue' => 'Selasa',
		'Wed' => 'Rabu',
		'Thu' => 'Kamis',
		'Fri' => 'Jumat',
		'Sat' => 'Sabtu'
        );
		
		$listmoth =array(
		'00' => '00',
		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'10' => 'Oktober',
		'11' => 'November',
		'12' => 'Desember'
		);
		
		
		return $listday[$hari] . ", ". date("d ") . $listmoth[$bulan] . date(" Y H:i:s");
	}
	
	function datatochart7($ikm){
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
		$j=0;
		$data="{labels: [";
		$tanggal="";
		//dd($ikm);
		while (($i < count($ikm)))
		{
			$ikmtanggal=$ikm[$i]['tanggal'];
			if($ikmtanggal!=$tanggal){
				if ($j>=7){break;}
				$tanggal = $ikmtanggal;
				$data .= "'". date_format(date_create($tanggal),"d M Y") ."',";
				$j++;
				$jumlah[$j]=array(1=>0,2=>0,3=>0,4=>0);
			}
			$jumlah[$j][$ikm[$i]['indeks']]=$ikm[$i]['jumlah'];
			$i++;
		}
		$data .= "],
			datasets: [
				{
					label: '".$indeks[1]."',
					backgroundColor: 'rgb(56, 86, 255, 0.87)',
					data: [";
		$i=0;
		while ($i < count($jumlah)){$i++;$data.=$jumlah[$i][1].",";}
		$data.= "]
				}, {
					label: '".$indeks[2]."',
					backgroundColor: 'rgb(60, 179, 113)',
					data: [";
		$i=0;
		while ($i < count($jumlah)){$i++;$data.=$jumlah[$i][2].",";}
		$data.= "]
				}, {
					label: '".$indeks[3]."',
					backgroundColor: 'rgb(255, 238, 10)',
					data: [";
		$i=0;
		while ($i < count($jumlah)){$i++;$data.=$jumlah[$i][3].",";}
		$data.= "]
				}, {
					label: '".$indeks[4]."',
					backgroundColor: 'rgb(255, 99, 132)',
					data: [";
		$i=0;
		while ($i < count($jumlah)){$i++;$data.=$jumlah[$i][4].",";}
		$data.= "]
				}
			]
		}";
		//echo $data;
		return $data;
	}
	
				
	
	function datatochart($ikm){
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
		$data["namaindeks"]= $namaindeks;
		$data["jumlah"]= $jumlah;
		return $data;
	}