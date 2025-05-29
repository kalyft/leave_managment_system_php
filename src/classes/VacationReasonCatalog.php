<?php
require_once 'Database.php';
require_once 'VacationReason.php';

class VacationReasonCatalog {
    private $db;
    
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Get all active reasons
     * @return VacationReason[]
     */
    public function getActiveReasons(): array {
        $stmt = $this->db->query("SELECT * FROM vacation_reasons WHERE is_active = TRUE ORDER BY label");
        $reasons = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reasons[] = $this->createReasonFromRow($row);
        }
        
        return $reasons;
    }

    /**
     * Find reason by key
     */
    public function findByKey(string $reasonKey): ?VacationReason {
        $stmt = $this->db->prepare("SELECT * FROM vacation_reasons WHERE reason_key = ?");
        $stmt->execute([$reasonKey]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $this->createReasonFromRow($row) : null;
    }

    /**
     * Validate if reason exists and is active
     */
    public function isValidReason(string $reasonKey): bool {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM vacation_reasons 
             WHERE reason_key = ? AND is_active = TRUE"
        );
        $stmt->execute([$reasonKey]);
        return $stmt->fetchColumn() > 0;
    }

    private function createReasonFromRow(array $row): VacationReason {
        $reason = new VacationReason(
            $row['reason_key'],
            $row['label'],
            (bool)$row['is_active']
        );
        $reason->id = $row['id'];
        return $reason;
    }
}

?>