<?php

class CommissionModel {
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

    public function setCommission($companyId, $rangeFrom, $rangeTo, $amountPerCommission, $commissionAmount) {
        $stmt = $this->db->prepare("INSERT INTO `bms_commission`(`company_id`, `collection_range_from`, `collection_range_to`, `amount_per_commission`, `commission_amount`) VALUES (:companyId, :rangeFrom, :rangeTo, :amountPerCommission, :commissionAmount)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("rangeFrom", $rangeFrom);
        $stmt->bindParam("rangeTo", $rangeTo);
        $stmt->bindParam("amountPerCommission", $amountPerCommission);
        $stmt->bindParam("commissionAmount", $commissionAmount);

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

    public function getCommission($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM `bms_commission` WHERE company_id = :companyId AND is_active = :isActive");
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

    function deleteBus($busId) {
        $stmt = $this->db->prepare("DELETE FROM `bms_bus` WHERE `id`=:busId");
        $stmt->bindParam("busId", $busId);
        return $stmt->execute();
    }
}