<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;
    protected $company;

    const ERROR_USER_DISABLED = 3;
    const ERROR_USER_DELETED = 4;

    public function __construct($company, $username, $password) {
        parent::__construct($username, $password);
        $this->company = $company;
    }

    public function authenticate() {

        $companyObj = Company::model()->findByAttributes(array('code' => $this->company));

        if ($companyObj) {
            $user = User::model()->findByAttributes(array('user_name' => $this->username, 'company_id' => $companyObj->company_id));
        } else {
            $user = null;
        }

        if ($companyObj == null) {
            $this->errorCode = UserIdentity::ERROR_UNKNOWN_IDENTITY;
            $this->errorMessage = "Account Name not found!";
        } elseif ($user === null) {
            $this->errorCode = UserIdentity::ERROR_USERNAME_INVALID;
            $this->errorMessage = "Username not found!";
        } else if (!CPasswordHelper::verifyPassword($this->password, $user->password)) {
            $this->errorCode = UserIdentity::ERROR_PASSWORD_INVALID;
            $this->errorMessage = "Invalid password!";
        } else {

            if ($user->status == 2) {
                $this->errorCode = self::ERROR_USER_DISABLED;
                $this->errorMessage = "Your user account is currently disabled. Please contact System Administrator";
            } else {
                $this->setState('userObj', $user);
                $this->setState('company_id', $companyObj->company_id);

                $role = Authitem::model()->findByAttributes(array("name" => $user->user_type_id, 'bizrule' => 'return "' . $user->company_id . '" == $params["company_id"];'));

                if (count($role) > 0) {
                    if ($role->updated_date == "") {

                        $data_first_rem = strstr($role->data, '{');
                        $data_last_rem = strstr(strrev($data_first_rem), '}');
                        $final_data = strrev($data_last_rem);
                    } else {

                        $final_data = $role->data;
                    }
                }
                
                $unserialize = CJSON::decode(isset($final_data) ? $final_data : "");
                $so = CJSON::decode($unserialize['so']);
                $zones = CJSON::decode($unserialize['zone']);

                $so_id = "'',";
                if ($so != "") {
                    foreach ($so as $k => $v) {
                        $so_id .= "'" . $k . "',";
                    }
                }
                $this->setState('salesoffices', substr($so_id, 0, -1));

                $zone_id = "'',";
                if ($zones != "") {
                    foreach ($zones as $k1 => $v1) {
                        $zone_id .= "'" . $k1 . "',";
                    }
                }                
                $this->setState('zones', substr($zone_id, 0, -1));

                $this->_id = $user->user_id;
                $this->errorCode = self::ERROR_NONE;

                $auth = Yii::app()->authManager;

                if (count($role) > 0) {
                    if (!$auth->isAssigned($role->name, $this->_id)) {
                        $auth->assign($role->name, $this->_id);
                    }
                }

                $this->setState('auth_company_id', 'return "' . $user->company_id . '" == $params["company_id"];');

                $role_operation_dashboard = Authitem::model()->findByAttributes(array("type" => 0, 'description' => 'Dashboard', 'bizrule' => 'return "' . $user->company_id . '" == $params["company_id"];'));

                $this->setState("auth_company_dashboard", isset($role_operation_dashboard) ? $role_operation_dashboard->name : "");
            }
        }
        return $this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

}
