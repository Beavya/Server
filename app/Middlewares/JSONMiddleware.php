<?php

namespace Middlewares;

use Src\Request;

class JSONMiddleware
{
    public function handle(Request $request): Request
    {
        if ($request->method === 'GET') {
            return $request;
        }

        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        
        foreach ($data as $key => $value) {
            $request->set($key, $value);
        }
        
        return $request;
    }
}