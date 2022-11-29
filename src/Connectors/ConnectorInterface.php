<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-11-28 21:21:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-29 18:01:04
 */


namespace diandi\connection\Connectors;

interface ConnectorInterface
{
    /**
     * Connect to the specified Server and returns the connection resource
     * @param array $config
     * @return mixed
     */
    public function connect(array $config);

    /**
     * Disconnect and free resources
     * @param mixed $connection
     * @return mixed
     */
    public function disconnect($connection);

    /**
     * Whether the connection is established
     * @param mixed $connection
     * @return bool
     */
    public function isConnected($connection): bool;

    /**
     * Reset the connection
     * @param mixed $connection
     * @param array $config
     * @return mixed
     */
    public function reset($connection, array $config);

    /**
     * Validate the connection
     *
     * @param mixed $connection
     * @return bool
     */
    public function validate($connection): bool;
}