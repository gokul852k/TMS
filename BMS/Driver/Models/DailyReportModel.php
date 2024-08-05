<?php

class DailyReportModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getTranslationsLabels($pageId, $languageCode) {
        $stmt = $this->db->prepare("SELECT lt.translation FROM `bms_pages` p INNER JOIN bms_labels l ON l.page_id = p.page_id INNER JOIN bms_label_translations lt ON lt.label_id = l.label_id INNER JOIN bms_languages la ON la.id = lt.language_id WHERE p.page_id = :pageId AND la.code = :languageCode ORDER BY lt.translation_id ASC");
        $stmt->bindParam("pageId", $pageId);
        $stmt->bindParam("languageCode", $languageCode);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getBuses($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `id`, `bus_number` FROM `bms_bus` WHERE `company_id` = :companyId AND `is_active` = :isActive");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function checkDateAndBusId($busId, $currentDate) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `report_id` FROM `bms_daily_reports` WHERE `date` = :currentDate AND `bus_id` = :busId AND `is_active` = :isActive");
        $stmt->bindParam("currentDate", $currentDate);
        $stmt->bindParam("busId", $busId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function checkShiftStatus($reportId) {
        $shiftSatatus = true;
        $stmt = $this->db->prepare("SELECT `shift_id` FROM `bms_shifts` WHERE `report_id` = :reportId AND `shift_status` = :shiftSatatus");
        $stmt->bindParam("reportId", $reportId);
        $stmt->bindParam("shiftSatatus", $shiftSatatus);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setDailyReport($companyId, $busId, $currentDate) {
        $stmt = $this->db->prepare("INSERT INTO `bms_daily_reports` (`company_id`, `bus_id`, `date`) VALUES (:companyId, :busId, :currentDate)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("busId", $busId);
        $stmt->bindParam("currentDate", $currentDate);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                // Get the last inserted ID
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'reportId' => $lastId
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Insert failed.',
                    'error' => 'No reason'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Insert failed.',
                'error' => $stmt->errorInfo()
            ];
        }
    }

    public function setShift($companyId, $reportId, $shiftNameId, $currentDate, $currentTime) {

        $stmt = $this->db->prepare("INSERT INTO `bms_shifts` (`company_id`, `report_id`, `shift_name_id`, `start_date`, `start_time`) VALUES (:companyId, :reportId, :shiftNameId, :currentDate, :currentTime)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("reportId", $reportId);
        $stmt->bindParam("shiftNameId", $shiftNameId);
        $stmt->bindParam("currentDate", $currentDate);
        $stmt->bindParam("currentTime", $currentTime);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                // Get the last inserted ID
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'shiftId' => $lastId
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Insert failed.',
                    'error' => 'No reason'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Insert failed.',
                'error' => $stmt->errorInfo()
            ];
        }
    }

    public function checkDriverShift($shiftId, $driverId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `shift_driver_id` FROM `bms_shift_driver` WHERE `shift_id` = :shiftId AND `driver_id` = :driverId AND `is_active` = :isActive");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setShiftWorker($companyId, $driverId, $shiftId, $currentDate, $currentTime) {
        $stmt = $this->db->prepare("INSERT INTO `bms_shift_driver`(`company_id`, `shift_id`, `driver_id`, `start_date`, `start_time`) VALUES (:companyId, :shiftId, :driverId, :currentDate, :currentTime)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("currentDate", $currentDate);
        $stmt->bindParam("currentTime", $currentTime); 

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Insert failed.',
                    'error' => 'No reason'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Insert failed.',
                'error' => $stmt->errorInfo()
            ];
        }
    }

    public function checkDriverShiftByDate($driverId, $currentDate) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `shift_driver_id` FROM `bms_shift_driver` WHERE `driver_id` = :driverId AND `start_date` = :currentDate AND `is_active` = :isActive");
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("currentDate", $currentDate);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updateRoute($routeId, $route) {
        $stmt = $this->db->prepare("UPDATE `bms_routes` SET `route_name` = :route WHERE `id` = :routeId");
        $stmt->bindParam(":route", $route);
        $stmt->bindParam(":routeId", $routeId);

        return $stmt->execute() ? true : false;
    }

    public function getRoutes($companyId, $languageCode) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT r.id AS 'routeId', rt.route_name AS 'routeName' FROM bms_routes r
                                    INNER JOIN bms_route_translations rt ON rt.route_id = r.id
                                    INNER JOIN bms_languages l ON l.id = rt.language_id
                                    WHERE r.company_id = :companyId AND l.code = :languageCode AND r.is_active = :isActive
                                    ");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("languageCode", $languageCode);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getShiftIdByDriverId($driverId) {
        $workStatus = true;
        $isActive = true;
        $stmt = $this->db->prepare("SELECT shift_id AS 'shiftId' FROM `bms_shift_driver` WHERE `driver_id` = :driverId AND `work_status` = :workStatus AND `is_active` = :isActive");
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function createTrip($companyId, $shiftId, $startRoute, $endRoute, $startKm) {
        $stmt = $this->db->prepare("INSERT INTO `bms_trips`(`company_id`, `shift_id`, `start_route_id`, `end_route_id`, `start_km`) VALUES (:companyId, :shiftId, :startRoute, :endRoute, :startKm)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("startRoute", $startRoute);
        $stmt->bindParam("endRoute", $endRoute);
        $stmt->bindParam("startKm", $startKm);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'tripId' => $lastId
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Insert failed.',
                    'error' => 'No reason'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Insert failed.',
                'error' => $stmt->errorInfo()
            ];
        }
    }

    public function createTripDriver($companyId, $tripId, $driverId) {
        $stmt = $this->db->prepare("INSERT INTO `bms_trip_drivers`(`company_id`, `trip_id`, `driver_id`) VALUES (:companyId, :tripId, :driverId)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("driverId", $driverId);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Insert failed.',
                    'error' => 'No reason'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Insert failed.',
                'error' => $stmt->errorInfo()
            ];
        }
    }
}