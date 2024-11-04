<?php

require_once '../../config.php';
require_once '../Models/MaintenanceReportModel.php';
require_once '../Services/FileUpload.php';
require_once '../Services/ChartService.php';

class MaintenanceReportService
{
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
        $this->modelCMS = new MaintenanceReportModel($cmsDB);
        $this->modelA = new MaintenanceReportModel($authenticationDB);
    }

    public function getFuelType()
    {
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

    public function createMaintenanceReport($postData, $postImage)
    {

        $carId = $postData['car-id'];
        $driverId = $postData['driver-name'];
        $cabcompany = $postData['cabcompany'];
        $date = $postData['date'];
        $serviceCharge = $postData['service_charge'];
        $totalCharges = $postData['total_chargers'];


        $uploadService = new FileUpload();

        //Upload Fuel Bill

        $maintenanceBill_dir = "../../Assets/User/Maintenance bill/";

        $maintenanceBill_filename = $uploadService->uploadFile($postImage, $maintenanceBill_dir);

        $maintenanceBill_path = $maintenanceBill_filename['status'] === 'success' ? 'Maintenance bill/' . $maintenanceBill_filename['fileName'] : '';


        $setMaintenanceReport = $this->modelCMS->setMaintenanceReport($_SESSION['companyId'], $cabcompany, $carId, $driverId, $date, $serviceCharge, $totalCharges, $maintenanceBill_path);

        if ($setMaintenanceReport['status'] == 'error') {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while add the daily report',
                'error' => 'Error while set daily report in daily report table.'
            ];
        }

        $maintenanceId = $setMaintenanceReport['maintenanceId'];

        //Get Shift Data
        if (isset($postData['spare']) && is_array($postData['spare'])) {
            foreach ($postData['spare'] as $spare_data) {

                $spareID = $spare_data['sparePartId'];
                $spareQuantity = $spare_data['spareQuantity'];
                $sparePrice = $spare_data['sparePrice'];

                $setShift = $this->modelCMS->setSpareDetails($_SESSION['companyId'], $cabcompany, $maintenanceId, $spareID, $spareQuantity, $sparePrice);

                if ($setShift["status"] == "error") {
                    return [
                        'status' => 'error',
                        'message' => 'Something went wrong while add the daily report',
                        'error' => 'Error while set spare in spare table.'
                    ];
                }

            }
        }

        return [
            'status' => 'success',
            'message' => 'Daily Report Added Successfully.'
        ];
    }

    public function createFuelReport($busNumber, $date, $fuelLiters, $fuelAmount, $fuelBill)
    {

        $uploadService = new FileUpload();

        //Upload Fuel Bill

        $fuelBill_dir = "../../Assets/User/Fuel bill/";

        $fuelbill_filename = $uploadService->uploadFile($fuelBill, $fuelBill_dir);

        $fuelbill_path = $fuelbill_filename['status'] === 'success' ? 'Fuel bill/' . $fuelbill_filename['fileName'] : '';


        //Insert Fuel report in fuel_report table in bms DB

        $response = $this->modelCMS->setFuelReport($_SESSION['companyId'], $busNumber, $date, $fuelLiters, $fuelAmount, $fuelbill_path);

        if ($response['status'] == 'success') {
            return [
                "status" => "success",
                "message" => "The Fuel report added successfully."
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while insert fuel report',
                'error' => 'Error while insert data in bufuel_reports table.'
            ];
        }
    }

    public function updateFuelReport($fuelReportId, $busId, $fuelDate, $fuelQuantity, $fuelCost, $fuelBill)
    {
        $reportInfo = [
            "bus_id" => $busId,
            "fuel_date" => $fuelDate,
            "fuel_quantity" => $fuelQuantity,
            "fuel_cost" => $fuelCost
        ];

        $currentData = $this->modelCMS->getFuelReport2($fuelReportId);

        if (!$currentData) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while updating the fuel report',
                'error' => 'Error while select fuel report from fuel report table.'
            ];
        }

        //Check for changes
        $changes = [];
        $fields = ['bus_id', 'fuel_date', 'fuel_quantity', 'fuel_cost'];

        //check & upload file changes
        $fileChanges = false;

        $uploadService = new FileUpload();

        //Upload RC Book
        if (isset($fuelBill) && $fuelBill['error'] === UPLOAD_ERR_OK) {
            $fuelbill_dir = "../../Assets/User/Fuel bill/";

            $fuelbill_filename = $uploadService->uploadFile($fuelBill, $fuelbill_dir);

            $fuelbill_path = $fuelbill_filename['status'] === 'success' ? 'Fuel bill/' . $fuelbill_filename['fileName'] : '';

            $fields[] = 'fuel_bill_url';
            $reportInfo['fuel_bill_url'] = $fuelbill_path;
            $fileChanges = true;
            //Delete old file
            $old1 = "../../Assets/User/" . $currentData['fuel_bill_url'];
            if (file_exists($old1) && is_file($old1)) {
                unlink($old1);
            }
        }



        foreach ($fields as $field) {
            if ($reportInfo[$field] != $currentData[$field]) {
                $changes[$field] = $reportInfo[$field];
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

            $update_values['fuel_report_id'] = $fuelReportId;


            $final_response = $this->modelCMS->updateFuelReport($update_fields, $update_values);

            if ($final_response) {
                return [
                    'status' => 'success',
                    'message' => 'Fuel report updated successfully'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Something went wrong while updating the fuel report',
                    'error' => 'Error while update fuel report in fuel report table.'
                ];
            }

        } else {
            return [
                'status' => 'error',
                'message' => 'There are no changes in fuel report.',
                'error' => 'All values as in fuel report table'
            ];
        }
    }

    public function getFuelReportCardDetails()
    {
        $response = $this->modelCMS->getFuelReportCardDetails($_SESSION['companyId']);
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

    public function getCars()
    {
        $response = $this->modelCMS->getCars($_SESSION['companyId']);
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

    public function getSpareParts()
    {
        $response = $this->modelCMS->getSpareParts($_SESSION['languageCode']);
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
    // $_SESSION['languageCode']
    public function getDriverName()
    {
        $response = $this->modelCMS->getDriverName($_SESSION['companyId']);
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

    public function getFuelReports()
    {
        $response = $this->modelCMS->getFuelReports($_SESSION['companyId']);
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

    public function getFuelReport($reportId)
    {
        $response = $this->modelCMS->getFuelReport($reportId);
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

    public function getBusView($busId)
    {
        $response = $this->modelCMS->getBusView($busId);
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

    public function deleteFuelReport($reportId)
    {
        $currentData = $this->modelCMS->getFuelReport2($reportId);

        if (!$currentData) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while deleting the fuel report',
                'error' => 'Error while select fuel report in fuel report table.'
            ];
        }
        //Delete old file
        $old = "../../Assets/User/" . $currentData['fuel_bill_url'];
        if (file_exists($old) && is_file($old)) {
            unlink($old);
        }


        $response = $this->modelCMS->deleteFuelReport($reportId);

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

    public function getCompany()
    {
        $response = $this->modelCMS->getCompany($_SESSION['companyId']);

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

    private function isValidDate($date)
    {
        return (bool) strtotime($date);
    }

    public function getMaintenanceCardDetails()
    {
        $response = $this->modelCMS->getMaintenanceCardDetails($_SESSION['companyId']);
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

    public function getMaintenanceDetails()
    {
        $response = $this->modelCMS->getMaintenanceDetails($_SESSION['companyId']);
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


    public function getMaintenanceReportEdit($maintenanceReportId)
    {

        //1:-> Get Daily Report
        $maintenanceReport = $this->modelCMS->getMaintenanceReport1($maintenanceReportId);

        if (!$maintenanceReport) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while get the maintenance report',
                'error' => 'Error while get maintenance report in maintenance report table.'
            ];
        }

        $response = [
            "maintenanceReportId" => $maintenanceReport['maintenance_report_id'],
            "carId" => $maintenanceReport['carId'],
            "car_number" => $maintenanceReport['car_number'],
            "driverId" => $maintenanceReport['driverId'],
            "fullname" => $maintenanceReport['fullname'],
            "cabcompanyId" => $maintenanceReport['cabcompanyId'],
            "company_name" => $maintenanceReport['company_name'],
            "maintenanceDate" => $maintenanceReport['maintenance_date'],
            "serviceCharge" => $maintenanceReport['service_charge'],
            "totalCharge" => $maintenanceReport['total_charge'],
            "maintenanceBillUrl" => $maintenanceReport['maintenance_bill_url']
        ];


        //2:-> Get Shifts
        $sparePart = $this->modelCMS->getMaintenanceReport2($maintenanceReportId);

        if (count($sparePart) != 0) {
            $sparePartCount = 1;
            $sparePartArray = array();
            foreach ($sparePart as $spare) {
                // $sparId = $spare['shift_id'];
                $spareArray = [
                    "maintenance_report_sub_id" => $spare['maintenance_id'],
                    "spareId" => $spare['spare_part_id'],
                    "sparePartId" => $spare['spare_parts'],
                    "spare_name" => $spare['spare_name'],
                    "spareQuantity" => $spare['spare_parts_quantity'],
                    "sparePrice" => $spare['spare_part_cost']
                ];

                // $spareArray['spare'] = $sparePartArray;

                $sparePartArray[$sparePartCount] = $spareArray;
                $sparePartCount++;

            }

            $response['spare'] = $sparePartArray;
        } else {
            $response['spare'] = array();
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
        
    }

    public function updateDailyReport($postData, $postImage)
    {

        //Delete the User deleted records
        $deletes = json_decode($postData['deletedItems'], true);

        foreach ($deletes as $delete) {

            $shiftDelete = $this->modelCMS->deleteShift($delete['id']);

            if (!$shiftDelete) {
                return [
                    'status' => 'error',
                    'message' => 'something went wrong while update the maintenance report.',
                    'error' => 'Error while delete the shift.'
                ];

            } else {
                return [
                    'status' => 'error',
                    'message' => 'something went wrong while update the maintenance report.',
                    'error' => 'Delete type is not match.'
                ];
            }
        }

        $maintenanceReportId = $postData['maintenance_report_id'];
        $carId = $postData['edit-car-id'];
        $driverId = $postData['driver-name'];
        $cabcompany = $postData['cabcompany'];
        $date = $postData['date'];
        $serviceCharge = $postData['service_charge'];
        $totalCharges = $postData['total_chargers'];
        $maintenanceBill_path = $postData['file-url'];
        // $maintenanceBill_path = $postImage['edit_upload_bill'];
        // $maintenanceBill_path = "empty";


        // //check & upload file changes
        // $fileChanges = false;

        // $uploadService = new FileUpload();

        // //Upload RC Book
        // if (isset($maintenanceBill_path) && $maintenanceBill_path['error'] === UPLOAD_ERR_OK) {
        //     $maintenanceBill_path_dir = "../../Assets/User/Maintenance bill/";

        //     $maintenanceBill_path_filename = $uploadService->uploadFile($maintenanceBill_path, $maintenanceBill_path_dir);

        //     $maintenanceBill_path_path = $maintenanceBill_path_filename['status'] === 'success' ? 'Maintenance bill/' . $maintenanceBill_path_filename['fileName'] : '';

        //     $fields[] = 'maintenanceBill_path_path';
        //     $carInfo['maintenanceBill_path_path'] = $maintenanceBill_path_path;
        //     $fileChanges = true;
        //     //Delete old file
        //     $old1 = "../../Assets/User/" . $postImage['maintenanceBill_path_path'];
        //     if (file_exists($old1) && is_file($old1)) {
        //         unlink($old1);
        //     }
        // }

        //Get Shift Data
        if (isset($postData['spare']) && is_array($postData['spare'])) {
            foreach ($postData['spare'] as $spare_data) {


                $spareID = $spare_data['sparePartId'];
                $spareQuantity = $spare_data['spareQuantity'];
                $sparePrice = $spare_data['sparePrice'];


                if (empty($spare_data['spareId'])) {
                    $setShift = $this->modelCMS->setSpareDetails($_SESSION['companyId'], $cabcompany, $maintenanceReportId, $spareID, $spareQuantity, $sparePrice);

                    if ($setShift["status"] == "error") {
                        return [
                            'status' => 'error',
                            'message' => 'Something went wrong while add the daily report',
                            'error' => 'Error while set shift in shift table.'
                        ];
                    }

                    $sparePartID = $setShift['spareId'];
                } else {
                    $sparePartID = $spare_data['spareId'];
                    $updateShift = $this->modelCMS->updateShift2($sparePartID, $_SESSION['companyId'], $cabcompany, $maintenanceReportId, $spareID, $spareQuantity, $sparePrice);

                    if (!$updateShift) {
                        return [
                            'status' => 'error',
                            'message' => 'Something went wrong while add the daily report',
                            'error' => 'Error while set shift in shift table.'
                        ];
                    }
                }
            }
        }
        //Update Daily Report
        $updateDailyReport = $this->modelCMS->updateDailyReport($maintenanceReportId, $_SESSION['companyId'], $cabcompany, $carId, $driverId, $date, $serviceCharge, $totalCharges, $maintenanceBill_path);

        if (!$updateDailyReport) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while add the daily report',
                'error' => 'Error while update Daily report in daily report table.'
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Daily Report Updated Successfully.'
        ];
    }

    public function deleteMaintenance($maintenanceReportId) {
        $currentData = $this->modelCMS->getMaintenance($maintenanceReportId);

        if (!$currentData) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while deleting the Maintenance',
                'error' => 'Error while select Maintenance data in Maintenance table.'
            ];
        }
        //Delete old file
        $oldMaintenanceBill = "../../Assets/User/" . $currentData['maintenance_bill_url'];
        if (file_exists($oldMaintenanceBill) && is_file($oldMaintenanceBill)) {
            unlink($oldMaintenanceBill);
        }

        $response = $this->modelCMS->deleteMaintenanceReport($maintenanceReportId);

        // echo 'Hello ';
        // echo $response;
        // echo ' after response';

        if ($response) {
            return [
                'status' => 'success',
                'message' => 'Maintenance Report deleted successfully.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while deleting the Maintenance',
                'error' => 'Error while delete Maintenance data in Maintenance table in cms DB.'
            ];
        }
    }

    public function applyFilter($filterData) {
        // Validate and sanitize filters
        $filters = [];

        if (!empty($filterData['days'])) {
            if ($filterData['days'] == 1) {
                $filters['fromDate'] = date("Y-m-d");
                $filters['toDate'] = date("Y-m-d");
            } else if ($filterData['days'] == 7) {
                $filters['fromDate'] = date("Y-m-d", strtotime("-7 days"));
                $filters['toDate'] = date("Y-m-d");
            } else if ($filterData['days'] == 30) {
                $filters['fromDate'] = date("Y-m-d", strtotime("-30 days"));
                $filters['toDate'] = date("Y-m-d");
            }
        }

        if (!empty($filterData['fromDate'])  && $this->isValidDate($filterData['fromDate'])) {
            $filters['fromDate'] = $filterData['fromDate'];
        }

        if (!empty($filterData['toDate'])  && $this->isValidDate($filterData['toDate'])) {
            $filters['toDate'] = $filterData['toDate'];
        }

        if (!empty($filterData['car'])) {
            $filters['car'] = $filterData['car'];
        }

        if (!empty($filterData['driver'])) {
            $filters['driver'] = $filterData['driver'];
        }

        if (!empty($filterData['spare'])) {
            $filters['spare'] = $filterData['spare'];
        }

        if (!empty($filterData['chargesFrom'])) {
            $filters['chargesFrom'] = $filterData['chargesFrom'];
        }

        if (!empty($filterData['chargesTo'])) {
            $filters['chargesTo'] = $filterData['chargesTo'];
        }

        if (empty($filters)) {
            return [
                'status' => 'error',
                'message' => 'No filters are selected.'
            ];
        }

        if (!empty($filterData['orderBy'])) {
            $filters['orderBy'] = $filterData['orderBy'];
        }

        //Featching card count based on filter
        $cardCount = $this->modelCMS->getFilterCardCount($filters, $_SESSION['companyId']);

        //Featching FuelReport on filter
        $dailyReport = $this->modelCMS->getFilterFuelReport($filters, $_SESSION['companyId']);

        return [
            'status' => 'success',
            'cardCount' => $cardCount,
            'dailyReport' => $dailyReport
        ];

    }

}