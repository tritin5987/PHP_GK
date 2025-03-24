<?php
require_once 'DB.php';

class NganhHoc {
    public static function all() {
        global $conn;
        return $conn->query("SELECT * FROM NganhHoc");
    }
}
