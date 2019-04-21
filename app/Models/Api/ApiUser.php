<?php

/* Folder Location */

namespace App\Models\Api;

/* Dependencies */

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class ApiUser.
 */
class ApiUser extends User {
    public static function loginUser($id,$token,$message = '') {

        /* Find User For Provided Email */
        $model = Self::where(['id' => $id])->first();

        if ($model->verified == Self::STATUS_INACTIVE) {
            return Self::generateErrorMessage(false, 400, 'Account not verified. Please verify your account through the verification email sent to your email id.');
        }

        return $token;
        // return [
        //     'status' => true,
        //     'data' => [
        //         'message' => ($message == '') ? 'User Login successfully.' : $message,
        //         'user' => $model->getArrayResponse(),
        //         'token' => $token
        //     ]
        // ];
    }
    
    // public function getArrayResponse() {
    //     return [
    //         'id'            =>  $this->id,
    //         'title'         =>  $this->getTitle(),
    //         'first_name'    =>  $this->getFirstName(),
    //         'last_name'     =>  $this->getLastName(),
    //         'fullname'      =>  $this->fullname,
    //         'username'      =>  $this->username,
    //         'verified'      =>  $this->statusVerified(),
    //         'roles' => [
    //             'id'        => $this->roleId,    
    //             'label'     => $this->role->label,
    //         ]
    //         // 'profile_picture' => (!empty($this->avatar_location) && file_exists(public_path($this->avatar_location))) ? url('public/'.$this->avatar_location) : ''
    //     ];
    // }

    public function sendEmailForgotPassword(){
        \Mail::send('mail2',["fName"=>$this->teamOwner->firstName,"lName"=>$this->teamOwner->lastName,"accessCode"=>$this->resetPasswordToken], function ($message) {
            $message->from('info@fantasycricleague.online', 'Password');
            $message->to($this->username)->subject('Forgot Password!');
        });
        return true;
    }

    public function sendWellcomeEmailTeamOwner(){
        \Mail::send('mails.wellcome', [
                'firstName' => $this->teamOwner->firstName,
            ], function ($message) {
                $message->from('hassanamir210@gmail.com', 'The PSL Team');
                $message->to($this->username)->subject('Wellcome To PSL');
        });
        return true;
    }

    // public function sendEmailCustomer($mySubject,$content){
    //     \Mail::send('mails.adminMail', [
    //             'firstName' => $this->customer->firstName,$content,
    //         ], function ($message) use ($mySubject) {
    //             $message->from('hassanamir210@gmail.com', 'The Gold Spring Team');
    //             $message->to($this->username)->subject($mySubject);
    //     });
    //     return true;
    // }
}