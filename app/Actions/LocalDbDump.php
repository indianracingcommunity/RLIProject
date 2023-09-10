<?php

namespace App\Actions;

use App\Actions\CleanupFolder;
use Ifsnop\Mysqldump as IMysqldump;
use App\Helpers\FilesystemHelpers as FH;

class LocalDbDump
{
    private $APP_ENV;
    private $localBackupFolder;
    private $databaseConfig;

    public function __construct()
    {
        $this->APP_ENV = config('app.env');
        $this->setLocalBackupFolder(storage_path('backups/'));
        FH::createDirIfNotExists($this->localBackupFolder);

        $dbConnectionDriver = config('database.default');
        $this->databaseConfig = config('database.connections.' . $dbConnectionDriver);
    }

    public function setLocalBackupFolder($fullFilePath)
    {
        if ($fullFilePath == '' || $fullFilePath == null)
            return;

        $this->localBackupFolder = FH::trailSlash($fullFilePath);
    }

    protected function cleanupFolder($folder)
    {
        return app()->make(CleanupFolder::class, ['fullFilePath' => $folder])->__invoke();
    }

    public function createDump()
    {
        // Avoid ':' in filenames
        $localBackupFilename = "{$this->APP_ENV}-backup_" . date('Y-m-d--H_i_s') . '.sql.gz';

        [
            $numFilesRemoved,
            $diskSpaceUsed
        ] = $this->cleanupFolder($this->localBackupFolder);

        $dump = new IMysqldump\Mysqldump(
            "mysql:host={$this->databaseConfig['host']};dbname={$this->databaseConfig['database']}",
            $this->databaseConfig['username'],
            $this->databaseConfig['password'],
            array('compress' => IMysqldump\Mysqldump::GZIP)
        );

        $dump->start($this->localBackupFolder . $localBackupFilename);

        return [
            $diskSpaceUsed,
            $numFilesRemoved,
            $this->localBackupFolder . $localBackupFilename
        ];
    }

    public function outputFromDump($diskSpaceUsed, $numFilesRemoved, $localBackupFilepath)
    {
        $commandOutput = "Disk space used: " . $diskSpaceUsed . "%\n";
        if ($numFilesRemoved)
            $commandOutput .= $numFilesRemoved . " oldest file(s) removed\n";

        $commandOutput .= "DB dumped locally successfully. Zipped file location in\n";
        $commandOutput .= $localBackupFilepath;

        return $commandOutput;
    }
}
