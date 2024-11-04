<?php

require_once '../Services/DailyReportService.php';

class DailyReportController {
    private $dailyReoprtService;
    public function __construct() {
        $this->dailyReoprtService = new DailyReportService();

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
            echo json_encode(['status' => 'error', 'message' => 'Invalid request!', 'error' => $action . "this method is not exit"]);
        }
    }

    private function getFuelType() {
        echo json_encode($this->dailyReoprtService->getFuelType());
    }

    private function createDailyReport() {
        $carNumber = $_POST['car-id'];
        $driverName = $_POST['driver-name'];
        $cabCompany = $_POST['cabcompany'];
        $date = $_POST['date'];
        $startKM = $_POST['st-km'];
        $startDate = $_POST['st-date'];
        $startTime = $_POST['st-time'];
        $endKM = $_POST['ed-km'];
        $endDate = $_POST['ed-date'];
        $endTime = $_POST['ed-time'];

        echo json_encode($this->dailyReoprtService->createDailyReport($carNumber, $driverName, $cabCompany, $date, $startKM, $startDate, $startTime, $endKM, $endDate, $endTime));
    }

    private function getDailyReportCard() {
        echo json_encode($this->dailyReoprtService->getDailyReportCard());
    }

    private function getDailyReports() {
        echo json_encode($this->dailyReoprtService->getDailyReports());
    }

    private function getCarEdit() {
        echo json_encode($this->dailyReoprtService->getCarEdit($_POST['carId']));
    }

    private function updateCar() {
        $dailyReportId = $_POST['daily_id'];
        $carNumber = $_POST['car-id'];
        $driverName = $_POST['driver-name'];
        $cabCompany = $_POST['cabcompany'];
        echo $_POST['cabcompany'];
        $date = $_POST['date'];
        $startKM = $_POST['st-km'];
        $startDate = $_POST['st-date'];
        $startTime = $_POST['st-time'];
        $endKM = $_POST['ed-km'];
        $endDate = $_POST['ed-date'];
        $endTime = $_POST['ed-time'];

        echo json_encode($this->dailyReoprtService->updateCar($dailyReportId,$carNumber, $driverName, $cabCompany, $date, $startKM, $startDate, $startTime, $endKM, $endDate, $endTime));
    
    }

    private function getCarView() {
        echo json_encode($this->dailyReoprtService->getCarView($_POST['carId']));
    }

    private function deleteCar() {
        echo json_encode($this->dailyReoprtService->deleteCar($_POST['carId']));
    }

    private function applyFilter() {

        $filterData = [
            'days' => $_POST['days'] ?? null,
            'fromDate' => $_POST['filter-from-date'] ?? null,
            'toDate' => $_POST['filter-to-date'] ?? null,
            'car' => $_POST['filter-car'] ?? null,
            'driver' => $_POST['filter-driver'] ?? null,
            'company' => $_POST['filter-company'] ?? null,
            'orderBy' => $_POST['orderBy'] ?? null
        ];
        // print_r($filterData);
        echo json_encode($this->dailyReoprtService->applyFilter($filterData));

        // echo json_encode($_POST);
    }
}

new DailyReportController();