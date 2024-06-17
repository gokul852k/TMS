<?php

class LoginModel {
    
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }
    public function getUserByUsername($username) {
        
        $isActive = true;
        $stmt = $this->conn->prepare("SELECT `id`, `username`, `password`, `company_id`, `force_password_change`, `is_active` FROM `users` WHERE username=:username AND is_active=:isActive");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;

    }

    public function getLoginAttempts($userId) {
        
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS 'count' FROM `login_attempts` WHERE user_id = :userId AND is_success = :isSuccess AND attempt_time > NOW() - INTERVAL 20 MINUTE");
        $isSuccess = false;
        $stmt->bindParam("userId", $userId);
        $stmt->bindParam("isSuccess", $isSuccess);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['count'] : 0;

    }

    public function setLoginAttempts($userId, $ipAddress, $isSuccess) {

        $stmt = $this->conn->prepare("INSERT INTO `login_attempts`(`user_id`, `ip_address`, `is_success`) VALUES (:userId, :ipAddress, :isSuccess)");
        $stmt->bindParam("userId", $userId);
        $stmt->bindParam("ipAddress", $ipAddress);
        $stmt->bindParam("isSuccess", $isSuccess);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Insert failed.',
                    'error' => 'No reason'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Insert failed.',
                'error' => $stmt->errorInfo()
            ];
        }

    }

    public function updateToken($userId, $token) {

        $stmt = $this->conn->prepare("UPDATE `users` SET `token` = :token WHERE `id` = :userId");
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":userId", $userId);

        return $stmt->execute() ? true : false;

    }

    public function getSystemIdAndRoleIdByUserId($userId) {
        
        $isActive = true;
        $stmt = $this->conn->prepare("SELECT `role_id`, `system_id` FROM `user_roles` WHERE user_id=:userId AND is_active=:isActive");
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;

    }
}