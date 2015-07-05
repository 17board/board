<?php

class UserController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function registerAction()
    {
    	$this->initRegisterParams();
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

    /**
     * @brief: 初始化<fucntion>registerAction</function>的请求参数。
     */
    private function initRegisterParams() {
        $this->requestParams = array();
        foreach ($this->userRegisterKeys as $key=>$castFunction) {
            $$key = $this->request->getPost($key);
            if (empty($$key)) {
                $$key = $this->request->get($key);
            }  
            $this->requestParams[$key] = $$key;
        }
    }

    /**
     * @brief: 对<function>registerAction</function>的请求参数进行检查。
     *         暂时先用这种方式，之后会改成throw exception的方式。
     */
    private function checkRegisterParams() {
        foreach ($this->userRegisterKeys as $key => $castFunction) {
            if (empty($this->requestParams[$key])) {
                $this->result['errno']  = 1;
                $this->result['errmsg'] = 'params error:' . $key . ' invalidation';
                return false;
            }

            $this->requestParams[$key] = $castFunction($this->requestParams[$key]);
        }
    	
    	return true;
    }

    // 用户注册接口需要的字段.后续会放到配置里。
    private $userRegisterKeys  = array('username'  => 'strval', 
                                   'password'  => 'md5', 
                                   'nickname'  => 'strval', 
                                   'email'     => 'strval', 
                                   'role'      => 'intval',);
}