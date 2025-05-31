<?php
/*
 * Vacation request class
*/
class VacationRequest {
    private $db;
    private $id;
    private $userId;
    private $userName;
    private $startDate;
    private $endDate;
    private $reason;
    private $status;
    private $submittedAt;
    private $duration;

    public function __construct($userId, $startDate, $endDate, $reason, $status) {
        $this->db = (new Database())->getConnection();
        $this->userId = $userId;
        $this->startDate = new DateTime($startDate);;
        $this->endDate = new DateTime($endDate);
        $this->submittedAt = new DateTime();
        $this->reason = $reason;
        $this->status = $status;
        $this->setDuration();
    }

    // getters
    public function getId() {
        return $this->id;
    }
    public function getUserId() {
        return $this->userId;
    }
    public function getStartDate() {
        return $this->startDate;
    }
    public function getEndDate() {
        return $this->endDate;
    }
    public function getStringStartDate() {
        return $this->startDate->format('Y-m-d');
    }
    public function getStringEndDate() {
        return $this->endDate->format('Y-m-d');
    }
    public function getReason() {
        return $this->reason;
    }
    public function getStatus() {
        return $this->status;
    }
    public function getSubmittedAt() {
        return $this->submittedAt;
    }
    public function setDuration() {
        $this->duration = $this->startDate->diff($this->endDate)->days + 1; 
    }

    // setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setUserId($userId) {
        $this->userId = $userId;
    }
    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }
    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }
    public function setReason($reason) {
        $this->reason = $reason;
    }
    public function setStatus($status) {
        $this->status = $status;
    }

    public function setSubmittedAt ($submittedAt) {
        $this->submittedAt = $submittedAt;
    }

    public function updateStatus($requestId, $status) {
        $stmt = $this->db->prepare("UPDATE vacation_requests SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $requestId]);
    }

    public function getUserRequests($userId) {
        $stmt = $this->db->prepare("SELECT * FROM vacation_requests WHERE user_id = ? ORDER BY submitted_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setUserName($name) {
        $this->userName = $name;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getDuration() {
        $start = $this->startDate;
        $end = $this->endDate;
        return $start->diff($end)->days + 1; // +1 to include both start and end dates
    }

    // go to catalog
    public function getAllRequests() {
        $stmt = $this->db->prepare("SELECT vr.*, u.full_name FROM vacation_requests vr JOIN users u ON vr.user_id = u.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
