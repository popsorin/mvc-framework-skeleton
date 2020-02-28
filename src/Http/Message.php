<?php


namespace Framework\Http;


use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

class Message implements MessageInterface
{
    /**
     * @var string
     */
    private $protocolVersion;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var StreamInterface
     */
    private $body;

    /**
     * Message constructor.
     * @param string $protocolVersion
     * @param string[] $headers
     * @param StreamInterface $body
     */
    public function __construct(string $protocolVersion, StreamInterface $body)
    {
        $this->protocolVersion = $protocolVersion;
        $this->body = $body;
    }


    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($version)
    {
        $message = clone $this;
        $message->protocolVersion = $version;

        return $message;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        return ($this->headers[$name] !== null);
    }

    /**
     * @inheritDoc
     */
    public function getHeader($name)
    {
        return $this->headers[$name];
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine($name)
    {
        $headerString = "";
        foreach ($this->headers[$name] as $header){
            $headerString .= $header;
        }

        return $headerString;
    }

    /**
     * @inheritDoc
     */
    public function withHeader($name, $value)
    {
        if(is_array($value)) {
            $message = clone $this;
            if($message[$name] === null) {
                throw new \InvalidArgumentException();
            }
            $message[$name] = $value;

            return $message;
        }

        throw new \InvalidArgumentException();
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader($name, $value)
    {
        if(is_array($value)) {
            $message = clone $this;
            if(!isset($message->headers[$name])) {
                $message->headers[$name] = $value;
            }
            else {
                array_merge($message->headers[$name], $value);
            }

            return $message;
        }
        throw new \InvalidArgumentException();
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader($name)
    {
        $message = clone $this;
        unset($this->headers[$name]);

        return $message;
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body)
    {
        $message = clone $this;
        $message->body = $body;

        return $message;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function addRawHeader($name, $value): self
    {
        $name = ucwords(strtolower(strtr(substr($name, 5), '_', '-')), '-');
        $this->headers[$name] = explode(',', $value);
        return $this;
    }
}