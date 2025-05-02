<?php

namespace App\Service;

class ApiResponse
{
    //Retorno das API's

    public static function NoContent($data)
    {
        return response()->json([
            'status_code' => 204,
            'message' => 'feito com success',
            'data' => $data,
        ], 204);
    }
    public static function Conflict($data)
    {
        return response()->json([
            'status_code' => 409,
            'message' => "Conflito",
            'data' => $data,
        ], 409);
    }

    //criar
    public static function created($data)
    {
        return response()->json([
            'status_code' => 201,
            'message' => 'created success',
            'data' => $data,
        ], 201);
    }

    //requisição feita com sucesso
    public static function success($data)
    {
        return response()->json([
            'status_code' => 200,
            'message' => 'success',
            'data' => $data,
        ], 200);
    }

    //error
    public static function error($message)
    {
        return response()->json([
            'status_code' => 500,
            'message' => $message
        ], 500);
    }

    public static function erroron($message, $statusCode = 500)
    {
        return response()->json([
            'status_code' => $statusCode,
            'message' => $message,
        ], $statusCode);
    }


    //sem autorização
    public static function unauthorized()
    {
        return response()->json([
            'status_code' => 401,
            'message' => 'you not access'
        ], 401);
    }

    //sem resposta
    public static function unanswered()
    {
        return response()->json([
            'status_code' => 400,
            'message' => 'dado inválido'
        ], 400);
    }


    //sem requisição
    public static function notFound()
    {
        return response()->json([
            'status_code' => 404,
            'message' => 'nao existe esse requisição'
        ], 404);
    }

    //tente outro metodo
    public static function methodNot()
    {
        return response()->json([
            'status_code' => 405,
            'message' => 'tente outro metodo http'
        ], 405);
    }

    //erro generico
    public static function internalServerError($data)
    {
        return response()->json([
            'status_code' => 500,
            'message' => 'error do servidor',
            'data' => $data,
        ], 500);
    }

}
