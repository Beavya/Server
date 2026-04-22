<?php

namespace Controller;

use Src\Request;
use Src\View;
use Model\Author;

class ApiController
{
    public function authors(Request $request): void
    {
        $authors = Author::all()->toArray();
        (new View())->toJSON($authors);
    }
}