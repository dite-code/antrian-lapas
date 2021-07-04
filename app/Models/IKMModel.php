<?php

namespace App\Models;

use CodeIgniter\Model;

class IKMModel extends Model
{
	protected $table = 'ikm';
	protected $allowedFields = ['tanggal', 'indeks'];
	
}
?>