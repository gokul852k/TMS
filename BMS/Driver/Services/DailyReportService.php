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
        $dailyReport = $this->modelBMS->checkDateAndBusId($busId, $currentDate);

        if (!$dailyReport) {
            // If $dailyReport is have 0 row, This will create a new daily report and new shift.
            // Create daily report
            $responseDR = $this->modelBMS->setDailyReport($_SESSION['companyId'], $busId, $currentDate);

            if (!$responseDR['status'] == 'success') {
                return [
                    'status' => 'error',
                    'message' => 'Something went wrong while start work',
                    'error' => 'Error while insert daily report in daily report table.'
                ];
            }

            // Create Shift
            $responseSH = $this->modelBMS->setShift();

        } else {
            // If $dailyReport is have row, this will check if a shift exists and, if shift currently open or closed.
            $shift = $this->modelBMS->checkShiftStatus($dailyReport['report_id']);

            if (!$shift) {
                // If $shift is have no row, This will create a new shift.
            } 
        }

    }
}