<?php

namespace csc545\lib;

use Iterator;
use IteratorIterator;
use MongoCursor;

class MongoObjectIterator implements Iterator
{
    /**
     * @var MongoCursor
     */
    private $cursor;

    /**
     * @var string
     */
    private $object_type;

    private function dataToObject($data)
    {
        $class_name = "csc545\\dbo\\" . $this->object_type;
        $instance = new $class_name();
        foreach ($data as $key => $val) {
            $instance->{$key} = $val;
        }
        return $instance;
    }

    public function __construct($cursor, $object_type)
    {
        $this->cursor = new IteratorIterator($cursor);
        $this->cursor->rewind();
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
        return $this->dataToObject($this->cursor->current());
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->cursor->next();
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->cursor->key();
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
        return $this->cursor->valid();
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->cursor->rewind();
    }
}