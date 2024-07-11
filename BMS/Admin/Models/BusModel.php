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