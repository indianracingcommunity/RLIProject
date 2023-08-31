<?php

namespace Tests\Helpers;

use Tests\TestCase;
use App\Helpers\FilesystemHelpers as FH;

class FilesystemHelpersTest extends TestCase
{
    public function testDeleteDirIfDirectoryExists()
    {
        $dir = storage_path('dir_deletion_test1');
        mkdir($dir);

        $this->assertTrue(FH::deleteDir($dir));
        $this->assertDirectoryDoesNotExist($dir);
    }
    public function testDeleteDir()
    {
        $dir = storage_path('dir_deletion_test2');
        mkdir(storage_path('dir_deletion_test2'));
        $file = $dir . DIRECTORY_SEPARATOR . "test_file.txt";

        $fileHandler = fopen($file, "w");
        fwrite($fileHandler, "Hello World. Testing!");
        fclose($fileHandler);

        $this->assertTrue(FH::deleteDir($file));
        $this->assertFileDoesNotExist($file);

        $fileHandler = fopen($file, "w");
        fwrite($fileHandler, "Hello World. Testing!");
        fclose($fileHandler);

        $this->assertTrue(FH::deleteDir($dir));
        $this->assertDirectoryDoesNotExist($dir);
    }

    public function testPermissionInCreateDir()
    {
        $dir = storage_path('create_dir_test');
        clearstatcache($dir);

        $result = FH::createDirIfNotExists($dir);

        $this->assertDirectoryExists($dir);
        $this->assertTrue($result);
        $this->assertEquals('0755', substr(sprintf('%o', fileperms($dir)), -4));

        FH::deleteDir($dir);
    }
    public function testExistingDir()
    {
        $dir = storage_path('create_dir_test');
        mkdir($dir);

        $this->assertTrue(FH::createDirIfNotExists($dir));

        FH::deleteDir($dir);
    }

    public function testTrailingSlash()
    {
        $this->assertEquals('/', FH::trailSlash(''));
        $this->assertEquals('/', FH::trailSlash('/'));
    }

    public function testNoTrailingSlash()
    {
        $this->assertEquals('', FH::noTrailSlash(''));
        $this->assertEquals('', FH::noTrailSlash('/'));
    }
}
