<?php

require_once '../../config.php';
require_once '../Models/DailyReportModel.php';
class DailyReportService {
    private $modelBMS;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        global $bmsDB;
        $this->modelBMS = new DailyReportModel($bmsDB);
    }

    public function getTranslationsLabels($pageId) {
        $response = $this->modelBMS->getTranslationsLabels($pageId, $_SESSION['languageCode']);
        if ($response) {
            return $response;
        } else {
            return null;
        }
    }

    public function getDisplay() {

        $currentDate = date('Y-m-d');

        $driverShift = $this->modelBMS->checkDriverShiftByDriverId($_SESSION['driverId']);

        if (!$driverShift) {
            return [
                'status' => 'success',
                'display' => 'SELECT BUS',
                'message' => 'Now we want to display the SELECT BUS'
            ];
        } else {
            return [
                'status' => 'success',
                'display' => 'SELECT TRIP',
                'message' => 'Now we want to display the SELECT TRIP'
            ];
        }
    }

    public function getDisplayTrip() {

        $driverTrip = $this->modelBMS->getDisplayTrip($_SESSION['driverId']);

        if (!$driverTrip) {
            return [
                'status' => 'success',
                'display' => 'TRIP START',
                'message' => 'Now we want to display the TRIP START'
            ];
        } else {
            return [
                'status' => 'success',
                'display' => 'TRIP END',
                'tripId' => $driverTrip['trip_id'],
                'tripDriverId' => $driverTrip['trip_driver_id'],
                'message' => 'Now we want to display the TRIP END'
            ];
        }
    }

    public function getDisplayStartTrip($tripId) {
        $tripDetails = $this->modelBMS->getDisplayStartTrip($tripId);

        if ($tripDetails) {
            return [
                'status' => 'success',
                'message' => 'Now we want to display the Start KM'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Error while fetching trip data'
            ];
        }
    }

    public function getTripDetails($tripId) {
        $tripDetails = $this->modelBMS->getTripDetails($tripId, $_SESSION['languageCode']);

        if ($tripDetails) {
            return [
                'status' => 'success',
                'data' => $tripDetails,
                'message' => 'Now we want to display the SELECT BUS'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Error while fetching trip data'
            ];
        }
    }

    public function getBuses() {
        $response = $this->modelBMS->getBuses($_SESSION['companyId']);
        if($response) {
            return $response;
        } else {
            return null;
        }
    }

    public function createDailyReport($busId) {
        //1) -> Check if a daily report for the current date already exists for the given bus ID; if not, create a new daily report.
        //2) -> heck if the shift is open; if not, create a new shift.
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        $dailyReport = $this->modelBMS->checkDateAndBusId($busId, $currentDate);

        if (!$dailyReport) {
            // If $dailyReport is have 0 row, This will create a new daily report and new shift.
            // Create daily report
            $responseDR = $this->modelBMS->setDailyReport($_SESSION['companyId'], $busId, $currentDate);

            if (!$responseDR['status'] == 'success') {
                return [
                    'status' => 'Oops!',
                    'message' => 'Something went wrong while start work',
                    'error' => 'Error while insert daily report in daily report table.'
                ];
            }

            $reportId = $responseDR['reportId'];
            $shiftNameId = $this->getCurrentShift();

            // Create Shift
            $responseSH = $this->modelBMS->setShift($_SESSION['companyId'], $reportId, $shiftNameId, $currentDate, $currentTime);

            if (!$responseSH['status'] == 'success') {
                return [
                    'status' => 'Oops!',
                    'message' => 'Something went wrong while start work',
                    'error' => 'Error while insert shift in shifts table.'
                ];
            }

            $shiftId = $responseSH['shiftId'];
            //Insert shift workers
            $responseSW = $this->modelBMS->setShiftWorker($_SESSION['companyId'], $_SESSION['driverId'], $shiftId, $currentDate, $currentTime);

            if ($responseSW['status'] == 'success') {
                return [
                    "status" => "success",
                    "message" => "Happy Journey."
                ];
            } else {
                return [
                    'status' => 'Oops!',
                    'message' => 'Something went wrong while start work',
                    'error' => 'Error while insert shift in shifts table.'
                ];
            }

        } else {
            // If $dailyReport is have row, this will check if a shift exists and, if shift currently open or closed.
            $reportId = $dailyReport[0]['report_id'];
            $shift = $this->modelBMS->checkShiftStatus($reportId);

            if (!$shift) {
                // If $shift is have no row, This will create a new shift.

                $shiftNameId = $this->getCurrentShift();

                // Create Shift
                $responseSH = $this->modelBMS->setShift($_SESSION['companyId'], $reportId, $shiftNameId, $currentDate, $currentTime);

                if (!$responseSH['status'] == 'success') {
                    return [
                        'status' => 'Oops!',
                        'message' => 'Something went wrong while start work',
                        'error' => 'Error while insert shift in shifts table.'
                    ];
                }

                $shiftId = $responseSH['shiftId'];

                //Insert shift workers
                $responseSW = $this->modelBMS->setShiftWorker($_SESSION['companyId'], $_SESSION['driverId'], $shiftId, $currentDate, $currentTime);

                if ($responseSW['status'] == 'success') {
                    return [
                        "status" => "success",
                        "message" => "Happy Journey."
                    ];
                } else {
                    return [
                        'status' => 'Oops!',
                        'message' => 'Something went wrong while start work',
                        'error' => 'Error while insert shift in shifts table.'
                    ];
                }
            } else {
                $driverShift = $this->modelBMS->checkDriverShift($shift['shift_id'], $_SESSION['driverId']);

                if (!$driverShift) {

                    //Insert shift workers
                    $responseSW = $this->modelBMS->setShiftWorker($_SESSION['companyId'], $_SESSION['driverId'], $shift['shift_id'], $currentDate, $currentTime);

                    if ($responseSW['status'] == 'success') {
                        return [
                            "status" => "success",
                            "message" => "Happy Journey."
                        ];
                    } else {
                        return [
                            'status' => 'Oops!',
                            'message' => 'Something went wrong while start work',
                            'error' => 'Error while insert shift in shifts table.'
                        ];
                    }
                } else {
                    return [
                        'status' => 'Oops!',
                        'message' => 'Something went wrong while start work',
                        'error' => 'Error daily report created and shift is created and shift driver created bus driver will see the select bus. The error in the view page.'
                    ];
                }
            }
        }

    }

    public function getCurrentShift() {
        $currentHour = date('H');

        if ($currentHour >= 1 && $currentHour <= 8) {
            return 1; //First Shift
        } elseif ($currentHour > 8 && $currentHour <= 16) {
            return 2; //Second Shift
        } else {
            return 3; //Third Shift
        }
    }

    public function getRoutes() {
        return $this->modelBMS->getRoutes($_SESSION['companyId'], $_SESSION['languageCode']);
    }

    public function startTrip($startRoute, $endRoute, $startKm) {
        $response1 = $this->modelBMS->getShiftIdByDriverId($_SESSION['driverId']);
        if (!$response1) {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while start trip',
                'error' => 'Error while select shift id from shift driver table.'
            ];
        }
        $response2 = $this->modelBMS->createTrip($_SESSION['companyId'], $response1['shiftId'], $startRoute, $endRoute, $startKm);

        if ($response2['status'] != 'success') {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while start trip',
                'error' => 'Error while insert trip from trip table.'
            ];
        }

        //Loop and insert trip_driver and trip_conductor
        $response3 = $this->modelBMS->createTripDriver($_SESSION['companyId'], $response2['tripId'], $_SESSION['driverId']);

        if ($response2['status'] != 'success') {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while start trip',
                'error' => 'Error while insert driver from trip driver table.'
            ];
        } else {
            return [
                "status" => "success",
                "message" => "Trip Started."
            ];
        }
    }

    public function startTrip2($tripId, $startKm) {
        $response = $this->modelBMS->updateTripStartKm($tripId, $startKm);
        if ($response) {
            return [
                "status" => "success",
                "message" => "Trip Started."
            ];
        } else {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while start trip',
                'error' => 'Error while select shift id from shift driver table.'
            ];
        }
        
    }

    public function endTrip($tripId, $tripDriverId, $endKm) {
        $updateTrip = $this->modelBMS->updateEndTrip($tripId, $endKm);
        $updateTripDriver = $this->modelBMS->updateTripDriverStatus($tripDriverId);

        //Check for change trip status
        if ($updateTrip && $updateTripDriver) {
            $checkTripStatus = $this->modelBMS->checkTripStatus($tripId);

            if (!$checkTripStatus) {
                $updateTripStatus = $this->modelBMS->updateTripStatus($tripId);

                if ($updateTripStatus) {
                    return [
                        'status' => 'success',
                        'message' => 'Trip ended.',
                        'tripId' => $tripId
                    ];
                } else {
                    return [
                        'status' => 'success',
                        'message' => 'Trip ended.',
                        'tripId' => $tripId,
                        'error' => 'Error while updating trip status'
                    ];
                }
            } else {
                return [
                    'status' => 'success',
                    'message' => 'Trip ended.',
                    'tripId' => $tripId
                ];
            }
        } else {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while start trip',
                'error' => 'Error while updating trip and driver trip in table.'
            ];
        }
        
    }

    public function endDuty($tripId) {
        $shift = $this->modelBMS->getShiftId($tripId);

        if (!$shift) {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while end duty',
                'error' => 'Error while fetch shift data in trip table.'
            ];
        }

        $shiftId = $shift['shift_id'];

        //Update shift driver

        $updateDriverStatus = $this->modelBMS->updateDriverShiftStatus($shiftId);

        if (!$updateDriverStatus) {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while end duty',
                'error' => 'Error while update work_status in shift driver table.'
            ];
        }

        //check for conductor work status is true

        $conductor = false;

        if (!$conductor) {
            $updateShiftStatus = $this->modelBMS->updateShiftStatus($shiftId);

            if (!$updateShiftStatus) {
                return [
                    'status' => 'success',
                    'message' => 'Duty ended successfully.',
                    'error' => 'Error while update status in shift table.'
                ];
            }
            return [
                'status' => 'success',
                'message' => 'Duty ended successfully.',
                'error' => ''
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Duty ended successfully.'
        ];
    }

    public function endDuty2() {
        $driverShift = $this->modelBMS->getShiftIdByDriverId($_SESSION['driverId']);

        if (!$driverShift) {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while end duty',
                'error' => 'Error while fetch driver shift data in trip table.'
            ];
        }

        $shiftId = $driverShift['shiftId'];

        //Update shift driver

        $updateDriverStatus = $this->modelBMS->updateDriverShiftStatus($shiftId);

        if (!$updateDriverStatus) {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while end duty',
                'error' => 'Error while update work_status in shift driver table.'
            ];
        }

        //check for conductor work status is true

        $conductor = false;

        if (!$conductor) {
            $updateShiftStatus = $this->modelBMS->updateShiftStatus($shiftId);

            if (!$updateShiftStatus) {
                return [
                    'status' => 'success',
                    'message' => 'Duty ended successfully.',
                    'error' => 'Error while update status in shift table.'
                ];
            }
            return [
                'status' => 'success',
                'message' => 'Duty ended successfully.',
                'error' => ''
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Duty ended successfully.'
        ];
    }
}