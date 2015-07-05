<?php

use Phalcon\Mvc\Model;

class User extends Model {
	/**
	 * 设置模型的表名称，由于我们的表名不遵循phalcon的一些规范(模型名和表明一直)，
	 * 因此，需要在初始化方法中设置表名，否则会导致模型操作失败。
	 * https://docs.phalconphp.com/zh/latest/reference/models.html
	 */
	public function initialize() {
		//parent::initialize();   //暂时注释掉，原因可以去掉注释试一下。
		$this->setSource('tbl_user');
	}

	/**
	 * 创建一个新的User。
	 * data:{username, password, nickname, email, role}
	 */
	public function registerUser($data) {
		$username   = $data['username'];
		$userExist  = $this->find(array("columns" => 'uid', "username='${username}'"));
		$userExist  = $userExist->toArray();
		if (!empty($userExist)) {
			return false;
		}
		
		$currentUid = $this->find(array("columns" => 'uid', "order" => "id desc", "limit" => 1));
		$currentUid = $currentUid->toArray();
		$this->uid  = 1;
		if (!empty($currentUid)) {
			$this->uid = $currentUid[0]['uid'] + 1;
		}

		$this->username      = $data['username'];
		$this->password      = md5($data['password']);
		$this->nickname      = $data['nickname'];
		$this->email         = $data['email'];
		$this->avatar        = "";
		$this->role          = $data['role'];
		$this->privilege     = 0;
		$this->register_time = time();
		$this->login_time    = 0;
		$this->ip            = 0;

		return $this->save();
	}

	private $uid;
	private $username;
	private $password;
	private $nickname;
	private $email;
	private $avatar;
	private $role;
	private $privilege;
	private $register_time;
	private $login_time;
	private $ip;
}