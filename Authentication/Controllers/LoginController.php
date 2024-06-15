<?php
require_once '../Services/LoginService.php';
class LoginController {
    private $service;
    public function __construct() {

        $this->service = new LoginService();

        // Check if the request is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            die('Invalid request');
        }

        // Get the action from the AJAX request
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        // Call the appropriate method based on the action
        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request!']);
        }
    }

    private function login() {
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $result = $this->service->loginUser($username, $password);

        echo json_encode($result, true);
    }

    private function login2() {
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $result = $this->service->loginUser2($username, $password);

        echo json_encode($result, true);
    }

    private function logout() {
        echo "this is logout";
    }
}

new LoginController();