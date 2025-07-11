<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistrationModel extends Model
{
    protected $table = 'registrations';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'library_name', 'library_code', 'library_type', 'province', 'city', 'address', 
        'postal_code', 'coordinates', 'contact_name', 'contact_position', 'email', 
        'phone', 'website', 'fax', 'established_year', 'collection_count', 
        'member_count', 'notes', 'status', 'verified_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getMonthlyStats($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }

        // First, let's check what years actually exist in the database
        $yearsQuery = $this->db->query("SELECT DISTINCT YEAR(created_at) as year FROM registrations ORDER BY year DESC");
        $availableYears = $yearsQuery->getResultArray();
        log_message('info', 'Available years in database: ' . json_encode($availableYears));

        // Also check total records for the requested year
        $countQuery = $this->db->query("SELECT COUNT(*) as count FROM registrations WHERE YEAR(created_at) = ?", [$year]);
        $yearCount = $countQuery->getRowArray();
        log_message('info', "Records for year {$year}: " . $yearCount['count']);

        $query = $this->db->query("
            SELECT 
                MONTH(created_at) as month,
                COUNT(*) as total,
                SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) as verified,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending
            FROM registrations 
            WHERE YEAR(created_at) = ?
            GROUP BY MONTH(created_at)
            ORDER BY month
        ", [$year]);

        $result = $query->getResultArray();
        log_message('info', "Monthly query result for year {$year}: " . json_encode($result));
        
        // Fill missing months with zeros
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = [
                'month' => $i,
                'total' => 0,
                'verified' => 0,
                'pending' => 0
            ];
        }

        foreach ($result as $row) {
            $months[$row['month']] = $row;
        }

        return array_values($months);
    }

    public function getTotalStats()
    {
        $query = $this->db->query("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) as verified,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending
            FROM registrations
        ");

        return $query->getRowArray();
    }

    public function getAvailableYears()
    {
        $query = $this->db->query("
            SELECT DISTINCT YEAR(created_at) as year 
            FROM registrations 
            WHERE created_at IS NOT NULL 
            ORDER BY year DESC
        ");

        $result = $query->getResultArray();
        $years = array_column($result, 'year');
        
        // If no data, include current year
        if (empty($years)) {
            $years = [date('Y')];
        }
        
        // Always include current year if not present
        $currentYear = (int)date('Y');
        if (!in_array($currentYear, $years)) {
            array_unshift($years, $currentYear);
            sort($years);
            $years = array_reverse($years);
        }
        
        return $years;
    }
}
