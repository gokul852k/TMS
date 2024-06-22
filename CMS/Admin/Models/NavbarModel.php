<?php

class NavbarModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAdminNavbar($userId, $languageCode) {
        $isVisible = true;
        $stmt = $this->db->prepare("SELECT n.url, n.icon, t.label
                                    FROM cms_navbar_roles AS r
                                    INNER JOIN cms_navbar AS n ON r.navbar_id = n.id
                                    INNER JOIN cms_navbar_translations AS t ON n.id = t.navbar_id
                                    INNER JOIN cms_languages AS l ON l.id = t.language_id
                                    WHERE r.role_id = :userId AND l.code = :languageCode AND n.is_visible = :isVisible ORDER BY n.display_order ASC;"
                                    );
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":languageCode", $languageCode);
        $stmt->bindParam(":isVisible", $isVisible);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }
}