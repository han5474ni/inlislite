<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsToRegistrationsTable extends Migration
{
    public function up()
    {
        // Check if table exists
        if (!$this->db->tableExists('registrations')) {
            return;
        }

        // Get existing columns
        $existingColumns = $this->db->getFieldNames('registrations');
        
        // Define columns to add
        $fieldsToAdd = [];
        
        if (!in_array('library_code', $existingColumns)) {
            $fieldsToAdd['library_code'] = [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'library_name'
            ];
        }
        
        if (!in_array('library_type', $existingColumns)) {
            $fieldsToAdd['library_type'] = [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'library_code'
            ];
        }
        
        if (!in_array('address', $existingColumns)) {
            $fieldsToAdd['address'] = [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'city'
            ];
        }
        
        if (!in_array('postal_code', $existingColumns)) {
            $fieldsToAdd['postal_code'] = [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'address'
            ];
        }
        
        if (!in_array('coordinates', $existingColumns)) {
            $fieldsToAdd['coordinates'] = [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'postal_code'
            ];
        }
        
        if (!in_array('contact_name', $existingColumns)) {
            $fieldsToAdd['contact_name'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'coordinates'
            ];
        }
        
        if (!in_array('contact_position', $existingColumns)) {
            $fieldsToAdd['contact_position'] = [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'contact_name'
            ];
        }
        
        if (!in_array('website', $existingColumns)) {
            $fieldsToAdd['website'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'phone'
            ];
        }
        
        if (!in_array('fax', $existingColumns)) {
            $fieldsToAdd['fax'] = [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'website'
            ];
        }
        
        if (!in_array('established_year', $existingColumns)) {
            $fieldsToAdd['established_year'] = [
                'type' => 'INT',
                'constraint' => 4,
                'null' => true,
                'after' => 'fax'
            ];
        }
        
        if (!in_array('collection_count', $existingColumns)) {
            $fieldsToAdd['collection_count'] = [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'established_year'
            ];
        }
        
        if (!in_array('member_count', $existingColumns)) {
            $fieldsToAdd['member_count'] = [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'collection_count'
            ];
        }
        
        if (!in_array('notes', $existingColumns)) {
            $fieldsToAdd['notes'] = [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'member_count'
            ];
        }

        // Add only non-existing columns
        if (!empty($fieldsToAdd)) {
            $this->forge->addColumn('registrations', $fieldsToAdd);
        }
    }

    public function down()
    {
        // Hapus kolom-kolom yang ditambahkan jika migrasi di-rollback
        $this->forge->dropColumn('registrations', [
            'library_code', 'library_type', 'address', 'postal_code', 'coordinates',
            'contact_name', 'contact_position', 'website', 'fax', 'established_year',
            'collection_count', 'member_count', 'notes'
        ]);
    }
}