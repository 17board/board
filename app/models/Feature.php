<?php

use Phalcon\Mvc\Model;

class Feature extends Model {
	/**
	 * 设置模型的表名称，由于我们的表名不遵循phalcon的一些规范(模型名和表明一直)，
	 * 因此，需要在初始化方法中设置表名，否则会导致模型操作失败。
	 * https://docs.phalconphp.com/zh/latest/reference/models.html
	 */
	public function initialize() {
		//parent::initialize();   //暂时注释掉，原因可以去掉注释试一下。
		$this->setSource('tbl_feature');
	}

	/**
	 * 创建一个新的feature。
	 */
	public function newFeature($createUid, $projectId, $content) {
		$this->project_id  = $projectId;
		$this->deleted      = 0;
		$this->sort        = 1;
		$this->content     = $content;
		$this->create_time = time();
		$this->create_uid  = $createUid;
		$this->op_time     = 0;
		$this->op_uid      = 0;

		return $this->save();
	}

	public function updateFeature($arrayInput) {
		$id = $arrayInput['id'];
		$feature = $this->findFirst("id=$id");

		unset($arrayInput['id']);
		foreach ($arrayInput as $key => $value) {
			$feature->$key = $value;
		}

		return $feature->save();
	}

	public function deleteFeature($featureID, $op_uid) {
		$feature = $this->findFirst("id=$featureID");
		$feature->deleted = intval(1);
		$feature->op_uid = intval($op_uid);
		$feature->op_time = time();

		return $feature->save();
	}

	public $project_id;
	public $deleted;
	public $sort;
	public $content;
	public $create_time;
	public $create_uid;
	public $op_time;
	public $op_uid;
}