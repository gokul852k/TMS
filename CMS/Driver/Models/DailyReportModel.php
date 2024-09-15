<?php

class DailyReportModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getMailID($mail)
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `username` FROM `users` WHERE username = :username AND is_active = :isActive");
        $stmt->bindParam(":username", $mail);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDriverDetails($driverId)
    {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM `cms_drivers` WHERE `id` = :driverId AND `is_active` = :isActive");
        $stmt->bindParam(":driverId", $driverId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDriversCardDetails($companyId)
    {
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
    public function getDriversDetails($companyId)
    {
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

    public function setDriversinUsers($username, $password, $companyId)
    {
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

    public function setDriversinUserRole($userId, $roleId, $systemId)
    {
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

    public function startTrip($companyId, $cabCompanyId, $driverId, $currentDate, $currentTime, $checkin_km)
    {
        $stmt = $this->db->prepare("INSERT INTO `cms_drivers_daily_report` (`company_id`, `cab_company_id`, `driver_id`, `check_in_date`, `check_in_time`, `check_in_km`) VALUES (:companyId, :cabCompanyId, :driverId, :currentDate, :currentTime, :checkin_km)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("cabCompanyId", $cabCompanyId);
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("currentDate", $currentDate);
        $stmt->bindParam("currentTime", $currentTime);
        $stmt->bindParam("checkin_km", $checkin_km);

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

    // public function endTrip($companyId, $cabCompanyId, $driverId, $currentDate, $currentTime, $checkin_km, $total_km)
    // {
    //     // $stmt = $this->db->prepare("INSERT INTO `cms_drivers_daily_report` (`company_id`, `cab_company_id`, `driver_id`, `check_in_date`, `check_in_time`, `check_in_km`) VALUES (:companyId, :cabCompanyId, :driverId, :currentDate, :currentTime, :checkin_km)");
    //     $stmt = $this->db->prepare("UPDATE `cms_drivers_daily_report` SET `check_out_date`=:checkOutDate,`check_out_time`=:currentTime,`check_out_km`=:checkOutKm,`total_km`=:totalKM WHERE `company_id` = :companId AND `sub_company_id` = :subCompanyId AND `driver_id` = :driverId AND `check_in_date` IS NOT NULL AND `check_out_date` IS NULL AND `check_out_time` IS NULL AND `check_out_km` IS NULL ORDER BY `daily_report_id` DESC LIMIT 1");
    //     $stmt->bindParam("companyId", $companyId);
    //     $stmt->bindParam("cabCompanyId", $cabCompanyId);
    //     $stmt->bindParam("driverId", $driverId);
    //     $stmt->bindParam("currentDate", $currentDate);
    //     $stmt->bindParam("currentTime", $currentTime);
    //     $stmt->bindParam("checkin_km", $checkin_km);
    //     $stmt->bindParam("total_km", $total_km);

    //     print_r($stmt);
    //     if ($stmt->execute()) {
    //         if ($stmt->rowCount() > 0) {
    //             return [
    //                 'status' => 'success',
    //                 'message' => 'Inserted successfully.'
    //             ];
    //         } else {
    //             return [
    //                 'status' => 'error',
    //                 'message' => 'Insert failed.',
    //                 'error' => 'No reason'
    //             ];
    //         }
    //     } else {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Insert failed.',
    //             'error' => $stmt->errorInfo()
    //         ];
    //     }
    // }

    public function endTrip($companyId, $cabCompanyId, $driverId, $checkOutDate, $currentTime, $checkOutKm, $totalKM)
    {
        // Prepare the SQL statement
        $stmt = $this->db->prepare("UPDATE `cms_drivers_daily_report` 
        SET `check_out_date` = :checkOutDate,
            `check_out_time` = :currentTime,
            `check_out_km` = :checkOutKm,
            `total_km` = :totalKM
        WHERE `company_id` = :companyId
          AND `cab_company_id` = :cabCompanyId
          AND `driver_id` = :driverId
          AND `check_in_date` IS NOT NULL
          AND `check_out_date` IS NULL
          AND `check_out_time` IS NULL
          AND `check_out_km` IS NULL
        ORDER BY `id` DESC
        LIMIT 1");

        // Bind the parameters
        $stmt->bindParam(':companyId', $companyId);
        $stmt->bindParam(':cabCompanyId', $cabCompanyId);
        $stmt->bindParam(':driverId', $driverId);
        $stmt->bindParam(':checkOutDate', $checkOutDate);
        $stmt->bindParam(':currentTime', $currentTime);
        $stmt->bindParam(':checkOutKm', $checkOutKm);
        $stmt->bindParam(':totalKM', $totalKM);

        // Execute the statement and handle errors
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


    public function checkDutyByDriverId($companyId, $cabCompanyId, $driverId)
    {
        $stmt = $this->db->prepare("SELECT id, check_in_km FROM `cms_drivers_daily_report` WHERE `company_id` = :companyId AND `cab_company_id` = :cabCompanyId AND `driver_id` = :driverId AND `check_in_time` IS NOT NULL AND `check_out_date` IS NULL AND `check_out_time` IS NULL AND `check_out_km` IS NULL ORDER BY `id` DESC LIMIT 1");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("cabCompanyId", $cabCompanyId);
        $stmt->bindParam("driverId", $driverId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function deleteUser($userId)
    {
        $stmt = $this->db->prepare("DELETE FROM `users` WHERE `id`=:userId");
        $stmt->bindParam("userId", $userId);
        return $stmt->execute();
    }

    function updateDriver($update_fields, $update_values)
    {
        $sql = "UPDATE cms_drivers SET " . implode(", ", $update_fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute($update_values)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteDriver($driverId)
    {
        $stmt = $this->db->prepare("DELETE FROM `cms_drivers` WHERE `id`=:driverId");
        $stmt->bindParam("driverId", $driverId);
        return $stmt->execute();
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

}

