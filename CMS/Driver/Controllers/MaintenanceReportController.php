<?php

require_once '../Services/MaintenanceReportService.php';

class MaintenanceReportController
{
    private $service;
    public function __construct()
    {
        $this->service = new MaintenanceReportService();

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

    private function createFuelReport()
    {
        $busNumber = $_POST['bus-id'];
        $date = $_POST['date'];
        $fuelLiters = $_POST['fuel-liters'];
        $fuelAmount = $_POST['fuel-amount'];
        $fuelBill = $_FILES['fuel-bill'];

        echo json_encode($this->service->createFuelReport($busNumber, $date, $fuelLiters, $fuelAmount, $fuelBill));
    }

    private function getFuelReportCardDetails()
    {
        echo json_encode($this->service->getFuelReportCardDetails());
    }

    private function getCars()
    {
        echo json_encode($this->service->getCars());
    }

    private function getSpareParts()
    {
        echo json_encode($this->service->getSpareParts());
    }

    private function getDriverName()
    {
        echo json_encode($this->service->getDriverName());
    }

    private function getFuelReports()
    {
        echo json_encode($this->service->getFuelReports());
    }

    private function getFuelReport()
    {
        echo json_encode($this->service->getFuelReport($_POST['reportId']));
    }

    private function updateFuelReport()
    {
        // $fuelReportId = 2;
        $fuelReportId = $_POST['fuel_report_id'];
        $busId = $_POST['bus_id'];
        $fuelDate = $_POST['fuel_date'];
        $fuelQuantity = $_POST['fuel_quantity'];
        $fuelCost = $_POST['fuel_cost'];
        $fuelBill = $_FILES['fuel_bill_url'];

        echo json_encode($this->service->updateFuelReport($fuelReportId, $busId, $fuelDate, $fuelQuantity, $fuelCost, $fuelBill));

    }

    private function deleteFuelReport()
    {
        echo json_encode($this->service->deleteFuelReport($_POST['reportId']));
    }

    private function createMaintenanceReport()
    {
        $panCard = $_FILES['upload_bill'];
        // echo json_encode($_POST);
        echo json_encode($this->service->createMaintenanceReport($_POST, $panCard));
    }

    private function getCompany()
    {
        echo json_encode($this->service->getCompany());
    }

    private function getMaintenanceCardDetails()
    {
        echo json_encode($this->service->getMaintenanceCardDetails());
    }

    private function getMaintenanceDetails()
    {
        echo json_encode($this->service->getMaintenanceDetails());
    }


    private function getMaintenanceReportEdit()
    {
        $maintenanceReportId = $_POST['maintenance_report_id'];
        echo json_encode($this->service->getMaintenanceReportEdit($maintenanceReportId));

    }

    private function updateDailyReport() {
        // echo json_encode($_POST);
        // $maintenanceReportId = $_POST['maintenance_report_id'];
        // echo 'Hello '.$maintenanceReportId.' value ';
        $panCard = $_FILES['edit_upload_bill'];
        // echo json_encode($panCard);
        echo json_encode($this->service->updateDailyReport($_POST, $panCard));
    }

    private function getMaintenanceReportDetails() {
        $maintenanceReportId = $_POST['maintenance_report_id'];
        echo json_encode($this->service->getMaintenanceReportEdit($maintenanceReportId));
    }

    private function deleteMaintenance() {
        echo json_encode($this->service->deleteMaintenance($_POST['maintenanceReportId']));
    }

    private function applyFilter() {

        $filterData = [
            'days' => $_POST['days'] ?? null,
            'fromDate' => $_POST['filter-from-date'] ?? null,
            'toDate' => $_POST['filter-to-date'] ?? null,
            'car' => $_POST['filter-car'] ?? null,
            'driver' => $_POST['filter-driver'] ?? null,
            'spare' => $_POST['filter-spare'] ?? null,
            'chargesFrom' => $_POST['filter-charges-from'] ?? null,
            'chargesTo' => $_POST['filter-charges-to'] ?? null,
            'orderBy' => $_POST['orderBy'] ?? null
        ];
        // print_r($filterData);
        echo json_encode($this->service->applyFilter($filterData));

        // echo json_encode($_POST);
    }

}

new MaintenanceReportController();