<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/VacationRequest.php';


class VacationCatalog {
    private $db;
    
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Insert a vacation request
     */
    public function insertRequest(VacationRequest $request) {

        $user_id = $request->getUserId;
        $start_date = $request->getStringStartDate;
        $end_date = $request->getStringEndDate;
        $reason = $request->getReason;


       $stmt = $this->db->prepare("INSERT INTO vacation_requests (user_id, start_date, end_date, reason) VALUES (?, ?, ?, ?)");
       return $stmt->execute([$request->getUserId(),$request->getStringStartDate(),$request->getStringEndDate(),$request->getReason()]);
    }

    /**
     * Get all vacation requests 
     * @return VacationRequest
     */
    public function getAllRequests() {
        $stmt = $this->db->prepare(
            "SELECT vr.*, u.full_name 
             FROM vacation_requests vr 
             JOIN users u ON vr.user_id = u.id 
             ORDER BY vr.submitted_at DESC"
        );
        $stmt->execute();
        
        $requests = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $requests[] = $this->createRequestFromRow($row);
        }
        return $requests;
    }


    /**
     * Get vacation requests by status
     * @param string $status (pending|approved|rejected)
     * @return VacationRequest[] 
     */
    public function getUserRequests($user_id) {
        
        $stmt = $this->db->prepare(
            "SELECT vr.* 
             FROM vacation_requests vr 
             JOIN users u ON vr.user_id = u.id 
             WHERE vr.user_id = ?
             ORDER BY vr.submitted_at DESC"
        );
        $stmt->execute([$user_id]);
        
        $requests = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $requests[] = $this->createRequestFromRow($row);
        }
        return $requests;
    }

    /**
     * Get vacation requests by status
     * @param string $status (pending|approved|rejected)
     * @return VacationRequest[] 
     */
    public function getRequestsByStatus($status) {
        $validStatuses = ['pending', 'approved', 'rejected'];
        if (!in_array($status, $validStatuses)) {
            throw new InvalidArgumentException("Invalid status provided");
        }

        $stmt = $this->db->prepare(
            "SELECT vr.*,
              u.full_name 
             FROM vacation_requests vr 
             JOIN users u ON vr.user_id = u.id 
             WHERE vr.status = ?
             ORDER BY vr.submitted_at DESC"
        );
        $stmt->execute([$status]);
        
        $requests = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $requests[] = $this->createRequestFromRow($row);
        }
        return $requests;
    }

    /**
     * Create VacationRequest object from database row
     * @param db $row
     * @return VacationRequest
     */
    private function createRequestFromRow($row) {
        $request = new VacationRequest($row['user_id'],$row['start_date'],$row['end_date'],$row['reason'],$row['status']);
        $request->setId($row['id']);
        $request->setSubmittedAt($row['submitted_at']);
        
        // Add the employee name if it exists in the row
        if (isset($row['full_name'])) {
            $request->setUserName($row['full_name']);
        }
        
        return $request;
    }
}
?>