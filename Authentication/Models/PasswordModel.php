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
}