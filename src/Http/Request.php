<?php

namespace Framework\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request extends Message implements RequestInterface
{
    /**
     * @var string
     *
     */
    private $method;

    /**
     * @var string
     */
    private $requestTarget;

    /**
     * @var UriInterface
     */
    private $uri;

    public function __construct(
        string $method,
        StreamInterface $body,
        string $protocolVersion,
        string $requestTarget,
        UriInterface $uri
    ) {
        parent::__construct($protocolVersion, $body);
        $this->method = $method;
        $this->uri = $uri;
        $this->requestTarget = $requestTarget;
    }
    public static function createFromGlobals(): self
    {
        $request = new self(
            $_SERVER['REQUEST_METHOD'],
            new Stream(fopen("php://input", 'r')),
            explode('/', $_SERVER["SERVER_PROTOCOL"])[1],
            $_SERVER["SERVER_NAME"],
            Uri::createFromGlobals()
        ) ;
        foreach ($_SERVER as $key=>$value) {

            if(strstr($key, "HTTP")) {
                $request->addRawHeader($key, $value);
            }
        }

        return $request;

    }

    public function getParameter(string $name)
    {
        $queryArray = $this->uri->getQueryArray();
        return $this->uri->getQueryArray()[$name];
    }

    public function getCookie(string $name)
    {
        return $_COOKIE[$name];
    }

    public function moveUploadedFile(string $fileInputName, string $path)
    {
       if(!isset($_FILES[$fileInputName])) {
           //change the exception name
           throw new \Exception();
       }
       if($_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
           move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $path);
       }
    }

    /**
     * @inheritDoc
     */
    public function getRequestTarget()
    {
        return $this->requestTarget;
    }

    /**
     * @inheritDoc
     */
    public function withRequestTarget($requestTarget)
    {
        $request = clone $this;
        $request->requestTarget = $requestTarget;
    }

    /**
     * @inheritDoc
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @inheritDoc
     */
    public function withMethod($method)
    {
        $request = clone $this;
        $request->method = $method;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @inheritDoc
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $request = clone $this;
        $request->uri = $uri;

        return $request;
    }
}
