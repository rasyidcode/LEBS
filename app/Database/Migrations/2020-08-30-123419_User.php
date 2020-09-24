<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
	public function up()
	{
		$fields = array(
			'id' => array(
				'type' 				=> 'INT',
				'constraint' 		=> '11',
				'auto_increment' 	=> true,
				'null' 				=> false
			),
			'full_name' => array(
				'type' 			=> 'VARCHAR',
				'constraint' 	=> '255',
				'null' 			=> false
			),
			'address' => array(
				'type' => 'TEXT',
				'null' => false
			),
			'birthday' => array(
				'type' => 'DATE',
				'null' => false
			),
			'phone_number' => array(
				'type' 			=> 'VARCHAR',
				'constraint' 	=> '20',
				'null' 			=> false
			),
			'email' => array(
				'type' 			=> 'VARCHAR',
				'constraint' 	=> '255',
				'null' 			=> false
			),
			'gender' => array(
				'type' => 'ENUM("male", "female")',
				'null' => false
			),
			'username' => array(
				'type' 			=> 'VARCHAR',
				'constraint' 	=> '10',
				'null' 			=> false
			),
			'password' => array(
				'type' 			=> 'VARCHAR',
				'constraint'	=> '255',
				'null' 			=> false
			),
			'is_active' => array(
				'type'		=> 'TINYINT',
				'null'		=> false,
				'default'	=> '0'
			),
			'is_verified' => array(
				'type'		=> 'TINYINT',
				'null'		=> false,
				'default'	=> '0'
			),
			'created_at datetime not null default current_timestamp',
			'updated_at datetime not null default current_timestamp on update current_timestamp',
			'deleted_at datetime null'  
		);
		$this->forge->addField($fields);
		$this->forge->addKey('id', true);
		$this->forge->createTable('users');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
