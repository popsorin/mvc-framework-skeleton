<?php
declare(strict_types=1);

namespace Framework\Controller;

use Framework\Contracts\RendererInterface;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\Stream;

/**
 * Base abstract class for application controllers.
 * All application controllers must extend this class.
 */
abstract class AbstractController
{
    /**
     * @var RendererInterface
     */
    protected $renderer;

    public function __construct(RendererInterface $renderer)
    {
        // Rendered gets constructor injected
        $this->renderer = $renderer;
    }

    /**
     * @param Request $request
     * @param int $code
     * @param string $header
     * @param array $value
     * @return Response
     */
    public function createResponse(Request $request, int $code, string $header, array $value): Response
    {
        $response = new Response(Stream::createFromString(" "),'1.1', (string)$code);

        return $response->withAddedHeader($header, $value);
    }
}
