<?php

class SessionModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function getToken($userId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE id = :userId AND `is_active` = :isActive");
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getCompanyDetails($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `id`, `company_name`, `company_logo` FROM `company` WHERE `id` = :companyId AND `is_active` = :isActive");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }
}

?>
