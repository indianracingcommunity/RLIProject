<?php

namespace App\Helpers;

class FilesystemHelpers
{
    public function __construct()
    {
    }

    public static function deleteDir(string $dir)
    {
        $dir = FilesystemHelpers::noTrailSlash($dir);
        if (!file_exists($dir))
            return true;

        if (!is_dir($dir))
            return unlink($dir);

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..')
                continue;

            if (!FilesystemHelpers::deleteDir($dir . DIRECTORY_SEPARATOR . $item))
                return false;
        }

        return rmdir($dir);
    }

    public static function createDirIfNotExists(string $folder)
    {
        if (!file_exists($folder))
            return mkdir($folder, 0755, true);

        return true;
    }

    public static function trailSlash(string $folder = '')
    {
        $folder .= substr($folder, -1) == DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR;
        return $folder;
    }

    public static function noTrailSlash(string $folder = '')
    {
        $folder = substr($folder, -1) == DIRECTORY_SEPARATOR ? substr($folder, 0, -1) : $folder;
        return $folder;
    }
}
