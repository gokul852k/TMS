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

    public function createDailyReport($carNumber, $driverName, $cabCompany, $date, $startKM, $startDate, $startTime, $endKM, $endDate, $endTime)
    {

        $totalKM = $endKM - $startKM;

        if ($totalKM < 0) {
            return [
                'status' => 'error',
                'message' => 'Total KM is in Negative',
                'error' => 'Error Total KM is in Negative.'
            ];
        } 
        // else if ($endTime >= $startTime){
        //     return [
        //         'status' => 'error',
        //         'message' => 'Something went wrong while Entering Date',
        //         'error' => 'Error while insert data in daily report table.'
        //     ];
        // }

        $response1 = $this->modelCMS->setCar($_SESSION['companyId'], $carNumber, $driverName, $cabCompany, $date, $startKM, $startDate, $startTime, $endKM, $endDate, $endTime, $totalKM);

        // $response2 = $this->modelCMS->setCarSummary($_SESSION['companyId'], $response1['carId']);
        if ($response1['status'] == 'success') {
            return [
                "status" => "success",
                "message" => "The daily report has created successfully."
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while creating the daily report',
                'error' => 'Error while insert data in daily report table.'
            ];
        }
    }

    public function updateCar($dailyReportId, $carNumber, $driverName, $cabCompany, $date, $startKM, $startDate, $startTime, $endKM, $endDate, $endTime ) {

        $totalKM = $endKM - $startKM;

        $carInfo = [
            "company_id" => $_SESSION['companyId'],
            "cab_company_id" => $cabCompany,
            "car_id" => $carNumber,
            "driver_id" => $driverName,
            "admin_entry_date" => $date,
            "check_in_date" => $startDate,
            "check_in_time" => $startTime,
            "check_in_km" => $startKM,
            "check_out_date" => $endDate,
            "check_out_time" => $endTime,
            "check_out_km" => $endKM,
            "total_km" => $totalKM
        ];

        $currentData = $this->modelCMS->getCar($dailyReportId);

        if (!$currentData) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while updating the car',
                'error' => 'Error while select driver data from car table.'
            ];
        }

        //Check for changes
        $changes = [];
        $fields = ['company_id', 'cab_company_id', 'car_id', 'driver_id', 'admin_entry_date', 'check_in_date', 'check_in_time', 'check_in_km',
         'check_out_date', 'check_out_time', 'check_out_km', 'total_km'];

        // //check & upload file changes
        // $fileChanges = false;

        // $uploadService = new FileUpload();

        // //Upload RC Book
        // if (isset($rcBook) && $rcBook['error'] === UPLOAD_ERR_OK) {
        //     $rcBook_dir = "../../Assets/User/RC book/";

        //     $rcBook_filename = $uploadService->uploadFile($rcBook, $rcBook_dir);

        //     $rcBook_path = $rcBook_filename['status'] === 'success' ? 'RC book/' . $rcBook_filename['fileName'] : '';

        //     $fields[] = 'rcbook_path';
        //     $carInfo['rcbook_path'] = $rcBook_path;
        //     $fileChanges = true;
        //     //Delete old file
        //     $old1 = "../../Assets/User/" . $currentData['rcbook_path'];
        //     if (file_exists($old1) && is_file($old1)) {
        //         unlink($old1);
        //     }
        // }

        
        // //Upload Insurance
        // if (isset($insurance) && $insurance['error'] === UPLOAD_ERR_OK) {
        //     $insurance_dir = "../../Assets/User/Bus insurance/";

        //     $insurance_filename = $uploadService->uploadFile($insurance, $insurance_dir);

        //     $insurance_path = $insurance_filename['status'] === 'success' ? 'Bus insurance/' . $insurance_filename['fileName'] : '';

        //     $fields[] = 'insurance_path';
        //     $carInfo['insurance_path'] = $insurance_path;
        //     $fileChanges = true;
        //     //Delete old file
        //     $old2 = "../../Assets/User/" . $currentData['insurance_path'];
        //     if (file_exists($old2) && is_file($old2)) {
        //         unlink($old2);
        //     }
        // }


        foreach ($fields as $field) {
            if ($carInfo[$field] != $currentData[$field]) {
                $changes[$field] = $carInfo[$field];
            }
        }

        // Construct and execute dynamic SQL query if there are changes
        if (!empty($changes)) {
            $update_fields = [];
            $update_values = [];

            foreach ($changes as $field => $new_value) {
                $update_fields[] = "$field = :$field";
                $update_values[":$field"] = $new_value;
            }

            $update_values['id'] = $dailyReportId;

            $final_response = $this->modelCMS->updateCar($update_fields, $update_values);

            if ($final_response) {
                return [
                    'status' => 'success',
                    'message' => 'Daily Report updated successfully'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Something went wrong while updating the daily report',
                    'error' => 'Error while update daily report data in driver table.'
                ];
            }

        } else {
            return [
                'status' => 'error',
                'message' => 'There are no changes in Daily Report details.',
                'error' => 'All values as in daily report table'
            ];
        }
    }

    public function getDailyReportCard() {
        $response = $this->modelCMS->getDailyReportCard($_SESSION['companyId']);
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

    private function isValidDate($date)
    {
        return (bool) strtotime($date);
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

        if (!empty($filterData['company'])) {
            $filters['company'] = $filterData['company'];
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