<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-11-28 21:21:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-29 17:43:19
 */

include '../vendor/autoload.php';

use diandi\connection\ConnectionPool;
use diandi\connection\Connectors\CoroutineMySQLConnector;
use Swoole\Coroutine\MySQL;

go(function () {
    // All MySQL connections: [10, 30]
    $pool = new ConnectionPool(
        [
            'minActive'         => 10,
            'maxActive'         => 30,
            'maxWaitTime'       => 5,
            'maxIdleTime'       => 20,
            'idleCheckInterval' => 10,
        ],
        new CoroutineMySQLConnector,
        [
            'host'        => '127.0.0.1',
            'port'        => '3306',
            'user'        => 'root',
            'password'    => 'xy123456',
            'database'    => 'mysql',
            'timeout'     => 10,
            'charset'     => 'utf8mb4',
            'strict_type' => true,
            'fetch_mode'  => true,
        ]
    );
    echo "Initializing connection pool\n";
    $pool->init();
    defer(function () use ($pool) {
        echo "Closing connection pool\n";
        $pool->close();
    });

    echo "Borrowing the connection from pool\n";
    /**@var MySQL $connection */
    $connection = $pool->borrow();

    $status = $connection->query('SHOW STATUS LIKE "Threads_connected"');

    echo "Return the connection to pool as soon as possible\n";
    $pool->return($connection);

    var_dump($status);
});
