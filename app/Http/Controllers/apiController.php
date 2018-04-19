<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class apiController extends Controller
{
    public function getContinent()
    {  
        try
        {
            $token = "";
            if(isset($_GET['_token']))
               $token =  $_GET['_token'];
            if(!authController::checkToken($token))
                return response()->json([
                    "statusCode" => 401,
                    "message" => "invalid token"
                ],401);

            $continents = DB::table("continents");
            if(isset($_GET['name']))
                $continents = $continents->where("name","like","%".$_GET['name']."%");

            $continents = $continents->get();
           return response()->json([
                    "statusCode" => 200,
                    "data" => $continents
                ],200);
        }
        catch(\Exception $e)
        {
            return response($e->getMessage(),500);
        }
        
    }

}