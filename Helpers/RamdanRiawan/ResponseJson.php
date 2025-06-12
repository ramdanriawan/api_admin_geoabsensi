<?php
namespace RamdanRiawan;

class ResponseJson {
    public static function success($data = null)
    {
        return response()->json([
            'success' => true,
            'message' => "Success",
            'errors' => null,
            'data'    => $data,
        ]);
    }

    public static function unauthorized()
    {
        return response()->json([
            'success' => false,
            'message' => "Unauthorized",
            'errors' => null,
            'data'    => null,
        ], 401);
    }

    public static function badRequest($message = "failed")
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => null,
            'data'    => null,
        ], 400);
    }

    public static function exist($message = "Data exist")
    {
        return self::badRequest($message);
    }


    public static function notFound()
    {
        return response()->json([
            'success' => false,
            'message' => "Not Found",
            'errors' => null,
            'data'    => null,
        ], 404);
    }
}
