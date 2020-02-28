<?php


namespace Framework\Http;


use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    const DEFAULT_MEMORY = 5 * 1024 * 1024;
    const DEFAULT_MODE = 'r+';
    private $stream;
    private $seekable;
    private $readable;
    private $writable;
    private $size;

    public function __construct($handler, ?int $size = null)
    {
        $this->stream = $handler;
        $this->size = $size;
        $this->writable = $this->readable = $this->seekable = true;
    }

    public static function createFromString(string $content): self
    {
        $stream = fopen(sprintf("php://temp/maxmemory:%s", self::DEFAULT_MEMORY), self::DEFAULT_MODE);
        fwrite($stream, $content);
        return new self($stream, strlen($content));
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        $this->rewind();
        return fread($this->stream, $this->size);
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        $this->seekable = $this->writable = $this->readable = false;
        fclose($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function detach()
    {
        if ($this->stream) {
            $this->close();
        }

        $newStream = $this->stream;
        unset($this->stream);
        $this->writable = $this->readable = $this->seekable = false;

        return $newStream;
    }

    /**
     * @inheritDoc
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @inheritDoc
     */
    public function tell()
    {
        ftell($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function eof()
    {
        feof($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function isSeekable()
    {
        return $this->seekable;
    }

    /**
     * @inheritDoc
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        return fseek($this->stream, $offset);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        fseek($this->stream, 0);
    }

    /**
     * @inheritDoc
     */
    public function isWritable()
    {
        return $this->writable;
    }

    /**
     * @inheritDoc
     */
    public function write($string)
    {
        fwrite($this->stream, $string);
    }

    /**
     * @inheritDoc
     */
    public function isReadable()
    {
        $this->readable;
    }

    /**
     * @inheritDoc
     */
    public function read($length)
    {
        fread($this->stream, $length);
    }

    /**
     * @inheritDoc
     */
    public function getContents()
    {
        $this->rewind();
        return stream_get_contents($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function getMetadata($key = null)
    {
        return stream_get_meta_data($this->stream);
    }
}