<?php

namespace csc545\lib;

use Iterator;
use PDO;
use PDOStatement;

class MySQLObjectIterator implements Iterator
{
    /**
     * @var PDOStatement
     */
    private $cursor;

    /**
     * @var string
     */
    private $object_type;

    private $key = false;

    private $result = null;

    private $valid = true;

    private function dataToObject($data = array())
    {
        $class_name = "csc545\\dbo\\" . $this->object_type;
        $instance = new $class_name();
        foreach ($data as $key => $val) {
            $instance->{$key} = $val;
        }
        return $instance;
    }

    public function __construct(PDOStatement $cursor, $object_type)
    {
        $this->cursor = $cursor;
        $this->object_type = $object_type;
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        if($this->key == false){
            $this->next();
        }
        return $this->result != false ? $this->dataToObject($this->result) : $this->result;
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->key++;
        $this->result = $this->cursor->fetch(
            PDO::FETCH_ASSOC,
            PDO::FETCH_ORI_ABS,
            $this->key
        );
        if (false === $this->result) {
            $this->valid = false;
            return null;
        }
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->valid;
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->key = 0;
    }
}