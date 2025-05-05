<?php

namespace App\Service;

class ApiResponse
{
    // Método privado para construir as respostas JSON
    private static function respond($statusCode, $message, $data = null)
    {
        $response = [
            'status_code' => $statusCode,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    // 200 OK
    public static function success($data)
    {
        return self::respond(200, 'Success', $data);
    }

    // 201 Created
    public static function created($data)
    {
        return self::respond(201, 'Created successfully', $data);
    }

    // 204 No Content
    public static function noContent($data = null)
    {
        return self::respond(204, 'No content', $data);
    }

    // 400 Bad Request
    public static function badRequest($message = 'Invalid request')
    {
        return self::respond(400, $message);
    }

    // 401 Unauthorized
    public static function unauthorized()
    {
        return self::respond(401, 'Unauthorized');
    }

    // 403 Forbidden
    public static function forbidden()
    {
        return self::respond(403, 'Forbidden access');
    }

    // 404 Not Found
    public static function notFound()
    {
        return self::respond(404, 'Request not found');
    }

    // 405 Method Not Allowed
    public static function methodNot()
    {
        return self::respond(405, 'HTTP method not allowed');
    }

    // 409 Conflict
    public static function conflict($data = null)
    {
        return self::respond(409, 'Conflict', $data);
    }

    // 422 Unprocessable Entity
    public static function validationError($errors)
    {
        return response()->json([
            'status_code' => 422,
            'message' => 'Validation error',
            'errors' => $errors,
        ], 422);
    }

    // 500 Internal Server Error com mensagem
    public static function error($message = 'Internal server error')
    {
        return self::respond(500, $message);
    }

    // 500 Internal Server Error com dados
    public static function internalServerError($data)
    {
        return self::respond(500, 'Internal server error', $data);
    }

    // Custom error code com mensagem
    public static function errorOn($message, $statusCode = 500)
    {
        return self::respond($statusCode, $message);
    }
}
