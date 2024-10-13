<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class MaintenanceReportModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getFuelType()
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `id`, `fuel` FROM bms_fuel_type WHERE is_active = :isActive");
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setFuelReport($companyId, $busNumber, $date, $fuelLiters, $fuelAmount, $fuelbill_path)
    {
        $stmt = $this->db->prepare("INSERT INTO `bms_fuel_reports`(`company_id`, `bus_id`, `fuel_date`, `fuel_quantity`, `fuel_cost`, `fuel_bill_url`) VALUES (:companyId, :busNumber, :date, :fuelLiters, :fuelAmount, :fuelbill_path)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("busNumber", $busNumber);
        $stmt->bindParam("date", $date);
        $stmt->bindParam("fuelLiters", $fuelLiters);
        $stmt->bindParam("fuelAmount", $fuelAmount);
        $stmt->bindParam("fuelbill_path", $fuelbill_path);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'busId' => $lastId
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

    public function setBusSummary($companyId, $busId)
    {
        $stmt = $this->db->prepare("INSERT INTO `bms_bus_summary` (`company_id`, `bus_id`) VALUES (:companyId, :busId)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("busId", $busId);

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

    public function getFuelReportCardDetails($companyId)
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT  SUM(fuel_cost) AS 'totalAmount', SUM(fuel_quantity) AS 'totalLiters', COUNT(*) AS 'reFueled' FROM bms_fuel_reports WHERE company_id = :companyId AND is_active = :isActive");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getCars($companyId)
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `id`, `car_number` FROM `cms_car` WHERE `company_id` = :companyId AND `is_active` = :isActive");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getSpareParts($lanuageCode)
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM cms_spare_parts sp INNER JOIN cms_spare_parts_translations spt ON sp.id = spt.spare_part_id INNER JOIN cms_languages l ON spt.language_id = l.id WHERE l.code = :lanuageCode AND sp.is_active = :isActive");
        $stmt->bindParam("lanuageCode", $lanuageCode);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setMaintenanceReport($companyId, $cabcompany, $carId, $driverId, $date, $serviceCharge, $totalCharges, $maintenanceBillPath)
    {
        $stmt = $this->db->prepare("INSERT INTO `cms_maintenance_report` (`company_id`, `cab_company_id`, `car_id`, `driver_id`, `maintenance_date`, `service_charge`, `total_charge`, `maintenance_bill_url`) VALUES (:companyId, :cabCompanyID, :carId, :driverId, :maintenanceDate, :serviceCharge, :totalCharge, :maintenanceBillUrl)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("cabCompanyID", $cabcompany);
        $stmt->bindParam("carId", $carId);
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("maintenanceDate", $date);
        $stmt->bindParam("serviceCharge", $serviceCharge);
        $stmt->bindParam("totalCharge", $totalCharges);
        $stmt->bindParam("maintenanceBillUrl", $maintenanceBillPath);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                // Get the last inserted ID
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'maintenanceId' => $lastId
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

    public function getMaintenanceCardDetails($companyId)
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT
                                    (SELECT SUM(total_charge) FROM cms_maintenance_report WHERE company_id=:companyId AND is_active=:isActive) AS 'total_charge',
                                    (SELECT COUNT(maintenance_report_id) FROM cms_maintenance_report WHERE company_id=:companyId AND is_active=:isActive) AS 'total_services',
                                    (SELECT ROUND(AVG(service_charge), 0) FROM cms_maintenance_report WHERE company_id=:companyId AND is_active=:isActive) AS 'avg_service_charge'
                                    ");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getMaintenanceDetails($companyId)
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT
                                            cmr.maintenance_report_id,
                                            cc.car_number AS car_number,
                                            cd.fullname AS fullname,
                                            cmr.maintenance_date,
                                            cmr.total_charge
                                        FROM cms_maintenance_report cmr
                                        INNER JOIN cms_drivers cd ON cmr.driver_id = cd.id
                                        INNER JOIN cms_car cc ON cmr.car_id = cc.id
                                        WHERE
                                            cmr.company_id = :companyId AND cmr.is_active = :isActive;
                                        ");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setSpareDetails($companyId, $cabcompany, $maintenanceId, $spareID, $spareQuantity, $sparePrice)
    {

        $stmt = $this->db->prepare("INSERT INTO `cms_maintenance_report_sub` (`company_id`, `cab_company_id`, `maintenance_id`,
             `spare_parts`, `spare_parts_quantity`, `spare_part_cost`) VALUES (:companyId, :cabCompanyId, :maintenanceId,
              :sparePartId, :sparePartQuantity, :sparePartPrice)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("cabCompanyId", $cabcompany);
        $stmt->bindParam("maintenanceId", $maintenanceId);
        $stmt->bindParam("sparePartId", $spareID);
        $stmt->bindParam("sparePartQuantity", $spareQuantity);
        $stmt->bindParam("sparePartPrice", $sparePrice);

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

    public function getDriverName()
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT id, fullName FROM cms_drivers WHERE is_active = :isActive");
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getFuelReports($companyId)
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT FR.fuel_report_id AS 'fuelReportId',
                                    b.bus_number AS 'busNumber',
                                    DATE_FORMAT(fr.fuel_date, '%d-%m-%Y') AS 'date',
                                    ft.fuel AS 'fuelType',
                                    fr.fuel_quantity AS 'liters',
                                    fr.fuel_cost AS 'amount',
                                    fr.fuel_bill_url AS 'bill'
                                    FROM bms_fuel_reports fr
                                    INNER JOIN bms_bus b ON fr.bus_id = b.id
                                    INNER JOIN bms_fuel_type ft ON b.fuel_type_id = ft.id
                                    WHERE fr.company_id = :companyId AND fr.is_active = :isActive");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getFuelReport($reportId)
    {
        $stmt = $this->db->prepare("SELECT FR.fuel_report_id AS 'fuelReportId',
                                    fr.bus_id AS 'busId',
                                    fr.fuel_date AS 'date',
                                    fr.fuel_quantity AS 'liters',
                                    fr.fuel_cost AS 'amount',
                                    fr.fuel_bill_url AS 'bill'
                                    FROM bms_fuel_reports fr
                                    WHERE fr.fuel_report_id = :reportId");
        $stmt->bindParam(":reportId", $reportId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getFuelReport2($reportId)
    {
        $stmt = $this->db->prepare("SELECT *
                                    FROM bms_fuel_reports
                                    WHERE fuel_report_id = :reportId");
        $stmt->bindParam(":reportId", $reportId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function updateFuelReport($update_fields, $update_values)
    {
        $sql = "UPDATE bms_fuel_reports SET " . implode(", ", $update_fields) . " WHERE fuel_report_id = :fuel_report_id";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute($update_values)) {
            return true;
        } else {
            return false;
        }
    }

    function getBusView($busId)
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT 
                                    b.bus_number,
                                    b.bus_model,
                                    b.seating_capacity,
                                    ft.fuel AS 'fuel_type',
                                    b.rcbook_no,
                                    b.rcbook_expiry,
                                    b.rcbook_path,
                                    b.insurance_no,
                                    b.insurance_expiry,
                                    b.insurance_path,
                                    b.driver_salary,
                                    b.conductor_salary,
                                    b.bus_status,
                                    COALESCE(bs.total_km, 0) AS 'total_km',
                                    COALESCE(bs.avg_mileage, 0) AS 'avg_mileage',
                                    COALESCE(bs.cost_per_km, 0) AS 'cost_per_km',
                                    COALESCE(bs.fuel_cost, 0) AS 'fuel_cost',
                                    COALESCE(bs.maintenance_cost, 0) AS 'maintenance_cost'
                                FROM bms_bus b
                                INNER JOIN bms_fuel_type ft ON b.fuel_type_id = ft.id
                                LEFT JOIN bms_bus_summary bs ON b.id = bs.bus_id
                                WHERE b.id=:busId AND b.is_active=:isActive");
        $stmt->bindParam(":busId", $busId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function deleteFuelReport($reportId)
    {
        $isActive = false;
        $stmt = $this->db->prepare("UPDATE `bms_fuel_reports` SET `is_active` = :isActive WHERE `fuel_report_id` = :reportId");
        $stmt->bindParam(":isActive", $isActive);
        $stmt->bindParam(":reportId", $reportId);

        return $stmt->execute() ? true : false;
    }

    function getFilterCardCount($filters, $companyId)
    {
        $isActive = true;
        $sql = "SELECT  SUM(fr.fuel_cost) AS 'totalAmount', SUM(fr.fuel_quantity) AS 'totalLiters', COUNT(*) AS 'reFueled'
                FROM bms_fuel_reports fr
                INNER JOIN bms_bus b ON fr.bus_id = b.id
                WHERE 1=1 ";
        //company_id = :companyId AND is_active = :isActive
        $params = [];

        if (!empty($filters['fromDate'])) {
            $sql .= "AND fr.fuel_date >= :fromDate ";
            $params[':fromDate'] = $filters['fromDate'];
        }

        if (!empty($filters['toDate'])) {
            $sql .= "AND fr.fuel_date <= :toDate ";
            $params[':toDate'] = $filters['toDate'];
        }

        if (!empty($filters['bus'])) {
            $sql .= "AND fr.bus_id = :bus ";
            $params[':bus'] = $filters['bus'];
        }

        if (!empty($filters['fuelType'])) {
            $sql .= "AND b.fuel_type_id = :fuelType ";
            $params[':fuelType'] = $filters['fuelType'];
        }

        if (!empty($filters['costFrom'])) {
            $sql .= "AND fr.fuel_cost >= :costFrom ";
            $params[':costFrom'] = $filters['costFrom'];
        }

        if (!empty($filters['costTo'])) {
            $sql .= "AND fr.fuel_cost <= :costTo ";
            $params[':costTo'] = $filters['costTo'];
        }

        $sql .= "AND fr.company_id = :companyId ";
        $params[':companyId'] = $companyId;

        $sql .= "AND fr.is_active = :isActive";
        $params[':isActive'] = $isActive;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getFilterFuelReport($filters, $companyId)
    {
        $isActive = true;
        $sql = "SELECT fr.fuel_report_id AS 'fuelReportId',
                b.bus_number AS 'busNumber',
                DATE_FORMAT(fr.fuel_date, '%d-%m-%Y') AS 'date',
                ft.fuel AS 'fuelType',
                fr.fuel_quantity AS 'liters',
                fr.fuel_cost AS 'amount',
                fr.fuel_bill_url AS 'bill'
                FROM bms_fuel_reports fr
                INNER JOIN bms_bus b ON fr.bus_id = b.id
                INNER JOIN bms_fuel_type ft ON b.fuel_type_id = ft.id
                WHERE 1=1 ";
        //company_id = :companyId AND is_active = :isActive
        $params = [];

        if (!empty($filters['fromDate'])) {
            $sql .= "AND fr.fuel_date >= :fromDate ";
            $params[':fromDate'] = $filters['fromDate'];
        }

        if (!empty($filters['toDate'])) {
            $sql .= "AND fr.fuel_date <= :toDate ";
            $params[':toDate'] = $filters['toDate'];
        }

        if (!empty($filters['bus'])) {
            $sql .= "AND fr.bus_id = :bus ";
            $params[':bus'] = $filters['bus'];
        }

        if (!empty($filters['fuelType'])) {
            $sql .= "AND b.fuel_type_id = :fuelType ";
            $params[':fuelType'] = $filters['fuelType'];
        }

        if (!empty($filters['costFrom'])) {
            $sql .= "AND fr.fuel_cost >= :costFrom ";
            $params[':costFrom'] = $filters['costFrom'];
        }

        if (!empty($filters['costTo'])) {
            $sql .= "AND fr.fuel_cost <= :costTo ";
            $params[':costTo'] = $filters['costTo'];
        }

        $sql .= "AND fr.company_id = :companyId ";
        $params[':companyId'] = $companyId;

        $sql .= "AND fr.is_active = :isActive";
        $params[':isActive'] = $isActive;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getFilterChart($filters, $companyId)
    {
        $isActive = true;
        $sql = "SELECT fr.fuel_date AS 'date',
                fr.fuel_cost AS 'value'
                FROM bms_fuel_reports fr
                INNER JOIN bms_bus b ON fr.bus_id = b.id
                WHERE 1=1 ";
        //company_id = :companyId AND is_active = :isActive
        $params = [];

        if (!empty($filters['fromDate'])) {
            $sql .= "AND fr.fuel_date >= :fromDate ";
            $params[':fromDate'] = $filters['fromDate'];
        }

        if (!empty($filters['toDate'])) {
            $sql .= "AND fr.fuel_date <= :toDate ";
            $params[':toDate'] = $filters['toDate'];
        }

        if (!empty($filters['bus'])) {
            $sql .= "AND fr.bus_id = :bus ";
            $params[':bus'] = $filters['bus'];
        }

        if (!empty($filters['fuelType'])) {
            $sql .= "AND b.fuel_type_id = :fuelType ";
            $params[':fuelType'] = $filters['fuelType'];
        }

        if (!empty($filters['costFrom'])) {
            $sql .= "AND fr.fuel_cost >= :costFrom ";
            $params[':costFrom'] = $filters['costFrom'];
        }

        if (!empty($filters['costTo'])) {
            $sql .= "AND fr.fuel_cost <= :costTo ";
            $params[':costTo'] = $filters['costTo'];
        }

        $sql .= "AND fr.company_id = :companyId ";
        $params[':companyId'] = $companyId;

        $sql .= "AND fr.is_active = :isActive";
        $params[':isActive'] = $isActive;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getCompany()
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `id`, `company_name` FROM cms_cab_company WHERE is_active = :isActive");
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getMaintenanceReport1($maintenanceReportId)
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT
                                        cmr.maintenance_report_id,
                                        cmr.company_id,
                                        ccc.company_name,
                                        ccc.id AS cabcompanyId,
                                        cc.car_number,
                                        cc.id AS carId,
                                        cd.fullname,
                                        cd.id AS driverId,
                                        cmr.maintenance_date,
                                        cmr.service_charge,
                                        cmr.total_charge,
                                        cmr.maintenance_bill_url
                                    FROM
                                        cms_maintenance_report cmr
                                    INNER JOIN cms_car cc ON
                                        cc.id = cmr.car_id
                                    INNER JOIN cms_drivers cd ON
                                        cd.id = cmr.driver_id
                                    INNER JOIN cms_cab_company ccc ON
                                        ccc.id = cmr.cab_company_id
                                    WHERE cmr.maintenance_report_id = :maintenanceReportId AND cmr.is_active = :isActive");
        $stmt->bindParam("maintenanceReportId", $maintenanceReportId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;

    }

    public function getMaintenanceReport2($maintenanceReportId) {
        $isActive = true;
        // $stmt = $this->db->prepare("SELECT `shift_id`, `company_id`, `report_id`, `shift_name_id`, `start_date`, `start_time`, `end_date`, `end_time`, `total_km`, `avg_milage`, `total_passenger`, `total_collection`, `salary`, `commission`, `expence`, `fuel_usage`, `fuel_amount` FROM `bms_shifts` WHERE `report_id` = :maintenanceReportId AND `is_active` = :isActive");
        $stmt = $this->db->prepare("SELECT 
                                        cmrs.maintenance_id,
                                        cmrs.spare_part_id,
                                        cmrs.spare_parts,
                                        csp.spare_parts AS spare_name,
                                        cmrs.spare_parts_quantity,
                                        cmrs.spare_part_cost
                                    FROM
                                        cms_maintenance_report_sub cmrs
                                    INNER JOIN cms_spare_parts csp ON
                                        csp.id = cmrs.spare_parts
                                    WHERE cmrs.maintenance_id = :maintenanceReportId AND cmrs.is_active = :isActive");
        $stmt->bindParam("maintenanceReportId", $maintenanceReportId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function deleteShift($shiftId) {
        $isActive = false;
        $stmt = $this->db->prepare("UPDATE `cms_maintenance_report_sub` SET `is_active` = :isActive WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":shiftId", $shiftId);
        $stmt->bindParam(":isActive", $isActive);

        return $stmt->execute() ? true : false;
    }

    public function setShift($companyId, $reportId, $shiftNameId, $shiftStartDate, $shiftEndDate, $shiftStartTime, $shiftEndTime) {

        $stmt = $this->db->prepare("INSERT INTO `bms_shifts` (`company_id`, `report_id`, `shift_name_id`, `start_date`, `start_time`, `end_date`, `end_time`) VALUES (:companyId, :reportId, :shiftNameId, :shiftStartDate, :shiftStartTime, :shiftEndDate, :shiftEndTime)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("reportId", $reportId);
        $stmt->bindParam("shiftNameId", $shiftNameId);
        $stmt->bindParam("shiftStartDate", $shiftStartDate);
        $stmt->bindParam("shiftEndDate", $shiftEndDate);
        $stmt->bindParam("shiftStartTime", $shiftStartTime);
        $stmt->bindParam("shiftEndTime", $shiftEndTime);

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

    function updateShift2($sparePartID, $companyId, $cabcompany, $maintenanceReportId, $spareID, $spareQuantity, $sparePrice) {
        $stmt = $this->db->prepare("UPDATE `cms_maintenance_report_sub` SET `spare_parts` = :spareID, `spare_parts_quantity` = :spareQuantity, `spare_part_cost` = :sparePrice WHERE `spare_part_id` = :sparePartID");
        
        $stmt->bindParam(":spareID", $spareID);
        $stmt->bindParam(":spareQuantity", $spareQuantity);
        $stmt->bindParam(":sparePrice", $sparePrice);
        $stmt->bindParam(":sparePartID", $sparePartID);

        return $stmt->execute() ? true : false;
    }

    public function updateDailyReport($maintenanceReportId, $companyId, $cabcompany, $carId, $driverId, $date, $serviceCharge, $totalCharges, $maintenanceBill_path) {
        $stmt = $this->db->prepare("UPDATE `cms_maintenance_report` SET `car_id` = :carId, `driver_id` = :driverId, `maintenance_date` = :date, `service_charge` = :serviceCharge, `total_charge` = :totalCharges, `maintenance_bill_url` = :maintenanceBill_path WHERE `maintenance_report_id` = :maintenanceReportId");
        $stmt->bindParam(":carId", $carId);
        $stmt->bindParam(":driverId", $driverId);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":serviceCharge", $serviceCharge);
        $stmt->bindParam(":totalCharges", $totalCharges);
        $stmt->bindParam(":maintenanceBill_path", $maintenanceBill_path);
        $stmt->bindParam(":maintenanceReportId", $maintenanceReportId);

        return $stmt->execute() ? true : false;
    }

    function getMaintenance($maintenanceReportId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM cms_maintenance_report WHERE maintenance_report_id = :maintenanceReportId AND is_active=:isActive");
        $stmt->bindParam(":maintenanceReportId", $maintenanceReportId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function deleteMaintenanceReport($maintenanceReportId) {
        $isActive = false;
        $stmt = $this->db->prepare("UPDATE `cms_maintenance_report` SET `is_active` = :isActive WHERE `maintenance_report_id`=:maintenanceReportId");
        $stmt->bindParam("maintenanceReportId", $maintenanceReportId);
        $stmt->bindParam(":isActive", $isActive);
        // $stmt->execute();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // return $result;
        return $stmt->execute() ? true : false;
    }

}