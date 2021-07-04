<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ikm extends Migration
{
	public function up()
	{
		$ikm = [
			'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'tanggal' => ['type' => 'DATE'],
			'indeks' => ['type' => 'INT', 'constraint' => 11]
			];
		$this->forge->addField($ikm);
		$this->forge->addKey('id', true);
		$this->forge->createTable('ikm', true);
	}

	public function down()
	{
		$this->forge->dropTable('ikm');
	}
}
