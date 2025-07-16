<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSeparateTablesForFeaturesAndModules extends Migration
{
    public function up()
    {
        // Create features table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'color' => [
                'type' => 'ENUM',
                'constraint' => ['blue', 'green', 'orange', 'purple'],
                'default' => 'blue',
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
                'null' => false,
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('status');
        $this->forge->addKey('sort_order');
        $this->forge->createTable('features');

        // Create modules table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'color' => [
                'type' => 'ENUM',
                'constraint' => ['blue', 'green', 'orange', 'purple'],
                'default' => 'blue',
                'null' => false,
            ],
            'module_type' => [
                'type' => 'ENUM',
                'constraint' => ['application', 'database', 'utility'],
                'default' => 'application',
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
                'null' => false,
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('module_type');
        $this->forge->addKey('status');
        $this->forge->addKey('sort_order');
        $this->forge->createTable('modules');

        // Migrate data from existing fitur table if it exists
        if ($this->db->tableExists('fitur')) {
            $this->migrateExistingData();
        }
    }

    public function down()
    {
        // Drop the new tables
        $this->forge->dropTable('features', true);
        $this->forge->dropTable('modules', true);
    }

    private function migrateExistingData()
    {
        // Get all existing data from fitur table
        $fiturData = $this->db->table('fitur')->get()->getResultArray();
        
        if (empty($fiturData)) {
            return;
        }

        $featuresData = [];
        $modulesData = [];

        foreach ($fiturData as $row) {
            $baseData = [
                'title' => $row['title'] ?? $row['nama_fitur'] ?? '',
                'description' => $row['description'] ?? $row['deskripsi'] ?? '',
                'icon' => $row['icon'] ?? 'bi-star',
                'color' => $row['color'] ?? 'blue',
                'status' => $row['status'] ?? 'active',
                'created_at' => $row['created_at'] ?? date('Y-m-d H:i:s'),
                'updated_at' => $row['updated_at'] ?? date('Y-m-d H:i:s'),
            ];

            // Determine type based on existing data
            $type = $row['type'] ?? 'feature';
            
            if ($type === 'feature') {
                $featuresData[] = array_merge($baseData, [
                    'sort_order' => $row['sort_order'] ?? count($featuresData) + 1,
                ]);
            } else {
                $modulesData[] = array_merge($baseData, [
                    'module_type' => $row['module_type'] ?? 'application',
                    'sort_order' => $row['sort_order'] ?? count($modulesData) + 1,
                ]);
            }
        }

        // Insert features data
        if (!empty($featuresData)) {
            $this->db->table('features')->insertBatch($featuresData);
        }

        // Insert modules data
        if (!empty($modulesData)) {
            $this->db->table('modules')->insertBatch($modulesData);
        }

        // Fix sort orders to be sequential
        $this->fixSortOrders('features');
        $this->fixSortOrders('modules');
    }

    private function fixSortOrders($table)
    {
        $items = $this->db->table($table)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($items as $index => $item) {
            $this->db->table($table)
                ->where('id', $item['id'])
                ->update(['sort_order' => $index + 1]);
        }
    }
}
