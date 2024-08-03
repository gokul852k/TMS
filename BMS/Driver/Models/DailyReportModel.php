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
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                    'Id' => $lastId
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


    public function updateRoute($routeId, $route) {
        $stmt = $this->db->prepare("UPDATE `bms_routes` SET `route_name` = :route WHERE `id` = :routeId");
        $stmt->bindParam(":route", $route);
        $stmt->bindParam(":routeId", $routeId);

        return $stmt->execute() ? true : false;
    }

}