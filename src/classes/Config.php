<?php
namespace App;

class Config {
    private static $baseDir;
    private static $config = [];

    public static function initialize(string $baseDir) {
        self::$baseDir = rtrim($baseDir, '/') . '/';
        self::$config = [
            'dir' => [
                'app' => self::$baseDir,
                'classes' => self::$baseDir . 'classes/',
                'includes' => self::$baseDir . 'includes/',
                'manager' => self::$baseDir . 'manager/',
                'employee' => self::$baseDir . 'employee/',
                'assets' => self::$baseDir . 'assets/'
            ]
        ];

        self::loadEnvironment('config/config.ini');
    }

    public static function get(string $key, $default = null) {
        $keys = explode('.', $key);
        $value = self::$config;

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }

        return $value;
    }

    public static function loadEnvironment(string $envFile) {
        $envPath = self::path($envFile);
        if (file_exists($envPath)) {
            $env = parse_ini_file($envPath, true);
            self::$config = array_merge(self::$config, $env);
        }
    }

    public static function require(string $relativePath) {
        $absolutePath = self::$baseDir . ltrim($relativePath, '/');
        if (file_exists($absolutePath)) {
            return require $absolutePath;
        }
        throw new RuntimeException("File not found: {$absolutePath}");
    }

    public static function path(string $relativePath = '') {
        return self::$baseDir . ltrim($relativePath, '/');
    }
}
?>
