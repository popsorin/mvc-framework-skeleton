<?php


namespace Framework\Http;


use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    /**
     * @var string
     */
    private $scheme;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $fragment;

    /**
     * Uri constructor.
     * @param string $scheme
     * @param string $user
     * @param string $password
     * @param string $host
     * @param int $port
     * @param string $path
     * @param string $query
     * @param string $fragment
     */
    public function __construct(
        string $scheme = "",
        string $user = "",
        string $password = "",
        string $host = "",
        int $port = null,
        string $path = "",
        string $query = "",
        string $fragment = ""
    )
    {
        $this->scheme = $scheme;
        $this->user = $user;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }

    /**
     * @return static
     */
    public static function createFromGlobals(): self
    {
        return new Uri(
            explode('/', $_SERVER["SERVER_PROTOCOL"])[1],
            "",
            "",
            $_SERVER["HTTP_HOST"],
            (int)$_SERVER["SERVER_PORT"],
            explode('?', $_SERVER["REQUEST_URI"])[0],
            $_SERVER["QUERY_STRING"]
        );
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
        $user = $host = $port = "";
        if ($this->user !== "")
            $user = $this->user . ':';
        if ($this->host !== "")
            $host = '@' . $this->host;
        if ($this->port !== null)
            $port = ':' . $this->port;
        return $user . $this->password . $host . $port;
    }

    /**
     * @inheritDoc
     */
    public function getUserInfo()
    {
        if ($this->password == "")
            return strtolower($this->user);
        return strtolower($this->user . ':' . $this->password);
    }

    /**
     * @inheritDoc
     */
    public function getHost()
    {
        return strtolower($this->host);
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
        $uri = "";
        $autority = $this->getAuthority();
        if ($this->scheme !== "")
            $uri .= $this->scheme . ':';
        if ($autority !== "")
            $uri .= '//' . $autority;
        if ($this->path !== "")
            $uri .= '/' . $this->path;
        if ($this->query !== "")
            $uri .= '?' . $this->query;
        if ($this->fragment !== "")
            $uri .= '#' . $this->fragment;

        return $uri;
    }

    /**
     * @return array
     */
    public function getQueryArray(): array
    {
        $queryArray = explode('&', $this->query);
        $finalArray = [];
        foreach ($queryArray as $key => $query) {
            $auxArray = explode('=', $query);
            $finalArray[$auxArray[0]] = $auxArray[1];
        }

        return $finalArray;
    }

}