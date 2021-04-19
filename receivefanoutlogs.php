<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    // 建立连接
    $connection = new AMQPStreamConnection('106.13.37.242',  5672, 'guest', 'guest','type3');
    // 创建信息通道
    $channel = $connection->channel();
    /**
     * 创建交换机(Exchange)
     * name: vckai_exchange// 交换机名称
     * type: direct        // 交换机类型，分别为direct/fanout/topic，参考另外文章的Exchange Type说明。
     * passive: false      // 如果设置true存在则返回OK，否则就报错。设置false存在返回OK，不存在则自动创建
     * durable: false      // 是否持久化，设置false是存放到内存中的，RabbitMQ重启后会丢失
     * auto_delete: false  // 是否自动删除，当最后一个消费者断开连接之后队列是否自动被删除
     */
    $channel->exchange_declare('logs', 'fanout', false, false, false);

     // 定义队列，第一个参数为队列名称，为空则随机生成
    list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

    // 绑定消息交换机和队列
    $channel->queue_bind($queue_name, 'logs');

    echo " [*] Waiting for logs. To exit press CTRL+C\n";

    $callback = function ($msg) {
        echo ' [x] ', $msg->body, "\n";
    };

    $channel->basic_consume($queue_name, '', false, true, false, false, $callback);

    while ($channel->is_open()) {
        $channel->wait();
    }

    $channel->close();
    $connection->close();
