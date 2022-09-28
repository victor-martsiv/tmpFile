<?php

namespace KnightWithKnife\Tmp\Contract;

use Generator;
use KnightWithKnife\Tmp\Exceptions\CantOpenTmpFileException;
use KnightWithKnife\Tmp\Exceptions\CantWriteToTmpFileException;

interface TmpInterface
{
    /**
     * Delete tmp file
     * @return void
     */
    public function delete() : void;

    /**
     * Read file
     * @return string
     */
    public function read() : string;

    /**
     * Lazy reading from file
     * @return Generator
     */
    public function lazyRead() : Generator;

    /**
     * Append text to end of file
     *
     * @param string $str - str data which will be added to the end of tmp file
     *
     * @return void
     * @throws CantOpenTmpFileException
     * @throws CantWriteToTmpFileException
     */
    public function append(string $str) : void;

    /**
     * Write text to file
     *
     * @param string $str - content
     *
     * @return void
     * @throws CantOpenTmpFileException
     * @throws CantWriteToTmpFileException
     */
    public function write(string $str) : void;
}