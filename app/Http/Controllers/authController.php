<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Users;

class authController extends Controller
{
    public function getToken()
    {  
    	try
    	{
			$user = Users::where("secret_id","=",$_GET['id'])
	    		->where("secret_password","=",$_GET['secret'])
	    		->get();
	    	if(count($user)<=0)
	    		return response()->json([
				    "statusCode" => 401,
		        	"message" => "secret_password or id do not exist"
				],401);

	    	$user = $user[0];
	    	$user->token = md5(uniqid());
	    	$user->validate = date("Y-m-d");
	    	$user->save();
	    	return response()->json([
			    "statusCode" => 200,
	        	"token" => $user->token,
	        	"validate" => $user->validate 
			],200);
	    }
    	catch(\Exception $e)
	   	{
	        return response()->json([
			    "statusCode" => 500,
		        "message" => $e->getMessage()
			],500);
	   	}

	}

	public static function checkToken($token)
    {  
    	try
    	{
    		$user = Users::where("token","=",$token)->get();
    		if(count($user)<0)
	    		return false;

	    	$user=$user[0];

	    	if(strtotime($user->validate) < strtotime(date("Y-m-d")))
	    		return false;

			return true;
	    }
    	catch(\Exception $e)
	   	{
	   		return false;
	   	}
    	
    }


}