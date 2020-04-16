<?php

namespace Framework\Renderer;

use Framework\Contracts\RendererInterface;
use Framework\Http\Response;
use Framework\Http\Stream;
use Framework\Service\URLHelper;

class Renderer implements RendererInterface
{
    /**
     * @var string
     */
    private $baseViewsPath;

    /**
     * @var URLHelper
     */
    private $urlHelper;

    /**
     * Renderer constructor.
     * @param string $baseViewsPath
     */
    public function __construct(string $baseViewsPath)
    {
        $this->baseViewsPath =$baseViewsPath;
    }

    /**
     * @param string $viewFile
     * @param array $arguments
     * @return Response
     */
    public function renderView(string $viewFile, array $arguments): Response
    {
        $fullPath = $this->baseViewsPath . DIRECTORY_SEPARATOR . $viewFile;
        ob_start();
        extract($arguments);
        require $fullPath;
        $content = ob_get_clean();
        $stream = Stream::createFromString($content);

        return new Response($stream);
    }

    /**
     * @param array $data
     * @return Response
     */
    public function renderJson(array $data): Response
    {
        $json = json_encode($data);
        $stream = Stream::createFromString($json);

        return new Response($stream);
    }

    /**
     * @return URLHelper
     */
    public function getURLHelper(): URLHelper
    {
        return $this->urlHelper;
    }
}