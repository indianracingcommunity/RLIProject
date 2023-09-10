<?php

namespace Tests\Actions;

use App\Actions\CleanupFolder;
use ErrorException;
use Tests\TestCase;
use App\Helpers\FilesystemHelpers as FH;

class CleanupFolderTest extends TestCase
{
    // use RefreshDatabase;

    private $rootFolder;
    protected function setUp(): void
    {
        parent::setUp();

        $this->rootFolder = FH::trailSlash(storage_path('test_backups'));
        FH::createDirIfNotExists($this->rootFolder);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        FH::deleteDir($this->rootFolder);
    }

    public function testInvalidPath()
    {
        // Throw exception
        $this->expectException(ErrorException::class);

        $cleanupFolder = new CleanupFolder('//ss/a');
        $cleanupFolder();
    }

    public function testUnderThreshold()
    {
        $cleanupFolder = new CleanupFolder($this->rootFolder, -1);
        $results = $cleanupFolder();

        $this->assertIsArray($results);
        $this->assertSame(0, $results[0]);
        $this->assertGreaterThan(0, $results[1]);
    }

    public function testOverThreshold()
    {
        // create 6 files - 10KB each
        $this->createNDummyFiles($this->rootFolder, 6, 10240);

        // Before: 60 + 20 + 20 = 100 (80%)
        //  After:      20 + 80 = 100 (20%)

        //   Mock:  disk_free_space - 20KB
        //         disk_total_space - 100KB
        $cleanupFolderMock = $this->getMockBuilder(CleanupFolder::class)
                                  ->setConstructorArgs([$this->rootFolder, 10])
                                  ->onlyMethods([
                                    'diskFreeSpace',
                                    'diskTotalSpace'
                                  ])->getMock();

        $cleanupFolderMock->expects($this->any())->method('diskFreeSpace')->willReturn(20480);
        $cleanupFolderMock->expects($this->any())->method('diskTotalSpace')->willReturn(102400);

        $results = $cleanupFolderMock();

        $this->assertIsArray($results);
        $this->assertSame(6, $results[0]);
        $this->assertLessThan(100, $results[1]);

        // assert files have been deleted
        for ($i = 0; $i < 6; ++$i) {
            $this->assertFileDoesNotExist($this->rootFolder . $i . '_file.txt');
        }
    }

    public function testWithFolderExclusion()
    {
        $subFolder = FH::trailSlash(storage_path('test_backups/subFolder/'));
        FH::deleteDir($subFolder);
        FH::createDirIfNotExists($subFolder);

        // create 6 files - 10KB each
        $this->createNDummyFiles($this->rootFolder, 6, 10240);
        $this->createNDummyFiles($subFolder, 7, 20480);

        // Before: 60 + 120 + 20 + 20 = 220 (90.9%)
        //  After:      120 + 20 + 80 = 220 (63.6%)

        //   Mock:  disk_free_space - 20KB
        //         disk_total_space - 220KB
        $cleanupFolderMock = $this->getMockBuilder(CleanupFolder::class)
                                  ->setConstructorArgs([$this->rootFolder, 10])
                                  ->onlyMethods([
                                    'diskFreeSpace',
                                    'diskTotalSpace'
                                  ])->getMock();

        $cleanupFolderMock->expects($this->any())->method('diskFreeSpace')->willReturn(20480);
        $cleanupFolderMock->expects($this->any())->method('diskTotalSpace')->willReturn(225280);

        $results = $cleanupFolderMock();

        $this->assertIsArray($results);
        $this->assertSame(6, $results[0]);
        $this->assertLessThan(65, $results[1]);
        $this->assertGreaterThan(60, $results[1]);

        // assert root files have been deleted
        for ($i = 0; $i < 6; ++$i)
            $this->assertFileDoesNotExist($this->rootFolder . $i . '_file.txt');
        // assert root files have been deleted
        for ($i = 0; $i < 6; ++$i)
            $this->assertFileExists($subFolder . $i . '_file.txt');

        FH::deleteDir($subFolder);
    }

    public function testDeletionOfOldestKFiles()
    {
        // create 6 files - 10KB each
        $this->createNDummyFiles($this->rootFolder, 6, 10240);

        // Before: 60 + 20 + 20 = 100 (80%)
        //  After:      20 + 80 = 100 (20%)

        //   Mock:  disk_free_space - 20KB
        //         disk_total_space - 100KB
        $cleanupFolderMock = $this->getMockBuilder(CleanupFolder::class)
                                  ->setConstructorArgs([$this->rootFolder, 45])
                                  ->onlyMethods([
                                    'diskFreeSpace',
                                    'diskTotalSpace'
                                  ])->getMock();

        $cleanupFolderMock->expects($this->any())->method('diskFreeSpace')->willReturn(20480);
        $cleanupFolderMock->expects($this->any())->method('diskTotalSpace')->willReturn(102400);

        $results = $cleanupFolderMock();

        $this->assertIsArray($results);
        $this->assertSame(4, $results[0]);
        $this->assertLessThan(100, $results[1]);

        // assert files have been deleted
        for ($i = 0; $i < 4; ++$i)
            $this->assertFileDoesNotExist($this->rootFolder . $i . '_file.txt');
        // assert remaining files have not deleted
        for ($i = 4; $i < 6; ++$i)
            $this->assertFileExists($this->rootFolder . $i . '_file.txt');
    }

    private function createNDummyFiles($baseFolder, $n, $fileSizePerFile)
    {
        $totalFileSize = 0;
        for ($i = 0; $i < $n; ++$i) {
            $fileHandler = fopen($baseFolder . $i . '_file.txt', 'w');
            $chunk = 1024;

            $fileSize = $fileSizePerFile;
            while ($fileSize > 0) {
                fputs($fileHandler, str_pad('', min($chunk, $fileSize)));
                $fileSize -= $chunk;
                $totalFileSize += $chunk;
            }

            fclose($fileHandler);
        }

        return $totalFileSize;
    }
}
