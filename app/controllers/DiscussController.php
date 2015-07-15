<?php

class DiscussController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
    	echo "<h1>Hello World!</h1>";
    	$this->view->disable();
    }

    /**
    *  @brief: 评论功能
    */
    public function newAction()
    {
		echo "<h1>new!</h1>";
		$this->view->disable();
    }

    /**
    *  @brief: 查看某个用户的项目情况接口
    */
    public function listAction()
    {
		echo "<h1>list!</h1>";
    }
}
