<?php

class StoryController extends ControllerBase
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

    	echo json_encode($this->result);
    	$this->view->disable();
    }

    /**
     * @brief: 初始化<fucntion>newAction</function>的请求参数.
     */
    private function initNewParams() {
   
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