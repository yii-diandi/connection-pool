<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-11-28 21:21:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-29 17:45:30
 */

include '../vendor/autoload.php';

use diandi\connection\ConnectionPool;
use diandi\connection\Connectors\CoroutinePostgreSQLConnector;
use Swoole\Coroutine\PostgreSQL;

go(function () {
    // All PostgreSQL connections: [10, 30]
    $pool = new ConnectionPool(
        [
            'minActive'         => 10,
            'maxActive'         => 30,
            'maxWaitTime'       => 5,
            'maxIdleTime'       => 20,
            'idleCheckInterval' => 10,
        ],
        new CoroutinePostgreSQLConnector,
        [
            'connection_strings' => 'host=127.0.0.1 port=5432 dbname=postgres user=postgres password=xy123456',
        ]
    );
    echo "Initializing connection pool\n";
    $pool->init();
    defer(function () use ($pool) {
        echo "Closing connection pool\n";
        $pool->close();
    });

    echo "Borrowing the connection from pool\n";
    /**@var PostgreSQL $connection */
    $connection = $pool->borrow();

    $result = $connection->query("SELECT * FROM pg_stat_database where datname='postgres';");

    $stat = $connection->fetchAssoc($result);
    echo "Return the connection to pool as soon as possible\n";
    $pool->return($connection);

    var_dump($stat);
});
