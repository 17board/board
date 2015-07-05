<?php

class FeatureController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function newAction()
    {
    	$this->initNewParams();
    	if (!$this->checkNewParams()) {
    		echo json_encode($this->result);
    		$this->view->disable();
    		return;
    	}

    	$featureModel = new Feature();
    	$res = $featureModel->newFeature($this->requestParams['uid'],
    		                                $this->requestParams['projectid'],
    		                                $this->requestParams['content']);
    	if (!$res) {
    		$this->result['errno'] = 2;
    		$this->result['errmsg'] = '新增feature记录失败';
    	} 

    	echo json_encode($this->result);
    	$this->view->disable();
    }

    /**
     * @brief: 初始化<fucntion>newAction</function>的请求参数。
     *         之后会写成通用方法。
     */
    private function initNewParams() {
    	$this->requestParams = array();
        foreach ($this->featureNewKeys as $key=>$castFunction) {
            $$key = $this->request->getPost($key);
            if (empty($$key)) {
                $$key = $this->request->get($key);
            }  
            $this->requestParams[$key] = $$key;
        }
    }

    /**
     * @brief: 对<function>newAction</function>的请求参数进行检查。
     *         暂时先用这种方式，之后会改成throw exception的方式。
     */
    private function checkNewParams() {
    	foreach ($this->featureNewKeys as $key => $castFunction) {
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
    private $featureNewKeys = array('projectid' => 'intval',
                                   'content'   => 'strval',
                                   'uid'       => 'intval');
}
