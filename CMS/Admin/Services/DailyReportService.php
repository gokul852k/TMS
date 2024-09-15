<?php

require_once '../../config.php';
require_once '../Models/DailyReportModel.php';
require_once '../Services/FileUpload.php';

class DailyReportService {
    private $modelCMS;

    private $modelA;
    private $mail;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        global $cmsDB;
        global $authenticationDB;
        $this->modelCMS = new DailyReportModel($cmsDB);
        $this->modelA = new DailyReportModel($authenticationDB);
    }

    public function getFuelType() {
        $response = $this->modelCMS->getFuelType();

        if (!$response) {
            return [
                'status' => 'error',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function createCar($carNumber, $carModel, $seatingCapacity, $fuelType, $carStatus, $rcBookNumber, $insuranceNumber, $rcBookExpiry, $insuranceExpiry, $rcBook, $insurance)
    {


        $uploadService = new FileUpload();

        //Upload RC Book

        $rcBook_dir = "../../Assets/User/RC book/";

        $rcBook_filename = $uploadService->uploadFile($rcBook, $rcBook_dir);

        $rcBook_path = $rcBook_filename['status'] === 'success' ? 'RC book/' . $rcBook_filename['fileName'] : '';

        //Upload Insurance

        $insurance_dir = "../../Assets/User/Car insurance/";

        $insurance_filename = $uploadService->uploadFile($insurance, $insurance_dir);

        $insurance_path = $insurance_filename['status'] === 'success' ? 'Car insurance/' . $insurance_filename['fileName'] : '';

        //Insert Driver details in drivers table in bms DB

        $response1 = $this->modelCMS->setCar($_SESSION['companyId'], $carNumber, $carModel, $seatingCapacity, $fuelType, $carStatus, $rcBookNumber, $insuranceNumber, $rcBookExpiry, $insuranceExpiry, $rcBook_path, $insurance_path);

        $response2 = $this->modelCMS->setCarSummary($_SESSION['companyId'], $response1['carId']);
        if ($response1['status'] == 'success' && $response2['status'] == 'success') {
            return [
                "status" => "success",
                "message" => "The car has created successfully."
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while creating the car',
                'error' => 'Error while insert data in car table.'
            ];
        }
    }

    public function updateCar($carId, $carNumber, $carModel, $seatingCapacity, $fuelTypeId, $carStatus, $rcbookNo, $insuranceNo, $rcbookExpiry, $insuranceExpiry, $rcBook, $insurance) {
        $carInfo = [
            "car_number" => $carNumber,
            "car_model" => $carModel,
            "seating_capacity" => $seatingCapacity,
            "fuel_type_id" => $fuelTypeId,
            "rcbook_no" => $rcbookNo,
            "rcbook_expiry" => $rcbookExpiry,
            "insurance_no" => $insuranceNo,
            "insurance_expiry" => $insuranceExpiry,
            "car_status" => $carStatus
        ];

        $currentData = $this->modelCMS->getCar($carId);

        if (!$currentData) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while updating the car',
                'error' => 'Error while select driver data from car table.'
            ];
        }

        //Check for changes
        $changes = [];
        $fields = ['car_number', 'car_model', 'seating_capacity', 'fuel_type_id', 'rcbook_no', 'rcbook_expiry', 'insurance_no', 'insurance_expiry', 'car_status'];

        //check & upload file changes
        $fileChanges = false;

        $uploadService = new FileUpload();

        //Upload RC Book
        if (isset($rcBook) && $rcBook['error'] === UPLOAD_ERR_OK) {
            $rcBook_dir = "../../Assets/User/RC book/";

            $rcBook_filename = $uploadService->uploadFile($rcBook, $rcBook_dir);

            $rcBook_path = $rcBook_filename['status'] === 'success' ? 'RC book/' . $rcBook_filename['fileName'] : '';

            $fields[] = 'rcbook_path';
            $carInfo['rcbook_path'] = $rcBook_path;
            $fileChanges = true;
            //Delete old file
            $old1 = "../../Assets/User/" . $currentData['rcbook_path'];
            if (file_exists($old1) && is_file($old1)) {
                unlink($old1);
            }
        }

        
        //Upload Insurance
        if (isset($insurance) && $insurance['error'] === UPLOAD_ERR_OK) {
            $insurance_dir = "../../Assets/User/Bus insurance/";

            $insurance_filename = $uploadService->uploadFile($insurance, $insurance_dir);

            $insurance_path = $insurance_filename['status'] === 'success' ? 'Bus insurance/' . $insurance_filename['fileName'] : '';

            $fields[] = 'insurance_path';
            $carInfo['insurance_path'] = $insurance_path;
            $fileChanges = true;
            //Delete old file
            $old2 = "../../Assets/User/" . $currentData['insurance_path'];
            if (file_exists($old2) && is_file($old2)) {
                unlink($old2);
            }
        }


        foreach ($fields as $field) {
            if ($carInfo[$field] != $currentData[$field]) {
                $changes[$field] = $carInfo[$field];
            }
        }

        // Construct and execute dynamic SQL query if there are changes
        if (!empty($changes) || $fileChanges) {
            $update_fields = [];
            $update_values = [];

            foreach ($changes as $field => $new_value) {
                $update_fields[] = "$field = :$field";
                $update_values[":$field"] = $new_value;
            }

            $update_values['id'] = $carId;

            $final_response = $this->modelCMS->updateCar($update_fields, $update_values);

            if ($final_response) {
                return [
                    'status' => 'success',
                    'message' => 'Bus details updated successfully'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Something went wrong while updating the car',
                    'error' => 'Error while update car data in driver table.'
                ];
            }

        } else {
            return [
                'status' => 'error',
                'message' => 'There are no changes in car details.',
                'error' => 'All values as in car table'
            ];
        }
    }

    public function getCarCardDetails() {
        $response = $this->modelCMS->getCarCardDetails($_SESSION['companyId']);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function getDailyReports()
    {
        $response = $this->modelCMS->getDailyReports($_SESSION['companyId']);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function getCarEdit($carId)
    {
        $response = $this->modelCMS->getCar($carId);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function getCarView($carId) {
        $response = $this->modelCMS->getCarView($carId);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function deletecar($busId) {
        $currentData = $this->modelCMS->getCar($busId);

        if (!$currentData) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while deleting the driver',
                'error' => 'Error while select driver data in driver table.'
            ];
        }
        //Delete old file
        $oldRC = "../../Assets/User/" . $currentData['rcbook_path'];
        if (file_exists($oldRC) && is_file($oldRC)) {
            unlink($oldRC);
        }

        //Delete old file
        $oldInsurance = "../../Assets/User/" . $currentData['insurance_path'];
        if (file_exists($oldInsurance) && is_file($oldInsurance)) {
            unlink($oldInsurance);
        }

        $response = $this->modelCMS->deleteBus($busId);

        if ($response) {
            return [
                'status' => 'success',
                'message' => 'Bus deleted successfully.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while deleting the bus',
                'error' => 'Error while delete bus data in bus table in bms DB.'
            ];
        }
    }
}