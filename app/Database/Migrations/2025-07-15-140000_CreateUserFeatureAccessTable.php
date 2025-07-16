<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserFeatureAccessTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'feature' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->createTable('user_feature_access');
        
        // Add foreign key constraint after table creation
        $this->db->query('ALTER TABLE user_feature_access ADD CONSTRAINT fk_user_feature_access_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('user_feature_access');
    }
}
