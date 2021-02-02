<?php

namespace AddDate\Util\Installer;

/**
 * 
 */
class InstallFiles {

    /**
     *
     * @var array
     */
    private static $FileList = [];

    /**
     * 
     */
    static function init() {
        self::addFile(\AddDate\Util\Installer\InstallFilesArea::TABLES, \AddDate\Util\Functions::parseDir(array(__DIR__, "..", "..", "..", "..", "sql", "Tables.sql")));
    }

    /**
     * 
     * @param string $area
     * @return array
     */
    public static function getArea($area) {
        if (array_key_exists($area, self::$FileList)) {
            return self::$FileList[$area];
        }
        return [];
    }

    /**
     * 
     * @return int
     */
    public static function getAreasCount() {
        return count(self::getFileArray());
    }

    /**
     * 
     * @return int
     */
    public static function getAreaCount($area) {
        return count(self::getArea($area));
    }

    /**
     * 
     * @param string $area
     * @param string $file
     */
    private static function addFile($area, $file) {
        self::$FileList[$area][] = $file;
    }

    /**
     * 
     * @return array
     */
    public static function getFileArray() {
        return self::$FileList;
    }

}

InstallFiles::init();
