<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Models\Roles;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

//// JWT ////
use JWTAuthException;
use JWTAuth;

//// Models ////
use App\Models\Api\ApiUser as User;
use App\Models\Api\ApiTeamOwner as TeamOwner;
use App\Models\Api\ApiTeamMember as TeamMember;
use App\Models\Api\ApiAppCommand as AppCommand;
use App\Models\Api\ApiPlayer as Player;

class AppCommandController extends Controller
{
    public function getAppStopStatus(Request $request)
    {
    	$user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'     => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if(!empty($user))
        {
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            
            $command = AppCommand::find(1);

            $response['data']['code']       = 200;
            $response['data']['message']    = 'Request Successfull';
            $response['data']['result']     = $command->status;
            $response['status']             = true;    
        }
        return $response;
    }

    public function changeAppStopStatus(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'     => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if(!empty($user) && $user->isSuperAdmin())
        {
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            
            $command = AppCommand::find(1);

            if($command->status == 1)
            	$command->status = 0;
            else
            	$command->status = 1;

            if($command->save())
            {
	            $response['data']['code']       = 200;
	            $response['data']['message']    = 'Request Successfull';
	            $response['data']['result']     = $command->status;
	            $response['status']             = true;
	        }    
        }
        return $response;
    }
    
    public function abc()
    {
         $user = User::find(14);
    
        $user->sendEmailCustomer("asas","6556163");
        return "wqww";
    }
}
