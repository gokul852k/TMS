<?php

class DailyReportModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getFuelType()
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `id`, `fuel` FROM cms_fuel_type WHERE is_active = :isActive");
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setCar($companyId, $carNumber, $driverName, $cabCompany, $date, $startKM, $startDate, $startTime, $endKM, $endDate, $endTime, $totalKM)
    {
        $stmt = $this->db->prepare("INSERT INTO `cms_drivers_daily_report` (`company_id`, `cab_company_id`, `car_id`, `driver_id`, 
        `check_in_date`, `check_in_time`, `check_in_km`, `check_out_date`, `check_out_time`, `check_out_km`, `total_km`, 
        `admin_entry_date`) VALUES (:companyId, :cabCompany, :carNumber, :driverName, :startDate, :startTime, :startKM,
         :endDate, :endTime, :endKM, :totalKM, :date)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("cabCompany", $cabCompany);
        $stmt->bindParam("carNumber", $carNumber);
        $stmt->bindParam("driverName", $driverName);
        $stmt->bindParam("startDate", $startDate);
        $stmt->bindParam("startTime", $startTime);
        $stmt->bindParam("startKM", $startKM);
        $stmt->bindParam("endDate", $endDate);
        $stmt->bindParam("endTime", $endTime);
        $stmt->bindParam("endKM", $endKM);
        $stmt->bindParam("totalKM", $totalKM);
        $stmt->bindParam("date", $date);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'carId' => $lastId
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

    public function setCarSummary($companyId, $carId)
    {
        $stmt = $this->db->prepare("INSERT INTO `cms_car_summary` (`company_id`, `car_id`) VALUES (:companyId, :carId)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("carId", $carId);

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

    public function getCarCardDetails($companyId)
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT
                                    (SELECT COUNT(*) FROM cms_car WHERE company_id=:companyId AND is_active=:isActive) AS 'total_car',
                                    (SELECT SUM(total_km) FROM cms_car_summary WHERE company_id=:companyId AND is_active=:isActive) AS 'total_km',
                                    (SELECT AVG(avg_mileage) FROM cms_car_summary WHERE company_id=:companyId AND is_active=:isActive) AS 'avg_mileage',
                                    (SELECT AVG(cost_per_km) FROM cms_car_summary WHERE company_id=:companyId AND is_active=:isActive) AS 'cost_per_km',
                                    (SELECT COUNT(*) FROM cms_drivers WHERE licence_expiry<CURRENT_DATE() AND company_id=:companyId AND is_active=:isActive) AS 'expired_licenses'
                                ");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDailyReports($companyId)
    {
        $stmt = $this->db->prepare("SELECT
                                            cddr.id AS 'daily_report_id',
                                            cd.fullname AS 'fullname',
                                            cddr.check_in_date,
                                            cddr.check_in_time,
                                            cddr.check_in_km,
                                            COALESCE(cddr.check_out_date, '-') AS check_out_date,
                                            COALESCE(cddr.check_out_time, '-') AS check_out_time,
                                            COALESCE(cddr.check_out_km, '-') AS check_out_km,
                                            COALESCE(cddr.total_km, '-') AS total_km
                                        FROM cms_drivers_daily_report cddr
                                        INNER JOIN cms_drivers cd ON cddr.driver_id = cd.id
                                        WHERE cddr.company_id = :companyId");

        $stmt->bindParam(":companyId", $companyId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getCar($carId)
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM cms_drivers_daily_report WHERE id=:carId AND is_active=:isActive");
        $stmt->bindParam(":carId", $carId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function updateCar($update_fields, $update_values)
    {
        $sql = "UPDATE cms_drivers_daily_report SET " . implode(", ", $update_fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute($update_values)) {
            return true;
        } else {
            return false;
        }
    }

    // function getCarView($carId)
    // {
    //     $isActive = true;
    //     $stmt = $this->db->prepare("SELECT 
    //                                 c.car_number,
    //                                 c.car_model,
    //                                 c.seating_capacity,
    //                                 ft.fuel AS 'fuel_type',
    //                                 c.rcbook_no,
    //                                 c.rcbook_expiry,
    //                                 c.rcbook_path,
    //                                 c.insurance_no,
    //                                 c.insurance_expiry,
    //                                 c.insurance_path,
    //                                 c.car_status,
    //                                 COALESCE(cs.total_km, 0) AS 'total_km',
    //                                 COALESCE(cs.avg_mileage, 0) AS 'avg_mileage',
    //                                 COALESCE(cs.cost_per_km, 0) AS 'cost_per_km',
    //                                 COALESCE(cs.fuel_cost, 0) AS 'fuel_cost',
    //                                 COALESCE(cs.maintenance_cost, 0) AS 'maintenance_cost'
    //                             FROM cms_car c
    //                             INNER JOIN cms_fuel_type ft ON c.fuel_type_id = ft.id
    //                             LEFT JOIN cms_car_summary cs ON c.id = cs.car_id
    //                             WHERE c.id=:carId AND c.is_active=:isActive");
    //     $stmt->bindParam(":carId", $carId);
    //     $stmt->bindParam(":isActive", $isActive);
    //     $stmt->execute();
    //     $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //     return $result ? $result : null;
    // }

    function getcarView($carId){
        $isActive = true;

        $stmt = $this->db->prepare("SELECT * FROM cms_drivers_daily_report cddr WHERE cddr.id=:carId AND cddr.is_active = :isActive");
        $stmt->bindParam(":carId", $carId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function deleteBus($busId)
    {
        $stmt = $this->db->prepare("DELETE FROM `bms_bus` WHERE `id`=:busId");
        $stmt->bindParam("busId", $busId);
        return $stmt->execute();
    }
}