<?php

class SessionModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function getUser($token) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE token = :token AND `is_active` = :isActive");
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getUserDetails($userId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT id, fullname, mail, mobile, company_id, cab_company_id, language FROM `cms_drivers` WHERE user_id = :userId AND `is_active` = :isActive");
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
        
        //Yokesh you to code for get user details from table
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
    
    public function getLanguage($code, $companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT l.code, l.name FROM cms_company_languages cl
                                    INNER JOIN cms_languages l ON cl.language_id = l.id
                                    WHERE l.code = :code AND cl.company_id = :companyId AND cl.is_active = :isActive");
        $stmt->bindParam("code", $code);
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updateLanguage($driverId, $code) {
        $stmt = $this->db->prepare("UPDATE `cms_drivers` SET `language` = :code WHERE `id` = :driverId");
        $stmt->bindParam(":code", $code);
        $stmt->bindParam(":driverId", $driverId);

        return $stmt->execute() ? true : false;
    }
}

?>
