<?php
use Phalcon\Mvc\Model;

class Project extends Model {
	public function initialize() {
		$this->setSource("tbl_project");
	}

	public function newProject($projInfo, $userInfo) {
		$this->name        = $projInfo['name'];
		$this->type        = $projInfo['type'];
		$this->status      = 0;
		$this->create_time = time();
		$this->begin_time  = 0;
		$this->end_time    = 0;
		$this->create_uid  = intval($userInfo['uid']);
		$this->member      = $projInfo['member'];
		$this->op_time     = time();
		$this->op_uid      = intval($userInfo['uid']);

		return $this->save();
	}

	public $id;
	public $name;
	public $type;
	public $status;
	public $create_time;
	public $begin_time;
	public $end_time;
	public $create_uid;
	public $member;
	public $op_time;
	public $op_uid;
}