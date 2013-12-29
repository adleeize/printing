<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Table_user extends CI_Migration {

	public function up()
	{
            if($this->db->table_exists('user_accounts')) {
                $this->dbforge->drop_table('user_accounts');
            }
            
            $this->dbforge->add_field(array(
                'uacc_id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'uacc_group_fk' => array(
                    'type' => 'SMALLINT',
                    'constraint' => '5',
                    'unsigned' => TRUE,
                    'default' => 0
                ),
                'uacc_email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'uacc_name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '20'
                ),
                'uacc_password' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '32'
                ),
                'uacc_no_peg' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '20'
                ),
                'uacc_phone' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '20'
                ),
                'uacc_kota' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '50'
                ),
                'uacc_date_added' => array(
                    'type' => 'DATETIME',
                    'default' => '0000-00-00 00:00:00'
                )
            ));

            $this->dbforge->add_key('uacc_id', TRUE);
            $this->dbforge->create_table('user_accounts');
	}

	public function down()
	{
            $this->dbforge->drop_table('user_accounts');
	}
}