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
}