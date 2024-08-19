<?php

require_once '../Services/CarService.php';

class CarController {
    private $carService;
    public function __construct() {
        $this->carService = new CarService();

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
        echo json_encode($this->carService->getFuelType());
    }

    private function createCar() {
        $carNumber = $_POST['car-number'];
        $carModel = $_POST['car-model'];
        $seatingCapacity = $_POST['seating-capacity'];
        $fuelType = $_POST['fuel-type'];
        $carStatus = $_POST['car-status'];
        $rcBookNumber = $_POST['rc-book-number'];
        $insuranceNumber = $_POST['insurance-number'];
        $rcBookExpiry = $_POST['rc-book-expiry'];
        $insuranceExpiry = $_POST['insurance-expiry'];
        $rcBook = $_FILES['rc-book'];
        $insurance = $_FILES['insurance'];

        echo json_encode($this->carService->createCar($carNumber, $carModel, $seatingCapacity, $fuelType, $carStatus, $rcBookNumber, $insuranceNumber, $rcBookExpiry, $insuranceExpiry, $rcBook, $insurance));
    }

    private function getCarCardDetails() {
        echo json_encode($this->carService->getCarCardDetails());
    }

    private function getCares() {
        echo json_encode($this->carService->getCares());
    }

    private function getCarEdit() {
        echo json_encode($this->carService->getCarEdit($_POST['carId']));
    }

    private function updateCar() {
        $carId = $_POST['car_id'];
        $carNumber = $_POST['car_number'];
        $carModel = $_POST['car_model'];
        $seatingCapacity = $_POST['seating_capacity'];
        $fuelTypeId = $_POST['fuel_type_id'];
        $carStatus = $_POST['car_status'];
        $rcbookNo = $_POST['rcbook_no'];
        $insuranceNo = $_POST['insurance_no'];
        $rcbookExpiry = $_POST['rcbook_expiry'];
        $insuranceExpiry = $_POST['insurance_expiry'];

        $rcBook = $_FILES['rcbook_path'];
        $insurance = $_FILES['insurance_path'];

        echo json_encode($this->carService->updateCar($carId, $carNumber, $carModel, $seatingCapacity, $fuelTypeId, $carStatus, $rcbookNo, $insuranceNo, $rcbookExpiry, $insuranceExpiry, $rcBook, $insurance));
    
    }

    private function getCarView() {
        echo json_encode($this->carService->getCarView($_POST['carId']));
    }

    private function deleteCar() {
        echo json_encode($this->carService->deleteCar($_POST['carId']));
    }
}

new CarController();