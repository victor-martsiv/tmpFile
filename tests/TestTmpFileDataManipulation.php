<?php

namespace KnightWithKnife\Tmp\Test;

use Faker\Provider\Lorem;
use KnightWithKnife\Tmp\File;

class TestTmpFileDataManipulation extends TestTmp
{
    public function testFileHasWroteContent() : void
    {
        $testData = Lorem::text();
        $filePath = $this->generateTempFilePath();
        $tmpHandler = new File($filePath);
        $tmpHandler->write($testData);
        self::assertStringEqualsFile($filePath, $testData);
    }

    public function testFileHasAppendContent() : void
    {
        $testData = Lorem::text();
        $filePath = $this->generateTempFilePath();
        $tmpHandler = new File($filePath);
        $tmpHandler->write($testData);
        $tmpHandler->append($testData);
        self::assertStringEqualsFile($filePath, $testData . $testData);
    }

    public function testFileReadContent() : void
    {
        $testData = Lorem::text();
        $filePath = $this->generateTempFilePath();
        $tmpHandler = new File($filePath);
        $tmpHandler->write($testData);
        $readData = $tmpHandler->read();
        self::assertEquals($testData, $readData);
    }
}