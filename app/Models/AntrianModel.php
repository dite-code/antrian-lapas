<?php

namespace App\Models;

use CodeIgniter\Model;

class AntrianModel extends Model
{
	protected $table = 'antrian';
	protected $allowedFields = ['tanggal', 'virtual', 'antrivirtual', 'barang', 'antribarang', 'wbp', 'antriwbp', 'kantor', 'antrikantor', 'tts'];
	
}
?>