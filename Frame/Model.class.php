<?php

/**
 * 基础模型类
 */
class Model
{
    // 定义用来存储dao对象的属性,要求可以在子类中被访问
    protected $dao;

    /**
     * 构造方法
     */
    public function __construct()
    {
        // 初始化dao
        $this->initDAO();
    }

    /**
     * 初始化dao
     */
    protected function initDAO()
    {
        // 初始化dao
        $config = array(
            "host" => "10.90.101.81",
            "port" => "8088",
            "user" => "root",
            "pass" => "123456",
            "dbname" => "gwadmin"
        );
        $this->dao = MySQLDB::getInstance($config);
    }

}