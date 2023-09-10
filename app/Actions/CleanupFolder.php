<?php

namespace App\Actions;

use App\Helpers\FilesystemHelpers as FH;

class CleanupFolder
{
    private string $fullFilePath;
    private float $thresholdDiskPercentage;

    // Full file path should include a trailing /
    public function __construct(string $fullFilePath, float $thresholdDiskPercentage = 75)
    {
        $this->fullFilePath = FH::trailSlash($fullFilePath);
        $this->thresholdDiskPercentage = $thresholdDiskPercentage;
    }

    protected function diskFreeSpace($drive)
    {
        return disk_free_space($drive);
    }
    protected function diskTotalSpace($drive)
    {
        return disk_total_space($drive);
    }

    public function __invoke()
    {
        $availableSpace = $this->diskFreeSpace($this->fullFilePath);
        $totalSpace = $this->diskTotalSpace($this->fullFilePath);
        $percentageUsed = (float) ($totalSpace - $availableSpace) / $totalSpace * 100.0;

        if ($percentageUsed < $this->thresholdDiskPercentage)
            return array(0, $percentageUsed);

        $files = array_filter(glob($this->fullFilePath . '*'), 'is_file');

        // Sort files by last modified date in ascending order
        usort($files, function ($x, $y) {
            return (int)(filemtime($x) > filemtime($y));
        });

        $newAvailableSpace = $availableSpace;
        $newPercentageUsed = $percentageUsed;
        $itemsRemoved = 0;
        for (; $itemsRemoved < count($files);) {
            $newAvailableSpace += filesize($files[$itemsRemoved]);
            $newPercentageUsed = (float) ($totalSpace - $newAvailableSpace) / $totalSpace * 100.0;

            unlink($files[$itemsRemoved]);

            ++$itemsRemoved;
            if ($newPercentageUsed < $this->thresholdDiskPercentage) {
                break;
            }
        }

        return array($itemsRemoved, $newPercentageUsed);
    }
}
