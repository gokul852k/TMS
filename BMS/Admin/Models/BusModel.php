<?php

class BusModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getFuelType() {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `id`, `fuel` FROM bms_fuel_type WHERE is_active = :isActive");
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setBus($companyId, $busNumber, $busModel, $seatingCapacity, $fuelType, $busStatus, $rcBookNumber, $insuranceNumber, $rcBookExpiry, $insuranceExpiry, $rcBook_path, $insurance_path) {
        $stmt = $this->db->prepare("INSERT INTO `bms_bus` (`company_id`, `bus_number`, `seating_capacity`, `fuel_type_id`, `rcbook_no`, `rcbook_expiry`, `rcbook_path`, `insurance_no`, `insurance_expiry`, `insurance_path`, `bus_status`) VALUES (:companyId, :busNumber, :seatingCapacity, :fuelType, :rcBookNumber, :rcBookExpiry, :rcBook_path, :insuranceNumber, :insuranceExpiry, :insurance_path, :busStatus)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("busNumber", $busNumber);
        $stmt->bindParam("seatingCapacity", $seatingCapacity);
        $stmt->bindParam("fuelType", $fuelType);
        $stmt->bindParam("rcBookNumber", $rcBookNumber);
        $stmt->bindParam("rcBookExpiry", $rcBookExpiry);
        $stmt->bindParam("rcBook_path", $rcBook_path);
        $stmt->bindParam("insuranceNumber", $insuranceNumber);
        $stmt->bindParam("insuranceExpiry", $insuranceExpiry);
        $stmt->bindParam("insurance_path", $insurance_path);
        $stmt->bindParam("busStatus", $busStatus);

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

    public function setBusSummary($companyId, $busId) {
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

    public function getBusCardDetails($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT
                                    (SELECT COUNT(*) FROM bms_bus WHERE company_id=:companyId AND is_active=:isActive) AS 'total_bus',
                                    (SELECT SUM(total_km) FROM bms_bus_summary WHERE company_id=:companyId AND is_active=:isActive) AS 'total_km',
                                    (SELECT AVG(avg_mileage) FROM bms_bus_summary WHERE company_id=:companyId AND is_active=:isActive) AS 'avg_mileage',
                                    (SELECT AVG(cost_per_km) FROM bms_bus_summary WHERE company_id=:companyId AND is_active=:isActive) AS 'cost_per_km',
                                    (SELECT COUNT(*) FROM bms_drivers WHERE licence_expiry<CURRENT_DATE() AND company_id=:companyId AND is_active=:isActive) AS 'expired_licenses'
                                ");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getBuses($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT
                                        b.id AS 'bus_id',
                                        b.bus_number,
                                        ft.fuel AS 'fuel_type',
                                        COALESCE(bs.total_km, 0) AS 'total_km',
                                        COALESCE(bs.avg_mileage, 0) AS 'avg_mileage',
                                        COALESCE(bs.cost_per_km, 0) AS 'cost_per_km',
                                        CASE
                                            WHEN b.rcbook_expiry < CURRENT_DATE() THEN 'expired'
                                            WHEN b.rcbook_expiry < DATE_ADD(CURRENT_DATE(), INTERVAL 3 MONTH) THEN 'expires'
                                            ELSE 'active'
                                        END AS 'rc_book_status',
                                        CASE
                                            WHEN b.insurance_expiry < CURRENT_DATE() THEN 'expired'
                                            WHEN b.insurance_expiry < DATE_ADD(CURRENT_DATE(), INTERVAL 3 MONTH) THEN 'expires'
                                            ELSE 'active'
                                        END AS 'insurance_status'
                                    FROM bms_bus b
                                    INNER JOIN bms_fuel_type ft ON b.fuel_type_id = ft.id
                                    LEFT JOIN bms_bus_summary bs ON b.id = bs.bus_id
                                    WHERE b.company_id = :companyId AND b.is_active = :isActive");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getBus($busId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM bms_bus WHERE id=:busId AND is_active=:isActive");
        $stmt->bindParam(":busId", $busId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function updateBus($update_fields, $update_values) {
        $sql = "UPDATE bms_bus SET ". implode(", ", $update_fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute($update_values)) {
            return true;
        } else {
            return false;
        }
    }

    function getBusView($busId) {
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

    function deleteBus($busId) {
        $stmt = $this->db->prepare("DELETE FROM `bms_bus` WHERE `id`=:busId");
        $stmt->bindParam("busId", $busId);
        return $stmt->execute();
    }
}