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
		
		// 在异常类中调用controller类的方法。感觉不是特别优雅。根据设计模式的原则，如下的三行应该处于controller中，
		// 但是目前没能找到写到controller的方法，因此暂时先采用扩展controller的方式，安置于此。
		$obj->setResult($this->errno, $this->errstr, array());
		echo json_encode($obj->getResult());
		$obj->setViewDisable();

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