<?php

class SessionModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function getUser($token) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE id = :userId AND `is_active` = :isActive");
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getUserDetails($userId) {
        // $isActive = true;
        // $stmt = $this->db->prepare("SELECT `id`, `company_name`, `company_logo` FROM `company` WHERE `id` = :companyId AND `is_active` = :isActive");
        // $stmt->bindParam(":companyId", $companyId);
        // $stmt->bindParam(":isActive", $isActive);
        // $stmt->execute();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // return $result ? $result : null;
        
        //Yokesh you to code for get user details from table
    }
}

?>
