<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPatchesAddStatusUrl extends Migration
{
    public function up()
    {
        // Add new columns
        $this->forge->addColumn('patches', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
                'after'      => 'jumlah_unduhan',
            ],
            'url_download' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'ukuran',
            ],
        ]);

        // STEP 1: Temporarily expand enum to include both old (TitleCase) and new (lowercase) values + 'critical'
        $this->forge->modifyColumn('patches', [
            'prioritas' => [
                'name'       => 'prioritas',
                'type'       => 'ENUM',
                'constraint' => ['High', 'Medium', 'Low', 'low', 'medium', 'high', 'critical'],
                'default'    => 'Medium',
            ],
        ]);

        // STEP 2: Normalize existing data to lowercase
        $this->db->query("UPDATE `patches` SET `prioritas` = LOWER(`prioritas`) WHERE `prioritas` IN ('High','Medium','Low')");

        // STEP 3: Restrict enum to lowercase values only going forward
        $this->forge->modifyColumn('patches', [
            'prioritas' => [
                'name'       => 'prioritas',
                'type'       => 'ENUM',
                'constraint' => ['low', 'medium', 'high', 'critical'],
                'default'    => 'medium',
            ],
        ]);
    }

    public function down()
    {
        // Revert 'prioritas' to previous enum
        $this->forge->modifyColumn('patches', [
            'prioritas' => [
                'name'       => 'prioritas',
                'type'       => 'ENUM',
                'constraint' => ['High', 'Medium', 'Low'],
                'default'    => 'Medium',
            ],
        ]);

        // Drop added columns
        $this->forge->dropColumn('patches', 'url_download');
        $this->forge->dropColumn('patches', 'status');
    }
}