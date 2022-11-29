<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-11-28 21:21:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-29 18:01:10
 */


namespace diandi\connection\Connectors;

use Swoole\Coroutine\MySQL;

class CoroutineMySQLConnector implements ConnectorInterface
{
    public function connect(array $config)
    {
        $connection = new MySQL();
        if ($connection->connect($config) === false) {
            throw new \RuntimeException(sprintf('Failed to connect MySQL server: [%d] %s', $connection->connect_errno, $connection->connect_error));
        }
        return $connection;
    }

    public function disconnect($connection)
    {
        /**@var MySQL $connection */
        $connection->close();
    }

    public function isConnected($connection): bool
    {
        /**@var MySQL $connection */
        return $connection->connected;
    }

    public function reset($connection, array $config)
    {

    }

    public function validate($connection): bool
    {
        return $connection instanceof MySQL;
    }
}