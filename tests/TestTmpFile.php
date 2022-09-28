<?php

namespace KnightWithKnife\Tmp\Test;

use KnightWithKnife\Tmp\File;
use Symfony\Component\Process\PhpProcess;

class TestTmpFile extends TestTmp
{
    public function testIsCreateTmpFile() : void
    {
        $filePath = $this->generateTempFilePath();
        $tmpHandler = new File($filePath);
        self::assertFileExists($filePath);
    }

    public function testIsFileDeletedAfterUnset() : void
    {
        $filePath = $this->generateTempFilePath();
        $tmpHandler = new File($filePath);
        unset($tmpHandler);
        self::assertFileDoesNotExist($filePath);
    }

    public function testIsFileDeletedAfterFatalError() : void
    {
        $filePath = $this->generateTempFilePath();
        $process = new PhpProcess(
          file_get_contents(__DIR__ . '/fatalError.php'), __DIR__, ['TEMP_FILE' => $filePath]
        );
        $process->run();
        self::assertStringContainsString('Fatal error: Fatal error!', $process->getOutput());
        self::assertFileDoesNotExist($filePath);
    }
}