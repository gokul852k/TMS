<?php
require_once '../config.php';
require_once '../Models/LoginModel.php';

class LoginService
{
    private $model;
    public function __construct()
    {

        global $conn;
        $this->model = new LoginModel($conn);

    }
    public function loginUser($username, $password)
    {

        $user = $this->model->getUserByUsername($username);

        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'User does not exist'
            ];
        }

        if ($user && password_verify($password, $user['password'])) {

            //Security Check for avoid brute force attacks
            $loginAttempts = $this->model->getLoginAttempts($user['id']);

            if ($loginAttempts > 5) {
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

            //Update Token
            $token = $this->generateToken($user['id']);
            if ($this->model->updateToken($user['id'], $token)) {
                //Get the redirect URL (User want to go which system)
                $redirectUrl = '../../Common/Common function/';
                $redirectUrl = $this->systemURL($user['id']);
                if (!$redirectUrl) {
                    return [
                        'status' => 'error',
                        'message' => 'Something went wrong'
                    ];
                } else {
                    return [
                        'status' => 'success',
                        'message' => 'Login successful',
                        'userId' => $user['id'],
                        'token' => $token,
                        'redirect' => $redirectUrl
                    ];
                }
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Something went wrong'
                ];
            }


        } else {

            //Security Check for avoid brute force attacks
            $loginAttempts = $this->model->getLoginAttempts($user['id']);

            if ($loginAttempts > 5) {
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
                'message' => 'Invalid username or password'
            ];
        }
    }

    public function getUserIP()
    {
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

    public function generateToken($userid)
    {
        $randomBytes = bin2hex(random_bytes(16)); // Generates a 32-character random string
        $timestamp = time(); // Current timestamp
        $token = hash('sha256', $userid . $randomBytes . $timestamp); // Combines all to generate a token
        return $token;
    }

    public function systemURL($userid)
    {
        $response = $this->model->getSystemIdAndRoleIdByUserId($userid);

        if (!$response) {
            return false;
        } else {
            switch ($response['system_id']) {
                case 0:
                    if ($response['role_id'] == 1) {
                        return '../../Master Admin/Controllers/SessionController.php';
                    } else {
                        return false;
                    }
                case 1:
                    if ($response['role_id'] == 2) {
                        return '../../CMS/Admin/Controllers/SessionController.php';
                    } else if ($response['role_id'] == 3) {
                        return '../../CMS/Driver/Controllers/SessionController.php';
                    } else {
                        return false;
                    }
                case 2:
                    if ($response['role_id'] == 2) {
                        return '../../BMS/Admin/Controllers/SessionController.php';
                    } else if ($response['role_id'] == 3) {
                        return '../../BMS/Driver/Controllers/SessionController.php';
                    } else if ($response['role_id'] == 4) {
                        return '../../BMS/Conductor/Controllers/SessionController.php';
                    } else {
                        return false;
                    }
            }
        }


    }
}