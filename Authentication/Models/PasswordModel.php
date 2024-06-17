<?php

class PasswordModel {

    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getMailId($mailId) {
        
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `id`, `username`, `password`, `company_id`, `is_active` FROM `users` WHERE username=:mailId AND is_active=:isActive");
        $stmt->bindParam(":mailId", $mailId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;

    }

    public function setChangePassword($userId, $changeType, $token) {
        
        $stmt = $this->db->prepare("INSERT INTO `change_password`(`user_id`, `change_type_id`, `token`) VALUES (:userId, :changeType, :token)");
        $stmt->bindParam("userId", $userId);
        $stmt->bindParam("changeType", $changeType);
        $stmt->bindParam("token", $token);

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

    public function getPasswordChange($token) {

        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM `change_password` WHERE `token` = :token AND `is_active` = :isActive AND `created_at` > NOW() - INTERVAL 10 MINUTE");
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;

    }

    public function getUserRole($userId) {
        
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `role_id` FROM `user_roles` WHERE `user_id` = :userId AND `is_active` = :isActive");
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updatePassword($userId, $newPassword) {
        $stmt = $this->db->prepare("UPDATE `users` SET `password` = :newPassword WHERE `id` = :userId");
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":newPassword", $newPassword);

        return $stmt->execute() ? true : false;
    }

    public function updateChangePasswordStatus($token) {
        $isActive = false;
        $stmt = $this->db->prepare("UPDATE `change_password` SET `is_active` = :isActive WHERE `token` = :token");
        $stmt->bindParam(":isActive", $isActive);
        $stmt->bindParam(":token", $token);

        return $stmt->execute() ? true : false;
    }

    public function updateForcePasswordChange($userId) {
        $forcePasswordChange = false;
        $stmt = $this->db->prepare("UPDATE `users` SET `force_password_change` = :forcePasswordChange WHERE `id` = :userId");
        $stmt->bindParam(":forcePasswordChange", $forcePasswordChange);
        $stmt->bindParam(":userId", $userId);

        return $stmt->execute() ? true : false;
    }
}