<?php

class CompanyModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getMailID($mail) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `company_email` FROM `cms_cab_company` WHERE company_email = :company_email AND is_active = :isActive");
        $stmt->bindParam(":company_email", $mail);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getCompanyDetailss($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM `cms_cab_company` WHERE `id` = :companyId AND `is_active` = :isActive");
        $stmt->bindParam(":companyId", $companyId);
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
    public function getCompanyDetails() {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT 
                                        id, company_name, district, state, company_email, gstnumber, company_phone
                                    FROM cms_cab_company 
                                    WHERE is_active = :isActive");
        // $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setCompany($company, $gstnum, $mobile, $email, $address, $state, $district, $pincode) {
        $stmt = $this->db->prepare("INSERT INTO `cms_cab_company`(`company_name`, `company_address`, `district`, `state`, `pincode`, `gstnumber`, `company_email`, `company_phone`) VALUES (:company, :address, :district, :state, :pincode, :gstnum, :email, :mobile)");
        
        $stmt->bindParam(":company", $company);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":district", $district);
        $stmt->bindParam(":state", $state);
        $stmt->bindParam(":pincode", $pincode);
        $stmt->bindParam(":gstnum", $gstnum);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":mobile", $mobile);

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

    public function setDriver($userId, $companyId, $name, $mobile, $subcompany, $mail, $address, $state, $district, $pincode, $driverImage_path, $licenceNo, $licenceExpiry, $drivingLicence_path, $aadharNo, $aadharCard_path, $panNo, $panCard_path) {
        $stmt = $this->db->prepare("INSERT INTO `cms_drivers` (`user_id`, `company_id`, `cab_company_id`, `fullname`, `mail`, `mobile`, `address`, `state`, `district`, `pincode`, `driver_image_path`, `licence_no`, `licence_expiry`, `licence_path`, `aadhar_no`, `aadhar_path`, `pan_no`, `pan_path`) VALUES (:userId, :companyId, :subcompany, :name, :mail, :mobile, :address, :state, :district, :pincode, :driverImage_path, :licenceNo, :licenceExpiry, :drivingLicence_path, :aadharNo, :aadharCard_path, :panNo, :panCard_path)");
        $stmt->bindParam("userId", $userId);
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("subcompany", $subcompany);
        $stmt->bindParam("name", $name);
        $stmt->bindParam("mail", $mail);
        $stmt->bindParam("mobile", $mobile);
        $stmt->bindParam("address", $address);
        $stmt->bindParam("state", $state);
        $stmt->bindParam("district", $district);
        $stmt->bindParam("pincode", $pincode);
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

    function updateCompany($update_fields, $update_values) {
        $sql = "UPDATE cms_cab_company SET ". implode(", ", $update_fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute($update_values)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteDriver($driverId) {
        $stmt = $this->db->prepare("DELETE FROM `cms_cab_company` WHERE `id`=:driverId");
        $stmt->bindParam("driverId", $driverId);
        return $stmt->execute();
    }
}

