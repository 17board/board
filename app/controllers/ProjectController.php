<?php

class ProjectController extends ControllerBase {
	public function initialize() {
		parent::initialize();
	}

	public function newAction() {
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

        $porjectModel = new Project();
        $res = $porjectModel->newProject($this->requestParams, $this->userInfo);
        if (!$res) {
    		$this->result['errno'] = 2;
    		$this->result['errmsg'] = '新增project记录失败';
    	} 

    	echo json_encode($this->result);
		$this->view->disable();
	}

	public function updateAction($projectId) {
		echo $projectId;
		var_dump($this->requestParams);
		$this->view->disable();
	}

	private function checkNewParams() {
		foreach ($this->uriParams['project_new_keys'] as $key => $castFunction) {
			if ($key == 'member') {
				continue;
			}

			if (empty($this->requestParams[$key])) {
                $this->result['errno']  = 1;
                $this->result['errmsg'] = 'params error:' . $key . ' invalidation';
                return false;
            }
		}

		return true;
	}
}