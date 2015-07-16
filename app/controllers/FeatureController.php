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

        if (empty($this->userInfo || empty($this->userInfo['uid']))) {
            $this->result['errno'] = 2;
            $this->result['errmsg'] = 'user not login';
            echo json_encode($this->result);
            $this->view->disable();
            return;
        }

    	$featureModel = new Feature();
    	$res = $featureModel->newFeature($this->userInfo['uid'],
    		                             $this->requestParams['projectid'],
    		                             $this->requestParams['content']);
    	if (!$res) {
    		$this->result['errno'] = 2;
    		$this->result['errmsg'] = '新增feature记录失败';
    	} 

    	echo json_encode($this->result);
    	$this->view->disable();
    }

    public function updateAction($featureID) {
        $featureID = intval($featureID);
        if ($featureID <= 0) {
            $this->result['errno'] = 1;
            $this->result['errmsg'] = 'feature id dose not exist';
            echo json_encode($this->result);
            $this->view->disable();
            return;
        }

        if (empty($this->userInfo || empty($this->userInfo['uid']))) {
            $this->result['errno'] = 2;
            $this->result['errmsg'] = 'user not login';
            echo json_encode($this->result);
            $this->view->disable();
            return;
        }

        $featureModel = new Feature();
        $feature = $featureModel->find(array("columns" => 'id', "id=$featureID"));
        $feature = $feature->toArray();
        if (empty($feature)) {
            $this->result['errno'] = 3;
            $this->result['errmsg'] = 'feature id does not exist';
            echo json_encode($this->result);
            $this->view->disable();
            return;
        }

        $arrayInput = array();
        if (!empty($this->requestParams['sort'])) {
            $arrayInput['sort'] = intval($this->requestParams['sort']);
        }
        if (!empty($this->requestParams['content'])) {
            $arrayInput['content'] = strval($this->requestParams['content']);
        }
        if (empty($arrayInput)) {
            echo json_encode($this->result);
            $this->view->disable();
            return;
        }
        $arrayInput['op_uid'] = $this->userInfo['uid'];
        $arrayInput['op_time'] = time();
        $arrayInput['id']  = $featureID;
        $res = $featureModel->updateFeature($arrayInput);

        if (!$res) {
            $this->result['errno'] = 4;
            $this->result['errmsg'] = '更新feature记录失败';
        }
        echo json_encode($this->result);
        $this->view->disable();
    }

    public function deleteAction($featureID) {
        $featureID = intval($featureID);
        if ($featureID <= 0) {
            $this->result['errno'] = 1;
            $this->result['errmsg'] = 'feature id dose not exist';
            echo json_encode($this->result);
            $this->view->disable();
            return;
        }

        if (empty($this->userInfo || empty($this->userInfo['uid']))) {
            $this->result['errno'] = 2;
            $this->result['errmsg'] = 'user not login';
            echo json_encode($this->result);
            $this->view->disable();
            return;
        }

        $featureModel = new Feature();
        $feature = $featureModel->find(array("columns" => 'id', "id=$featureID"));
        $feature = $feature->toArray();
        if (empty($feature)) {
            $this->result['errno'] = 3;
            $this->result['errmsg'] = 'feature id does not exist';
            echo json_encode($this->result);
            $this->view->disable();
            return;
        }

        $res = $featureModel->deleteFeature($featureID, $this->userInfo['uid']);
        
        if (!$res) {
            $this->result['errno'] = 4;
            $this->result['errmsg'] = '删除feature记录失败';
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
