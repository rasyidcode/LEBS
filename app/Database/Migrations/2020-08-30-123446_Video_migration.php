<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Video_migration extends Migration
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
			'video_url' => [
				'type' => 'TEXT',
				'null' => false
			],
			'owner' => [
				'type' => 'INT',
				'constraint' => '11',
				'null' => false
			],
			'contributors' => [
				'type' => 'TEXT',
				'null' => false
			],
			'created_at datetime default current_timestamp',
      		'updated_at datetime default current_timestamp on update current_timestamp',
		];
		$this->forge->addField($fields);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('owner', 'users', 'id');
		$this->forge->createTable('videos');

		$this->db->enableForeignKeyChecks();
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('videos');
	}
}
