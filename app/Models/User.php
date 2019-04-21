<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use App\Components\PushNotification;

class User extends Authenticatable
{
    //Status Constants
    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 0;
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    const USER_SUPER_ADMIN = 'super_admin';
    const USER_ADMIN = 'admin';
    const TEAM_OWNER = 'team_owner';
    const SERVICE_PROVIDER = 'service_provider';
    const USER_STUDENT = 'student';
    const USER_SECONDARY_ADMIN = 'secondary_admin';
    
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'roleId',
        'resetPasswordToken',
        'createdResetPToken',
        'avatarFilePath',
        'deviceToken',
        'deviceType',
        'verified',
        'onlineStatus',
        'language'
        // 'createdAt',
        // 'updatedAt'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'resetPasswordToken','deviceToken',
    ];

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * @return mixed
     */
    public function role()
    {
        return $this->hasOne(Roles::class,'id','roleId');
    }

    /**
     * @return mixed
     */
    public function teamOwner()
    {
        return $this->hasOne(TeamOwner::class,'userId','id');
    }

    /**
     * @return mixed
     */
    public function ServiceProvider()
    {
        return $this->hasOne(ServiceProvider::class,'userId','id');
    }

    public function statusVerified(){
        return ($this->verified) ? 'Active' : 'In-Active';
    }

    public function isSuperAdmin(){
        if($this->role->label == self::USER_SUPER_ADMIN)
            return true;

        return false;
    }

    public function isTeamOwner(){
        if($this->role->label == self::TEAM_OWNER)
            return true;

        return false;
    }

    public function isServiceProvider(){
        if($this->role->label == self::SERVICE_PROVIDER)
            return true;

        return false;
    }


    public function isVerified(){
        if($this->verified == self::STATUS_ACTIVE)
            return true;

        return false;
    }

    public function isValidUser(){
        if($this->isSuperAdmin())
            return true;
        elseif($this->isTeamOwner() && !empty($this->teamOwner))
            return true;
        return false;
    }

    public static function getTypes(){
        return [
                self::USER_SUPER_ADMIN => 'Super Admin',
            ];
    }
    
    public function getArrayResponse() {
        return [
            'id'            => $this->id,
            'username'      => $this->username,
            'verified'      => $this->statusVerified(),
            'image'         => $this->getImage(),
            'onlineStatus'  => $this->onlineStatus,
        ];
    }

    public function getName(){
        if($this->isServiceProvider() && !empty($this->ServiceProvider))
            return $this->ServiceProvider->name;
        elseif($this->isCustomer() && !empty($this->Customer))
            return $this->Customer->firstName.' '.$this->Customer->lastName;

        return '';
    }

    public function getFullNameAttribute(){
        if($this->isServiceProvider() && !empty($this->ServiceProvider))
            return $this->ServiceProvider->name;
        elseif($this->isCustomer() && !empty($this->Customer))
            return $this->Customer->firstName.' '.$this->Customer->lastName;
        return '';
    }

    public function getFirstName(){
        if($this->isServiceProvider() && !empty($this->ServiceProvider))
            return $this->ServiceProvider->name;
        elseif($this->isCustomer() && !empty($this->Customer))
            return $this->Customer->firstName;
        return '';
    }

    public function getLastName(){
        if($this->isServiceProvider() && !empty($this->ServiceProvider))
            return $this->ServiceProvider->name;
        elseif($this->isCustomer() && !empty($this->Customer))
            return $this->Customer->lastName;
        return '';
    }
    
    public function getDefaultImage(){
        $defaultImage = '';//'dumy.png';
        // if(file_exists(storage_path('app/public/'.$defaultImage)))
            return $defaultImage;

        // return '';
    }

    public function getImage(){
        // if(!empty($this->avatarFilePath) && file_exists(public_path($this->avatarFilePath)))
        //     return url('public/'.$this->avatarFilePath);
        // return '';
        if(!empty($this->avatarFilePath))
            return $this->avatarFilePath;

        return $this->getDefaultImage();
    }

    public function clearDeviceToken(){
        if(!empty($this->deviceToken)){
            $this->update([
                'deviceToken' => ''
            ]);
        }
    }

    public function sendPushNotification($message,$screenType){
        if(!empty($message) && !empty($this->deviceToken)){
            $data = [
                'message'           =>  $message,
                'messagetemp'       =>  $screenType.$message,
                'screenType'        =>  $screenType,
                'registrationID'    =>  $this->deviceToken
            ];
            return PushNotification::send($this->deviceType,$data,$screenType);
            return true;
        }
        return false;
    }

    public function sendEmailCustomer($leagueName,$accessCode){
        \Mail::send('mail',["fName"=>$this->teamOwner->firstName,"lName"=>$this->teamOwner->lastName,"leagueName"=>$leagueName,"accessCode"=>$accessCode], function ($message) {
            $message->from('info@fantasycricleague.online', 'New League');
            $message->to($this->username)->subject('New League is Created!');
        });
        return true;
    }
}
