<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateFiturTableStructure extends Migration
{
    public function up()
    {
        // Check if we need to update the table structure
        $fields = $this->db->getFieldData('fitur');
        $fieldNames = array_column($fields, 'name');
        
        // If the table has old structure, update it
        if (in_array('nama_fitur', $fieldNames)) {
            // Add new columns if they don't exist
            if (!in_array('title', $fieldNames)) {
                $this->forge->addColumn('fitur', [
                    'title' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                        'null' => true,
                        'after' => 'id'
                    ]
                ]);
            }
            
            if (!in_array('description', $fieldNames)) {
                $this->forge->addColumn('fitur', [
                    'description' => [
                        'type' => 'TEXT',
                        'null' => true,
                        'after' => 'title'
                    ]
                ]);
            }
            
            if (!in_array('color', $fieldNames)) {
                $this->forge->addColumn('fitur', [
                    'color' => [
                        'type' => 'ENUM',
                        'constraint' => ['blue', 'green', 'orange', 'purple'],
                        'default' => 'blue',
                        'after' => 'icon'
                    ]
                ]);
            }
            
            if (!in_array('type', $fieldNames)) {
                $this->forge->addColumn('fitur', [
                    'type' => [
                        'type' => 'ENUM',
                        'constraint' => ['feature', 'module'],
                        'default' => 'feature',
                        'after' => 'color'
                    ]
                ]);
            }
            
            if (!in_array('module_type', $fieldNames)) {
                $this->forge->addColumn('fitur', [
                    'module_type' => [
                        'type' => 'ENUM',
                        'constraint' => ['application', 'database', 'utility'],
                        'null' => true,
                        'default' => null,
                        'after' => 'type'
                    ]
                ]);
            }
            
            // Migrate data from old columns to new columns
            $this->migrateData();
            
            // Drop old columns after data migration
            $this->forge->dropColumn('fitur', ['nama_fitur', 'deskripsi', 'kategori']);
        }
        
        // Add timestamps if they don't exist
        if (!in_array('created_at', $fieldNames)) {
            $this->forge->addColumn('fitur', [
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ]
            ]);
        }
        
        if (!in_array('updated_at', $fieldNames)) {
            $this->forge->addColumn('fitur', [
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ]
            ]);
        }
    }

    public function down()
    {
        // Revert back to old structure if needed
        $fields = $this->db->getFieldData('fitur');
        $fieldNames = array_column($fields, 'name');
        
        if (in_array('title', $fieldNames)) {
            // Add old columns
            $this->forge->addColumn('fitur', [
                'nama_fitur' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                    'after' => 'id'
                ],
                'deskripsi' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'nama_fitur'
                ],
                'kategori' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                    'after' => 'deskripsi'
                ]
            ]);
            
            // Migrate data back
            $this->db->query("UPDATE fitur SET nama_fitur = title, deskripsi = description, kategori = type WHERE title IS NOT NULL");
            
            // Drop new columns
            $this->forge->dropColumn('fitur', ['title', 'description', 'color', 'type', 'module_type']);
        }
    }
    
    private function migrateData()
    {
        // Migrate data from old structure to new structure
        $builder = $this->db->table('fitur');
        $results = $builder->get()->getResultArray();
        
        foreach ($results as $row) {
            $updateData = [
                'title' => $row['nama_fitur'] ?? '',
                'description' => $row['deskripsi'] ?? '',
                'type' => $this->mapCategoryToType($row['kategori'] ?? ''),
                'color' => $this->mapCategoryToColor($row['kategori'] ?? ''),
                'module_type' => $this->mapCategoryToModuleType($row['kategori'] ?? ''),
                'created_at' => $row['created_at'] ?? date('Y-m-d H:i:s'),
                'updated_at' => $row['updated_at'] ?? date('Y-m-d H:i:s')
            ];
            
            $builder->where('id', $row['id'])->update($updateData);
        }
    }
    
    private function mapCategoryToType($category)
    {
        $moduleCategories = ['system', 'advanced', 'utility'];
        return in_array($category, $moduleCategories) ? 'module' : 'feature';
    }
    
    private function mapCategoryToColor($category)
    {
        $colorMap = [
            'core' => 'blue',
            'public' => 'green',
            'management' => 'orange',
            'system' => 'purple',
            'advanced' => 'purple',
            'utility' => 'green'
        ];
        
        return $colorMap[$category] ?? 'blue';
    }
    
    private function mapCategoryToModuleType($category)
    {
        $moduleTypeMap = [
            'system' => 'database',
            'advanced' => 'application',
            'utility' => 'utility'
        ];
        
        $type = $this->mapCategoryToType($category);
        return $type === 'module' ? ($moduleTypeMap[$category] ?? 'application') : null;
    }
}
