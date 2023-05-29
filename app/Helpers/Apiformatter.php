<?php
//file ini mengatur pengambilan api
//untuk mengatur pposisii file yang ada di folder nama 
namespace App\Helpers;

class ApiFormatter{
    //membuat variabel static berupa array(variabel yg dihasilkan ktika api dignkan)
    protected static $response =[
        'code' => NULL,
        'message' => NULL,
        'data' => NULL,
        

    ];
    public static function createAPI($code =NULL, $message = NULL, $data = NULL)
    {
        //mengisi data ke variabel $response yg di atas
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;
        
        return response()->json(self::$response, self::$response['code']);
    }
}
?>