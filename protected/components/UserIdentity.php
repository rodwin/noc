<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

    public function authenticate()
    {
        $user=User::model()->findByAttributes(array('user_name'=>$this->username));
        
        if($user===null){
            $this->errorCode=  UserIdentity::ERROR_USERNAME_INVALID;
            
        }else if(!CPasswordHelper::verifyPassword($this->password, $user->password)){
            $this->errorCode= UserIdentity::ERROR_PASSWORD_INVALID;
            
        }else{
            if($user->deleted == 1){

                $this->errorMessage="Your account is currently deleted. Please contact System Administrator";
            }elseif($user->status == 20){

                $this->errorMessage="Your account is currently disabled. Please contact System Administrator";
            }else{
                $this->setState('userObj', $user);
                
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
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}