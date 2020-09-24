<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Subtitle_migration extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();

		$fields = [
			'id' => [
				'type' => 'INT',
				'constraint' => '11',
				'auto_increment' => true,
				'null' => false
			],
			'video_id' => [
				'type' => 'INT',
				'constraint' => '11',
				'null' => false
			],
			'minutes' => [
				'type' => 'VARCHAR',
				'constraint' => '5',
				'null' => false
			],
			'subtitle' => [
				'type' => 'TEXT',
				'null' => false
			],
			'created_at datetime default current_timestamp',
      		'updated_at datetime default current_timestamp on update current_timestamp',
		];
		$this->forge->addField($fields);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('video_id', 'videos', 'id');
		$this->forge->createTable('subtitles');

		$this->db->enableForeignKeyChecks();
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('subtitles');
	}
}
