<?php

/**
 * 基础控制器类
 */
class Controller {
	/**
	 * 初始化文件编码
	 */
	protected function initCode() {
		header("Content-type:text/html;Charset=utf-8");
	}
	/**
	 * 构造方法
	 */
	public function __construct() {
		$this->initCode();
	}
}