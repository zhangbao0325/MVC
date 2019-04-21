<?php

/**
 * php_student表的操作模型
 */
class UserModel extends Model
{
    private $table = 'xes_users';

    /**
     * 获得所有用户列表
     */
    public function getList()
    {
        // 获得学生列表数据
        $sql = "select * from $this->table ";
        return $this->dao->fetchAll($sql);
    }

    /**
     * 删除某个用户的记录
     */
    public function remove($id)
    {
        // 删除某个学生的记录
        $sql = "delete from $this->table where id=$id";
        return $this->dao->my_query($sql); // 返回布尔值
    }
}