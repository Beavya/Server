<?php

namespace Middlewares;

use Src\Request;
use Model\Token;

class BearerAuthMiddleware
{
    public function handle(Request $request): Request
    {
        // $uri = $_SERVER['REQUEST_URI'] ?? '';
        // if (strpos($uri, '/api') === false) {
        //     return $request;
        // }

        $authHeader = $request->headers['Authorization'] ?? '';

        if (empty($authHeader) || !preg_match('/Bearer\s+(.*)$/', $authHeader, $matches)) {
            http_response_code(401);
            echo json_encode(['error' => 'Token not provided']);
            exit;
        }

        $token = $matches[1];

        $tokenRecord = Token::where('token', $token)->first();

        if (!$tokenRecord) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid token']);
            exit;
        }

        $request->set('user_id', $tokenRecord->id_staff);

        return $request;
    }
}