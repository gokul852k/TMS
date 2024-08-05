<?php

require_once '../Services/DailyReportService.php';
class DailyReportController {
    private $serviceDR;
    public function __construct() {
        $this->serviceDR = new DailyReportService();

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
            echo json_encode(['status' => 'error', 'message' => 'Invalid request!', 'error' => $action . "this method is not exit". $_POST['driverId']]);
        }
    }

    private function createDailyReport() {
        echo json_encode($this->serviceDR->createDailyReport($_POST['bus-id']));
    }

    private function createTrip() {
        echo json_encode($this->serviceDR->createTrip($_POST['start-route'], $_POST['end-route'], $_POST['start-km']));
    }
}

new DailyReportController();