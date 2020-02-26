<?php


namespace Framework\Http;


use Psr\Http\Message\UriInterface;

class URI implements UriInterface
{
    private $scheme;
    private $userInfo;
    private $host;
    private $port;
    private $path;
    private $query;
    public $fragment;
    /**
     * URI constructor.
     * @param string $scheme
     * @param string $userInfo
     * @param string $host
     * @param string $port
     * @param string $path
     * @param string $query
     * @param string $fragment
     */
    public function __construct(
        string $scheme,
        string $userInfo,
        string $host,
        string $port,
        string $path,
        string $query,
        string $fragment
    ) {
        $this->scheme = $scheme;
        $this->userInfo = $userInfo;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }


    /**
     * @inheritDoc
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @inheritDoc
     */
    public function getAuthority()
    {
        return $this->userInfo . $this->host . $this->port;
    }

    /**
     * @inheritDoc
     */
    public function getUserInfo()
    {
        return $this->userInfo;
    }

    /**
     * @inheritDoc
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @inheritDoc
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @inheritDoc
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @inheritDoc
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @inheritDoc
     */
    public function withScheme($scheme)
    {
        $uri = clone $this;
        $uri->scheme = $scheme;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withUserInfo($user, $password = null)
    {
        $uri = clone $this;
        $uri->scheme = $user . ':' . $password;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withHost($host)
    {
        $uri = clone $this;
        $uri->scheme = $host;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withPort($port)
    {
        $uri = clone $this;
        $uri->scheme = $port;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withPath($path)
    {
        $uri = clone $this;
        $uri->scheme = $path;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withQuery($query)
    {
        $uri = clone $this;
        $uri->scheme = $query;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withFragment($fragment)
    {
        $uri = clone $this;
        $uri->scheme = $fragment;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        //return $this->scheme .
    }
}