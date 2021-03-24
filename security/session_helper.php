<?php

// this file require header.php
class Session_Helper {

    public static function isLogged() {
        return (isset($_SESSION['COD']) && intval($_SESSION['COD']) > 0);
    }

    public static function isTutor() {
        return ($_SESSION['TYPE'] == 'TUTOR');
    }

    public static function isStudent() {
        return !self::isTutor();
    }

    public static function getUserCode() {
        $_userCode = intval($_SESSION['COD']);
        return ($_userCode > 0) ? $_userCode : -1;
    }

    public static function getTutorLevel() {
        $_tutorLevel = intval($_SESSION['TUTORLEVEL']);
        return $_tutorLevel;
    }

    public static function getSchoolType() {
        $_schoolType = -1;
        if (isset($_SESSION['SCHOOLTYPE'])) {
            $_schoolType = $_SESSION['SCHOOLTYPE'];
        }
        return $_schoolType;
    }

}
