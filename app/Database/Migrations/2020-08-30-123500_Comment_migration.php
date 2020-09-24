<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Comment_migration extends Migration
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
			'user_id' => [
				'type' => 'INT',
				'constraint' => '11',
				'null' => false
			],
			'respond_to' => [
				'type' => 'INT',
				'constraint' => '11',
				'null' => false
			],
			'is_edited' => [
				'type' => 'TINYINT',
				'null' => false
			],
			'created_at datetime not null default current_timestamp',
      		'updated_at datetime not null default current_timestamp on update current_timestamp',
		];
		$this->forge->addField($fields);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('video_id', 'videos', 'id');
		$this->forge->addForeignKey('user_id', 'users', 'id');
		$this->forge->createTable('comments');

		$this->db->enableForeignKeyChecks();
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('comments');
	}
}
