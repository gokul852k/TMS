<?php

require_once '../../config.php';
require_once '../Models/BusModel.php';
require_once '../Services/FileUpload.php';

class BusService {
    private $modelBMS;

    private $modelA;
    private $mail;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        global $bmsDB;
        global $authenticationDB;
        $this->modelBMS = new BusModel($bmsDB);
        $this->modelA = new BusModel($authenticationDB);
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

    public function createBus($busNumber, $busModel, $seatingCapacity, $fuelType, $busStatus, $rcBookNumber, $insuranceNumber, $rcBookExpiry, $insuranceExpiry, $rcBook, $insurance)
    {


        $uploadService = new FileUpload();

        //Upload RC Book

        $rcBook_dir = "../../Assets/User/RC book/";

        $rcBook_filename = $uploadService->uploadFile($rcBook, $rcBook_dir);

        $rcBook_path = $rcBook_filename['status'] === 'success' ? 'RC book/' . $rcBook_filename['fileName'] : '';

        //Upload Insurance

        $insurance_dir = "../../Assets/User/Bus insurance/";

        $insurance_filename = $uploadService->uploadFile($insurance, $insurance_dir);

        $insurance_path = $insurance_filename['status'] === 'success' ? 'Bus insurance/' . $insurance_filename['fileName'] : '';

        //Insert Driver details in drivers table in bms DB

        $response = $this->modelBMS->setBus($_SESSION['companyId'], $busNumber, $busModel, $seatingCapacity, $fuelType, $busStatus, $rcBookNumber, $insuranceNumber, $rcBookExpiry, $insuranceExpiry, $rcBook_path, $insurance_path);

        if (!$response) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while creating the bus',
                'error' => 'Error while insert data in bus table.'
            ];
        }

        return [
            "status" => "success",
            "message" => "The bus has created successfully."
        ];

    }
}