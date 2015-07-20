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

        if (empty($this->userInfo) || empty($this->userInfo['uid'])) {
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
		$projectId = intval($projectId);
        if ($projectId <= 0) {
            $this->result['errno'] = 1;
            $this->result['errmsg'] = 'feature id dose not exist';
            echo json_encode($this->result);
            $this->view->disable();
            return;
        }

        if (empty($this->userInfo) || empty($this->userInfo['uid'])) {
            $this->result['errno'] = 2;
            $this->result['errmsg'] = 'user not login';
            echo json_encode($this->result);
            $this->view->disable();
            return;
        }

        $projectModel = new Project();
        $project = $projectModel->find(array("columns" => 'id', "id=$projectId"));
        $project = $project->toArray();
        if (empty($project)) {
            $this->result['errno'] = 3;
            $this->result['errmsg'] = 'project id does not exist';
            echo json_encode($this->result);
            $this->view->disable();
            return;
        }

        $arrInput = array();
        $arrInput['id']         = intval($projectId);
        $arrInput['create_uid'] = intval($this->requestParams['createUid']);
        $arrInput['member']     = strval($this->requestParams['member']);
        $arrInput['op_uid']     = intval($this->userInfo['uid']);
        $arrInput['op_time']    = time();

        $res = $projectModel->updateProject($arrInput);
        if (!$res) {
            $this->result['errno'] = 4;
            $this->result['errmsg'] = '更新project记录失败';
        }

        echo json_encode($this->result);
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