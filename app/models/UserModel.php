<?php

namespace app\models;

class UserModel extends BaseModel
{
    /**
     * @param string $table
     * @param array $values
     * @return int
     */
    public function insert(string $table, array $values)
    {
        return $this->mysql()->table($table)->insertGetId($values);
    }

    /**
     * @param string $table
     * @param array $where
     * @return array
     */
    public function find(string $table, array $where)
    {
        return $this->mysql()->table($table)->where($where)->get()->toArray();
    }

    /**
     * @param string $table
     * @param int $id
     * @return mixed|static
     */
    public function findById(string $table, int $id)
    {
        return $this->mysql()->table($table)->find($id);
    }

    /**
     * @param string $table
     * @param array $where
     * @param array $values
     * @return int
     */
    public function update(string $table, array $where, array $values)
    {
        return $this->mysql()->table($table)->where($where)->update($values);
    }
}