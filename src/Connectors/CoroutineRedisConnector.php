<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-11-28 21:21:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-29 18:01:24
 */


namespace diandi\connection\Connectors;

use Swoole\Coroutine\Redis;

class CoroutineRedisConnector implements ConnectorInterface
{
    public function connect(array $config)
    {
        $connection = new Redis($config['options'] ?? []);
        $ret = $connection->connect($config['host'], $config['port']);
        if ($ret === false) {
            throw new \RuntimeException(sprintf('Failed to connect Redis server: [%s] %s', $connection->errCode, $connection->errMsg));
        }
        if (isset($config['password'])) {
            $config['password'] = (string)$config['password'];
            if ($config['password'] !== '') {
                $connection->auth($config['password']);
            }
        }
        if (isset($config['database'])) {
            $connection->select($config['database']);
        }
        return $connection;
    }

    public function disconnect($connection)
    {
        /**@var Redis $connection */
        $connection->close();
    }

    public function isConnected($connection): bool
    {
        /**@var Redis $connection */
        return $connection->connected;
    }

    public function reset($connection, array $config)
    {
        /**@var Redis $connection */
        $connection->setDefer(false);
        if (isset($config['database'])) {
            $connection->select($config['database']);
        }
    }

    public function validate($connection): bool
    {
        return $connection instanceof Redis;
    }
}