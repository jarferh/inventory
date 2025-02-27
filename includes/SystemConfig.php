<?php
class SystemConfig {
    private static function getCurrentTime() {
        return date('Y-m-d H:i:s');
    }

    private static function getCurrentUser() {
        return $_SESSION['username'] ?? "musty131311";
    }

    public static function getSystemValues() {
        return [
            'CURRENT_TIME' => self::getCurrentTime(),
            'CURRENT_USER' => self::getCurrentUser()
        ];
    }
}