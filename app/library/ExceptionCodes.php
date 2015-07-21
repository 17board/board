<?php

class ExceptionCodes {
	const PARAM_ERROR          = 1; 
	
	const USER_NOT_LOGIN	   = 2;

	const DATA_ADD_FAILED      = 3;
	const DATA_DELETE_FAILED   = 4; 
	const DATA_UPDATE_FAILED   = 5;
	const DATA_SELECT_FAILED   = 6;
	const DATA_DOES_NOT_EXIST  = 7;

	public static $errorMsg    = array(
		self::PARAM_ERROR             => '参数错误',
		self::USER_NOT_LOGIN          => '用户未登录',
		self::DATA_ADD_FAILED         => '增加记录失败',
		self::DATA_DELETE_FAILED      => '删除记录失败',
		self::DATA_UPDATE_FAILED      => '修改记录失败',
		self::DATA_SELECT_FAILED      => '查询记录失败',
		self::DATA_DOES_NOT_EXIST     => '数据记录不存在',
	);
}