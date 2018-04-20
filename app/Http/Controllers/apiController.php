<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Continent;
use App\Country;
use App\State;
use App\City;

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

            $continents = Continent::where("id",">=","0");

            if(isset($_GET['name']))
                $continents = $continents->where("name","like","%".$_GET['name']."%");

            if(isset($_GET['id']))
                $continents = $continents->where("id","=",$_GET['id']);

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

    public function getCountry()
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

            $country = Country::where("id",">=","0");

            if(isset($_GET['name']))
                $country = $country->where("name","like","%".$_GET['name']."%");

            if(isset($_GET['id']))
                $country = $country->where("id","=",$_GET['id']);

            if(isset($_GET['continent_id']))
                $country = $country->where("continent_id","=",$_GET['continent_id']);

            $country = $country->get();
           return response()->json([
                    "statusCode" => 200,
                    "data" => $country
                ],200);
        }
        catch(\Exception $e)
        {
            return response($e->getMessage(),500);
        }
    }



    public function getState()
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

            $state = State::where("id",">=","0");

            if(isset($_GET['name']))
                $state = $state->where("name","like","%".$_GET['name']."%");

            if(isset($_GET['id']))
                $state = $state->where("id","=",$_GET['id']);

            if(isset($_GET['country_id']))
                $state = $state->where("country_id","=",$_GET['country_id']);

            $state = $state->get();
            return response()->json([
                    "statusCode" => 200,
                    "data" => $state
                ],200);
        }
        catch(\Exception $e)
        {
            return response($e->getMessage(),500);
        }
    }

    public function getCity()
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

            $city = City::where("id",">=","0");

            if(isset($_GET['name']))
                $city = $city->where("name","like","%".$_GET['name']."%");

            if(isset($_GET['id']))
                $city = $city->where("id","=",$_GET['id']);

            if(isset($_GET['state_id']))
                $city = $city->where("state_id","=",$_GET['state_id']);

            $city = $city->get();
            return response()->json([
                    "statusCode" => 200,
                    "data" => $city
                ],200);
        }
        catch(\Exception $e)
        {
            return response($e->getMessage(),500);
        }
    }


}