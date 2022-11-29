<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-11-28 21:21:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-29 18:00:41
 */


namespace diandi\connection;

interface ConnectionPoolInterface
{

    /**
     * Initialize the connection pool
     * @return bool
     */
    public function init(): bool;

    /**
     * Return a connection to the connection pool
     * @param mixed $connection
     * @return bool
     */
    public function return($connection): bool;

    /**
     * Borrow a connection to the connection pool
     * @return mixed
     * @throws BorrowConnectionTimeoutException
     */
    public function borrow();

    /**
     * Close the connection pool, release the resource of all connections
     * @return bool
     */
    public function close(): bool;
}