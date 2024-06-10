<?php
require_once '../config.php';
require_once '../Models/LoginModel.php';
class LoginService {
    private $model;
    public function __construct() {

        global $conn;
        $this->model = new LoginModel($conn);

    }
    public function loginUser($username, $password) {

        $user = $this->model->getUserByUsername($username); 

        if ($user && password_verify($password, $user['password'])) {

            //Security Check for avoid brute force attacks
            $loginAttempts = $this->model->getLoginAttempts($user['id']);

            if($loginAttempts>5) {
                $ipAddress = $this->getUserIP();
                $response = $this->model->setLoginAttempts($user['id'], $ipAddress, false);
                return [
                    'status' => 'warning',
                    'message' => 'Due to security reasons, you were unable to log in. Please try again after 20 minutes.'
                ];
            } else {
                $ipAddress = $this->getUserIP();
                $response = $this->model->setLoginAttempts($user['id'], $ipAddress, true);
            }

            return [
                'status' => 'success',
                'message' => 'Login successful'
            ];
        } else {

            //Security Check for avoid brute force attacks
            $loginAttempts = $this->model->getLoginAttempts($user['id']);

            if($loginAttempts>5) {
                $ipAddress = $this->getUserIP();
                $response = $this->model->setLoginAttempts($user['id'], $ipAddress, false);
                return [
                    'status' => 'warning',
                    'message' => 'Due to security reasons, you were unable to log in. Please try again after 20 minutes.'
                ];
            } else {
                $ipAddress = $this->getUserIP();
                $response = $this->model->setLoginAttempts($user['id'], $ipAddress, false);
            }
            return [
                'status' => 'error',
                'message' => 'Invalid credentials'
            ];
        }
    }

    public function getUserIP() {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // HTTP_X_FORWARDED_FOR can contain a comma-separated list of IPs
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($ipList as $ip) {
                if (filter_var(trim($ip), FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        } elseif (isset($_SERVER['HTTP_X_FORWARDED']) && filter_var($_SERVER['HTTP_X_FORWARDED'], FILTER_VALIDATE_IP)) {
            return $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && filter_var($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'], FILTER_VALIDATE_IP)) {
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR']) && filter_var($_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED']) && filter_var($_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
            return $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) && filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) {
            return $_SERVER['REMOTE_ADDR'];
        }
        return 'UNKNOWN';
    }
    
}