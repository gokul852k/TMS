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
        $stmt = $this->db->prepare("SELECT `id`, `company_name`, `company_logo`, `language_code` FROM `company` WHERE `id` = :companyId AND `is_active` = :isActive");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getUserRoleFromAuthentication($userId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT roles.role_name FROM user_roles INNER JOIN roles ON user_roles.role_id = roles.id WHERE user_roles.user_id = :userId AND user_roles.is_active = :isActive");
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getUserIdFromCMS($userRole) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM `cms_roles` WHERE role_name = :userRole AND is_active = :isActive");
        $stmt->bindParam(":userRole", $userRole);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }
}


