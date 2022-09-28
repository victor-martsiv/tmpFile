<?php

namespace KnightWithKnife\Tmp;

use Generator;
use KnightWithKnife\Tmp\Contract\TmpInterface;
use KnightWithKnife\Tmp\Exceptions\CantCreateTmpFileException;
use KnightWithKnife\Tmp\Exceptions\CantOpenTmpFileException;
use KnightWithKnife\Tmp\Exceptions\CantWriteToTmpFileException;
use WeakReference;

class File implements TmpInterface
{
    /**
     * @param string $file - path to file location
     *
     * @throws CantCreateTmpFileException
     */
    public function __construct(private readonly string $file)
    {
        $this->create();
        $weakThis = WeakReference::create($this);
        register_shutdown_function(static function () use ($weakThis) : void {
            $weakThis->get()?->delete();
        });
    }

    /**
     * Create tmp file
     * @return void
     * @throws CantCreateTmpFileException
     */
    private function create() : void
    {
        $resource = fopen($this->file, 'wb+');
        if ($resource === false) {
            throw new CantCreateTmpFileException("Tmp file $this->file, can't be created");
        }
        fclose($resource);
    }

    /**
     * @inheritDoc
     */
    public function delete() : void
    {
        @unlink($this->file);
    }

    public function __destruct()
    {
        $this->delete();
    }

    /**
     * @inheritDoc
     */
    public function read() : string
    {
        $resource = fopen($this->file, 'rb+');
        $contents = '';
        while (!feof($resource)) {
            $contents .= fread($resource, 2048);
        }
        fclose($resource);

        return $contents;
    }

    /**
     * @inheritDoc
     */
    public function lazyRead() : Generator
    {
        $resource = fopen($this->file, 'rb+');
        while (!feof($resource)) {
            yield fread($resource, 2048);
        }
        fclose($resource);
    }

    /**
     * @inheritDoc
     */
    public function append(string $str) : void
    {
        if (!file_exists($this->file)) {
            throw new CantOpenTmpFileException("Can't open $this->file, file not exists");
        }
        $resource = fopen($this->file, 'ab');
        if (fwrite($resource, $str) === false) {
            throw new CantWriteToTmpFileException("Can't write to file $this->file");
        }
        fclose($resource);
    }

    /**
     * @inheritDoc
     */
    public function write(string $str) : void
    {
        if (!file_exists($this->file)) {
            throw new CantOpenTmpFileException("Can't open $this->file, file not exists");
        }
        $resource = fopen($this->file, 'wb');
        if (fwrite($resource, $str) === false) {
            throw new CantWriteToTmpFileException("Can't write to file $this->file");
        }
        fclose($resource);
    }
}