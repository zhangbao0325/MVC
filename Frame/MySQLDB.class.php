<?php

/**
 * MySQLDB工具类
 */
class MySQLDB
{
    /**
     * 定义相关的属性
     */
    private $host; // 主机地址
    private $port; // 端口号
    private $user; // 用户名
    private $pass; // 密码
    private $charset; // 字符集
    private $dbname; // 数据库名
    // 运行的时候需要的属性
    private static $instance; // 用于保存对象
    private $pdo;  //保存连接资源类

    /**
     * 构造方法
     */
    private function __construct($arr)
    {
        echo "it is mysql";
        // 初始化属性的值
        $this->init($arr);
        // 连接数据库
        $this->my_connect();
        // 选择默认字符集
        $this->my_charset();
        // 选择默认数据库
        $this->my_dbname();
    }

    /**
     * 获得单例对象的公开的静态方法
     * @param array $arr 需要传递给构造方法的参数
     */
    public static function getInstance($arr)
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($arr);
        }
        return self::$instance;
    }

    /**
     * 初始化属性的值
     */
    private function init($arr)
    {
        $this->host = isset($arr['host']) ? $arr['host'] : '127.0.0.1';
        $this->port = isset($arr['port']) ? $arr['port'] : '3306';
        $this->user = isset($arr['user']) ? $arr['user'] : 'root';
        $this->pass = isset($arr['pass']) ? $arr['pass'] : '';
        $this->charset = isset($arr['charset']) ? $arr['charset'] : 'utf8';
        $this->dbname = isset($arr['dbname']) ? $arr['dbname'] : '';
    }


    /**
     * 通过pdo方式连接数据库
     */
    private function my_connect()
    {
        try {
            $pdo = new PDO("mysql:host=" . $this->host . ":" . $this->port . ";dbname=" . $this->dbname, $this->user, $this->pass);//创建一个pdo对象
            $this->pdo = $pdo;
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }

    }

    /**
     * 错误调试方法,执行一条sql语句
     */
    public function my_query($sql)
    {
        $result = $this->pdo->query($sql);
        if (!$result) {
            // 执行失败
            echo "SQL语句执行失败！<br />";
            echo "错误编号：", mysql_errno(), "<br />";
            echo "错误信息：", mysql_error(), '<br />';
            return false;
        }
        return $result;
    }

    /**
     * 返回多行多列的查询结果
     * @param string $sql 一条sql语句
     * @return mixed array|false
     */
    public function fetchAll($sql)
    {
        // 先执行sql语句
        if ($result = $this->my_query($sql)) {
            // 执行成功
            // 遍历资源结果集
            $rows = array();
            foreach ($result as $row) {
                $rows[]=$row;
            }
            
            // 返回所有的数据
            return $rows;
        } else {
            return false;
        }
    }

    /**
     * 返回一行多列的查询结果
     * @param string $sql 一条sql语句
     * @return mixed array|false
     */
    public function fetchRow($sql)
    {
        // 先执行sql语句
        if ($result = $this->my_query($sql)) {
            // 执行成功
            $row = mysql_fetch_assoc($result);
            mysql_free_result($result);
            // 返回这一条记录的数据
            return $row;
        } else {
            return false;
        }
    }

    /**
     * 返回单行单列的查询结果(单一值)
     * @param string $sql 一条sql语句
     * @return mixed string|false
     */
    public function fetchColumn($sql)
    {
        // 先执行sql语句
        if ($result = $this->my_query($sql)) {
            // 执行成功
            $row = mysql_fetch_row($result);
            // 释放结果集资源
            mysql_free_result($result);
            // 返回这个单一值
            return isset($row[0]) ? $row[0] : false;
        } else {
            // 执行失败
            return false;
        }
    }

    /**
     * 选择默认的字符集
     */
    private function my_charset()
    {
        $sql = "set names $this->charset";
        $this->pdo->exec($sql);
    }

    /**
     * 选择默认的数据库
     */
    private function my_dbname()
    {
        $sql = "use $this->dbname";
        $this->pdo->exec($sql);
    }

    /**
     * 析构方法
     */
    public function __destruct()
    {
        // 释放额外的数据库连接资源
        $this->pdo = null;//关闭连接
    }

    /**
     * __sleep方法,序列化对象的时候自动调用
     */
    public function __sleep()
    {
        // 返回一个数组,数组内的元素为需要被序列化的属性名的集合
        return array('host', 'port', 'user', 'pass', 'charset', 'dbname');
    }

    /**
     * __wakeup方法,反序列化一个对象的时候自动调用
     */
    public function __wakeup()
    {
        // 数据库的相关初始化操作
        // 连接数据库
        $this->my_connect();
        // 选择默认字符集
        $this->my_charset();
        // 选择默认数据库
        $this->my_dbname();
    }

    /**
     * 私有化克隆魔术方法,防止通过克隆得到新对象
     */
    private function __clone()
    {

    }

    public function __set($name, $value)
    {

    }

    public function __get($name)
    {

    }

    public function __unset($name)
    {
        // 什么都不做,表示不能删除任何属性
    }

    public function __isset($name)
    {

    }
}