<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-11-28 21:21:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-29 18:01:37
 */


namespace diandi\connection\Connectors;

class PhpRedisConnector implements ConnectorInterface
{
    public function connect(array $config)
    {
        $connection = new \Redis();
        $ret = $connection->connect($config['host'], $config['port'], $config['timeout'] ?? 10);
        if ($ret === false) {
            throw new \RuntimeException(sprintf('Failed to connect Redis server: %s', $connection->getLastError()));
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
        foreach ($config['options'] ?? [] as $key => $value) {
            $connection->setOption($key, $value);
        }
        return $connection;
    }

    public function disconnect($connection)
    {
        /**@var \Redis $connection */
        $connection->close();
    }

    public function isConnected($connection): bool
    {
        /**@var \Redis $connection */
        return $connection->isConnected();
    }

    public function reset($connection, array $config)
    {
        /**@var \Redis $connection */
        if (isset($config['database'])) {
            $connection->select($config['database']);
        }
    }

    public function validate($connection): bool
    {
        return $connection instanceof \Redis;
    }
}