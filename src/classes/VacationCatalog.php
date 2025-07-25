<?php
class VacationCatalog {
    private $db;
    
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Insert a vacation request
     * @param VacationRequest
     * @return null
     */
    public function insertRequest(VacationRequest $request) {

        $user_id = $request->getUserId();
        $start_date = $request->getStringStartDate();
        $end_date = $request->getStringEndDate();
        $reason = $request->getReason();


       $stmt = $this->db->prepare(
            "INSERT INTO tVacationRequest (
                user_id, 
                start_date,
                end_date,
                reason)
            VALUES 
            (?, ?, ?, ?)"
        );
       return $stmt->execute([$request->getUserId(),$request->getStringStartDate(),$request->getStringEndDate(),$request->getReason()]);
    }

     /**
     * Delete a vacation request
     * @param request id
     * @return null
     */
    public function deleteRequest($request_id) {
       $stmt = $this->db->prepare(
            "DELETE FROM tVacationRequest WHERE id = ?"
        );
       return $stmt->execute([$request_id]);
    }

      /**
     * Update a vacation request
     * @param request id
     * @return null
     */
    public function updateRequest($request_id, $status) {
        $stmt = $this->db->prepare(
            "UPDATE tVacationRequest SET status = ? WHERE id = ?"
        );
        return $stmt->execute([$status, $request_id]);
    }

    /**
     * Get all vacation requests 
     * @return VacationRequest
     */
    public function getAllRequests() {
        $stmt = $this->db->prepare(
            "SELECT 
                vr.*, 
                u.full_name 
                FROM tVacationRequest vr 
                JOIN tUser u ON vr.user_id = u.id 
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
             FROM tVacationRequest vr 
             JOIN tUser u ON vr.user_id = u.id 
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
             FROM tVacationRequest vr 
             JOIN tUser u ON vr.user_id = u.id 
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
        $request->setSubmittedAt( new DateTime($row['submitted_at']));
        
        // Add the employee name if it exists in the row
        if (isset($row['full_name'])) {
            $request->setUserName($row['full_name']);
        }
        
        return $request;
    }
}
?>
