<?php

class FeatureController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function newAction()
    {
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

    private function checkNewParams() {
    	foreach ($this->uriParams['feature_new_keys'] as $key => $castFunction) {
            if (empty($this->requestParams[$key])) {
                $this->result['errno']  = 1;
                $this->result['errmsg'] = 'params error:' . $key . ' invalidation';
                return false;
            }
        }
        
        return true;
    }
}
