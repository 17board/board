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
     * @brief: 初始化<fucntion>newAction</function>的请求参数.
     */
    private function initNewParams() {
    	$projectId = $this->request->getPost('projectid');
     	$content   = $this->request->getPost('content');
        $uid       = 12345;

	    if (empty($projectID)) {
	    	$projectId = $this->request->get('projectid');
	    }
	    if (empty($content)) {
	    	$content   = $this->request->get('content');
	    }

	    $this->requestParams = array('projectid' => intval($projectId),
	    							 'content'   => trim(strval($content)),
	    							 'uid'       => intval($uid),
	    					   );
    }

    /**
     * @brief: 对<function>newAction</function>的请求参数进行检查。
     *         暂时先用这种方式，之后会改成throw exception的方式。
     */
    private function checkNewParams() {
    	if (false) {
    		$this->result['errno']  = 1;
    		$this->result['errmsg'] = 'params error';
    		return false;
    	}

    	return true;
    }
}
