<?php

class UserController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function registerAction()
    {
    	if (!$this->checkRegisterParams()) {
    		echo json_encode($this->result);
    		$this->view->disable();
    		return;
    	}

        $userModel = new User();
        $res = $userModel->registerUser($this->requestParams);
        if (!$res) {
            $this->result['errno'] = 2;
            $this->result['errmsg'] = '用户注册失败';
        }

    	echo json_encode($this->result);
    	$this->view->disable();
    }

    public function loginAction() {
        // 登录时首先清除之前登录者信息。
        $this->session->remove('auth');

        if (!$this->checkLoginParams()) {
            echo json_encode($this->result);
            return;
        }

        $username  = $this->requestParams['username'];
        $password  = md5($this->requestParams['password']);
        
        $userModel = new User();
        $user      = $userModel->findFirst(array("username='$username' and password='${password}'"));
        if (!$user) {
            $this->result['errno'] = 3;
            $this->result['errmsg'] = 'login failed';
            echo json_encode($this->result);
            $this->view->disable();
            return;
        }

        // 更新最后一次登录时间和登录ip.
        // TO DO....
        
        $user      = $userModel->findFirst(array("username='$username' and password='${password}'"));
        $user      = $user->toArray();
        $this->_registerSession($user);
        echo json_encode($this->result);

        $this->view->disable();
    } 

    public function infoAction() {
        $userSessionData = $this->session->get('auth');
        if (!empty($userSessionData)) {
            $this->result['data'] = $userSessionData;
        }

        echo json_encode($this->result);

        $this->view->disable();
    }

    public function logoutAction() {
        $this->session->remove('auth');
        echo json_encode($this->result);

        $this->view->disable();
    }

    /**
     * @brief 注册一个授权用户信息到session数据中.
     */
    private function _registerSession($user)
    {
        $userSeesionData    = array();
        $userSessionDataKey = array('uid', 'username', 'login_time', 'ip');
        foreach ($userSessionDataKey as $key) {
            $userSeesionData[$key] = $user[$key];
        }

        $this->session->set('auth', $userSeesionData);
    }

    private function checkRegisterParams() {
        foreach ($this->uriParams['user_register_keys'] as $key => $castFunction) {
            if (empty($this->requestParams[$key])) {
                $this->result['errno']  = 1;
                $this->result['errmsg'] = 'params error:' . $key . ' invalidation';
                return false;
            }
        }
    	
    	return true;
    }

    private function checkLoginParams() {
        foreach ($this->uriParams['user_login_keys'] as $key => $castFunction) {
            if (empty($this->requestParams[$key])) {
                $this->result['errno']  = 1;
                $this->result['errmsg'] = 'params error:' . $key . ' invalidation';
                return false;
            }
        }
        return true;
    }
}