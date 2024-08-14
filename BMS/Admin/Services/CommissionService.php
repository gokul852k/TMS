<?php

require_once '../../config.php';
require_once '../Models/CommissionModel.php';
require_once '../Services/FileUpload.php';

class CommissionService {
    private $modelBMS;

    private $modelA;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        global $bmsDB;
        global $authenticationDB;
        $this->modelBMS = new CommissionModel($bmsDB);
        $this->modelA = new CommissionModel($authenticationDB);
    }

    public function getFuelType() {
        $response = $this->modelBMS->getFuelType();

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

    public function createCommission($rangeFrom, $rangeTo, $amountPerCommission, $commissionAmount)
    {
        //Insert Commission details in drivers table in bms DB

        $response = $this->modelBMS->setCommission($_SESSION['companyId'], $rangeFrom, $rangeTo, $amountPerCommission, $commissionAmount);

        if ($response['status'] == 'success') {
            return [
                "status" => "success",
                "message" => "The commisiion added successfully."
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while creating the bus',
                'error' => 'Error while insert data in commission table.'
            ];
        }
    }

    public function updateBus($busId, $busNumber, $busModel, $seatingCapacity, $fuelTypeId, $driverSalary, $conductorSalary, $busStatus, $rcbookNo, $insuranceNo, $rcbookExpiry, $insuranceExpiry, $rcBook, $insurance) {
        $busInfo = [
            "bus_number" => $busNumber,
            "bus_model" => $busModel,
            "seating_capacity" => $seatingCapacity,
            "fuel_type_id" => $fuelTypeId,
            "rcbook_no" => $rcbookNo,
            "rcbook_expiry" => $rcbookExpiry,
            "insurance_no" => $insuranceNo,
            "insurance_expiry" => $insuranceExpiry,
            "driver_salary" => $driverSalary,
            "conductor_salary" => $conductorSalary,
            "bus_status" => $busStatus
        ];

        $currentData = $this->modelBMS->getBus($busId);

        if (!$currentData) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while updating the bus',
                'error' => 'Error while select driver data from bus table.'
            ];
        }

        //Check for changes
        $changes = [];
        $fields = ['bus_number', 'bus_model', 'seating_capacity', 'fuel_type_id', 'rcbook_no', 'rcbook_expiry', 'insurance_no', 'insurance_expiry', 'driver_salary', 'conductor_salary', 'bus_status'];

        //check & upload file changes
        $fileChanges = false;

        $uploadService = new FileUpload();

        //Upload RC Book
        if (isset($rcBook) && $rcBook['error'] === UPLOAD_ERR_OK) {
            $rcBook_dir = "../../Assets/User/RC book/";

            $rcBook_filename = $uploadService->uploadFile($rcBook, $rcBook_dir);

            $rcBook_path = $rcBook_filename['status'] === 'success' ? 'RC book/' . $rcBook_filename['fileName'] : '';

            $fields[] = 'rcbook_path';
            $busInfo['rcbook_path'] = $rcBook_path;
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
            $busInfo['insurance_path'] = $insurance_path;
            $fileChanges = true;
            //Delete old file
            $old2 = "../../Assets/User/" . $currentData['insurance_path'];
            if (file_exists($old2) && is_file($old2)) {
                unlink($old2);
            }
        }


        foreach ($fields as $field) {
            if ($busInfo[$field] != $currentData[$field]) {
                $changes[$field] = $busInfo[$field];
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

            $update_values['id'] = $busId;

            $final_response = $this->modelBMS->updateBus($update_fields, $update_values);

            if ($final_response) {
                return [
                    'status' => 'success',
                    'message' => 'Bus details updated successfully'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Something went wrong while updating the bus',
                    'error' => 'Error while update bus data in driver table.'
                ];
            }

        } else {
            return [
                'status' => 'error',
                'message' => 'There are no changes in bus details.',
                'error' => 'All values as in bus table'
            ];
        }
    }

    public function getBusCardDetails() {
        $response = $this->modelBMS->getBusCardDetails($_SESSION['companyId']);
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

    public function getCommission()
    {
        $response = $this->modelBMS->getCommission($_SESSION['companyId']);
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

    public function getBusEdit($busId)
    {
        $response = $this->modelBMS->getBus($busId);
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

    public function getBusView($busId) {
        $response = $this->modelBMS->getBusView($busId);
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

    public function deleteBus($busId) {
        $currentData = $this->modelBMS->getBus($busId);

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

        $response = $this->modelBMS->deleteBus($busId);

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