<?php


namespace Framework\Http;


use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    const DEFAULT_MEMORY = 5*1024*1024;
    const DEFAULT_MOD= 'r+';
    private $stream;
    private $seekable;
    private $readble;
    private $writable;
    private $size;

    public function __construct(string $content)
    {
        $this->stream = fopen(sprintf('php://temp/maxmemory:%s'),self::DEFAULT_MEMORY, self::DEFAULT_MOD);
        $this->size = strlen($content);
        $this->writable = $this->readble = $this->seekable = true;
    }
    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return fread($this->stream, $this->size);
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        fclose($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function detach()
    {
        //close care verifica daca exista stream
        // TODO: Implement detach() method.
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
        $this->readble;
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