<?php
	
	namespace App\Database\Migrations;
	
	use CodeIgniter\Database\Migration;
	
	class Antrian extends Migration
	{
		public function up()
		{
			$antrian = [
				'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
				'tanggal' => ['type' => 'DATE'],
				'virtual' => ['type' => 'INT', 'constraint' => 11],
				'antrivirtual' => ['type' => 'INT', 'constraint' => 11],
				'barang' => ['type' => 'INT', 'constraint' => 11],
				'antribarang' => ['type' => 'INT', 'constraint' => 11],
				'wbp' => ['type' => 'INT', 'constraint' => 11],
				'antriwbp' => ['type' => 'INT', 'constraint' => 11],
				'kantor' => ['type' => 'INT', 'constraint' => 11],
				'antrikantor' => ['type' => 'INT', 'constraint' => 11],
				'tts' => ['type' => 'text']
				
			];
			$this->forge->addField($antrian);
			$this->forge->addKey('id', true);
			$this->forge->createTable('antrian', true);
		}
		
		public function down()
		{
			$this->forge->dropTable('antrian');
		}
	}
