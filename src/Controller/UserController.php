<?php


namespace Framework\Controller;


use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\Stream;

class UserController extends AbstractController
{
    public function add(Request $request, array $requestAttributes): Response
    {
        return $this->renderer->renderJson($requestAttributes);
    }

    public function getAll(Request $request, array $requestAttributes) {
        return $this->renderer->renderView("user.phtml", $requestAttributes);
    }

    public function delete(Request $request, array $requestAttributes): Response
    {
        return $this->renderer->renderJson($requestAttributes);
    }
}