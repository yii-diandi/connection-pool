<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-11-28 21:21:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-29 18:01:30
 */


namespace diandi\connection\Connectors;

class PDOConnector implements ConnectorInterface
{
    public function connect(array $config)
    {
        try {
            $connection = new \PDO($config['dsn'], $config['username'] ?? '', $config['password'] ?? '', $config['options'] ?? []);
        } catch (\Throwable $e) {
            throw new \RuntimeException(sprintf('Failed to connect the requested database: [%d] %s', $e->getCode(), $e->getMessage()));
        }
        return $connection;
    }

    public function disconnect($connection)
    {
        /**@var \PDO $connection */
        $connection = null;
    }

    public function isConnected($connection): bool
    {
        /**@var \PDO $connection */
        try {
            return !!@$connection->getAttribute(\PDO::ATTR_SERVER_INFO);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function reset($connection, array $config)
    {

    }

    public function validate($connection): bool
    {
        return $connection instanceof \PDO;
    }
}