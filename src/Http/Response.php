<?php

namespace Framework\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response extends Message implements ResponseInterface
{

    /**
     * @var int
     */
    private $codeStatus;

    /**
     * Response constructor.
     * @param StreamInterface $body
     * @param string $protocolVersion
     * @param string $codeStatus
     */
    public function __construct(StreamInterface $body, string $protocolVersion = '1.1', string $codeStatus = "200")
    {
        parent::__construct($protocolVersion, $body);
        $this->codeStatus = $codeStatus;
    }

    public function send(): void
    {
        if($this->getHeaders() !== null) {
            $this->sendHeaders();
        }
        $this->sendBody();
    }

    private function sendHeaders(): void
    {
       foreach ($this->getHeaders() as $header => $values) {
           header($header . ':' . implode(', ', $values));
        }
    }

    private function sendBody(): void
    {
       echo $this->getBody();
    }

    /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        return $this->codeStatus;
    }

    /**
     * @inheritDoc
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $response = clone $this;
        $response->codeStatus = $code;

        return $response;
    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase()
    {
        // TODO: Implement getReasonPhrase() method.
    }
}
