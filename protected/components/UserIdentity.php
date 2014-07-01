<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    protected $company;
    
    const ERROR_USER_DISABLED = 3;
    const ERROR_USER_DELETED = 4;

    public function __construct($company,$username, $password) {
        parent::__construct($username, $password);
        $this->company = $company;
    }

    public function authenticate()
    {
        $companyObj = Company::model()->findByAttributes(array('code'=>$this->company));
        if($companyObj){
            $user=User::model()->findByAttributes(array('user_name'=>$this->username,'company_id'=> $companyObj->company_id));
        }else{
            $user=null;
        }
        
        
        if($companyObj == null){
            $this->errorCode=  UserIdentity::ERROR_UNKNOWN_IDENTITY;
            $this->errorMessage="Account Name not found!";
        }elseif($user===null){
            $this->errorCode=  UserIdentity::ERROR_USERNAME_INVALID;
            $this->errorMessage="Username not found!";
        }else if(!CPasswordHelper::verifyPassword($this->password, $user->password)){
            $this->errorCode= UserIdentity::ERROR_PASSWORD_INVALID;
            $this->errorMessage="Invalid password!";
        }else{
            
            if($user->status == 2){
                $this->errorCode=self::ERROR_USER_DISABLED;
                $this->errorMessage="Your user account is currently disabled. Please contact System Administrator";
            }else{
                $this->setState('userObj', $user);
                $this->setState('company_id', $companyObj->company_id);
                
//                $role = Authitem::model()->findByPk($user->role);
//                $more_actions = unserialize($role->data);
//                $this->setState('MoreActions', is_null($more_actions)? "":$more_actions);
                
                $this->_id=$user->user_id;
                $this->errorCode=self::ERROR_NONE;
                
//                $auth=Yii::app()->authManager;
//                if(!$auth->isAssigned($user->role,$this->_id))
//                {
//                    $auth->assign($user->role,$this->_id);
//                }
            }
        }
        return $this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}