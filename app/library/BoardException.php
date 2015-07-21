<?php
use Phalcon\Exception;

class BoardException extends Exception {
	function __construct($errno, $obj, $extstr = "") {
		$this->errno = $errno;
		$this->obj   = $obj;
		
		$errstr      = ExceptionCodes::$errorMsg[$errno];
		if (empty($errstr)) {
			$errstr = 'Errno msg not found. errno:' . $errno;
		}
		$errstr = (!empty($extstr)) ? ($errstr . ": " . $extstr) : $errstr;
		$this->errstr = $errstr;
		
		
		$obj->result['errno'] = $this->errno;
		$obj->result['errmsg'] = $this->errstr;
		echo json_encode($obj->result);
		$obj->view->disable();

		parent::__construct($errstr, $errno);
	}

	public function getErrNo() {
		return $this->errno;
	}

	public function getErrStr() {
		return $this->errstr;
	}

	public function getErrObj() {
		return $this->obj;
	}

	private $errno;
	private $errstr;
	private $arg;
}