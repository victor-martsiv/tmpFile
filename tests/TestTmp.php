<?php

namespace KnightWithKnife\Tmp\Test;

use PHPUnit\Framework\TestCase;

abstract class TestTmp extends TestCase
{
    protected function generateTempFilePath() : string
    {
        return sys_get_temp_dir() . '/' . uniqid('test-', true);
    }
}