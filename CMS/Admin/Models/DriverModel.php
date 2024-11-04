<?php

class DriverModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getMailID($mail) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `username` FROM `users` WHERE username = :username AND is_active = :isActive");
        $stmt->bindParam(":username", $mail);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDriverDetails($driverId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT *,
                                             (SELECT `company_name` FROM `cms_cab_company` WHERE `cms_cab_company`.`id`=`cms_drivers`.`cab_company_id`) AS cab_company_id
                                             FROM `cms_drivers` WHERE `id` = :driverId AND `is_active` = :isActive");
        $stmt->bindParam(":driverId", $driverId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDriversCardDetails($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT
                                    (SELECT COUNT(*) FROM cms_drivers WHERE company_id=:companyId AND is_active=:isActive) AS 'total_drivers',
                                    (SELECT COUNT(*) FROM cms_drivers WHERE company_id=:companyId AND is_active=:isActive) AS 'active_drivers',
                                    (SELECT COUNT(*) FROM cms_drivers WHERE licence_expiry<CURRENT_DATE() AND company_id=:companyId AND is_active=:isActive) AS 'expired_licenses',
                                    (SELECT COUNT(*) FROM cms_drivers WHERE licence_expiry<DATE_ADD(CURDATE(), INTERVAL 3 MONTH) AND licence_expiry>CURRENT_DATE() AND company_id=:companyId AND is_active=:isActive) AS 'upcoming_expirations'
                                    ");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }
    
    public function getDriversDetails($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT 
                                        id, fullname, mail, mobile, district, licence_no, licence_expiry,
                                        CASE
                                            WHEN licence_expiry < CURRENT_DATE() THEN 'expired'
                                            WHEN licence_expiry < DATE_ADD(CURRENT_DATE(), INTERVAL 3 MONTH) THEN 'expires'
                                            ELSE 'active'
                                    END AS 'license_status'
                                    FROM cms_drivers 
                                    WHERE company_id=:companyId AND is_active = :isActive");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setDriversinUsers($username, $password, $companyId) {
        $stmt = $this->db->prepare("INSERT INTO `users`(`username`, `password`, `company_id`) VALUES (:username, :password, :companyId)");
        $stmt->bindParam("username", $username);
        $stmt->bindParam("password", $password);
        $stmt->bindParam("companyId", $companyId);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                // Get the last inserted ID
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'userId' => $lastId
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

    public function setDriversinUserRole($userId, $roleId, $systemId) {
        $stmt = $this->db->prepare("INSERT INTO `user_roles`(`user_id`, `role_id`, `system_id`) VALUES (:userId, :roleId, :systemId)");
        $stmt->bindParam("userId", $userId);
        $stmt->bindParam("roleId", $roleId);
        $stmt->bindParam("systemId", $systemId);

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

    public function setDriver($userId, $companyId, $name, $mobile, $subcompany, $mail, $carId, $address, $state, $district, $pincode, $language, $driverImage_path, $licenceNo, $licenceExpiry, $drivingLicence_path, $aadharNo, $aadharCard_path, $panNo, $panCard_path) {
        $stmt = $this->db->prepare("INSERT INTO `cms_drivers` (`user_id`, `company_id`, `car_id`, `cab_company_id`, `fullname`, `mail`, `mobile`, `address`, `state`, `district`, `pincode`, `language`, `driver_image_path`, `licence_no`, `licence_expiry`, `licence_path`, `aadhar_no`, `aadhar_path`, `pan_no`, `pan_path`) VALUES (:userId, :companyId, :carId, :subcompany, :name, :mail, :mobile, :address, :state, :district, :pincode, :language, :driverImage_path, :licenceNo, :licenceExpiry, :drivingLicence_path, :aadharNo, :aadharCard_path, :panNo, :panCard_path)");
        $stmt->bindParam("userId", $userId);
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("carId", $carId);
        $stmt->bindParam("subcompany", $subcompany);
        $stmt->bindParam("name", $name);
        $stmt->bindParam("mail", $mail);
        $stmt->bindParam("mobile", $mobile);
        $stmt->bindParam("address", $address);
        $stmt->bindParam("state", $state);
        $stmt->bindParam("district", $district);
        $stmt->bindParam("pincode", $pincode);
        $stmt->bindParam("language", $language);
        $stmt->bindParam("driverImage_path", $driverImage_path);
        $stmt->bindParam("licenceNo", $licenceNo);
        $stmt->bindParam("licenceExpiry", $licenceExpiry);
        $stmt->bindParam("drivingLicence_path", $drivingLicence_path);
        $stmt->bindParam("aadharNo", $aadharNo);
        $stmt->bindParam("aadharCard_path", $aadharCard_path);
        $stmt->bindParam("panNo", $panNo);
        $stmt->bindParam("panCard_path", $panCard_path);

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

    function deleteUser($userId) {
        $stmt = $this->db->prepare("DELETE FROM `users` WHERE `id`=:userId");
        $stmt->bindParam("userId", $userId);
        return $stmt->execute();
    }

    function updateDriver($update_fields, $update_values) {
        $sql = "UPDATE cms_drivers SET ". implode(", ", $update_fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute($update_values)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteDriver($driverId) {
        $stmt = $this->db->prepare("DELETE FROM `cms_drivers` WHERE `id`=:driverId");
        $stmt->bindParam("driverId", $driverId);
        return $stmt->execute();
    }

    public function getCompany($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `id`, `company_name` FROM cms_cab_company WHERE company_id=:companyId AND is_active = :isActive");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getLanguage($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT l.code, l.name FROM cms_company_languages cl
                                    INNER JOIN cms_languages l ON cl.language_id = l.id
                                    WHERE cl.company_id = :companyId AND cl.is_active = :isActive");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

}

