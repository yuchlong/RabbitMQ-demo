<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    // 建立连接
    $connection = new AMQPStreamConnection('106.13.37.242',  5672, 'guest', 'guest','type1');
    // 创建信息通道
    $channel = $connection->channel();

    $channel->queue_declare('top1', false, true, false, false);
    echo " [*] Waiting for messages. To exit press CTRL+C\n";

    //回调逻辑处理函数,一般自己业务在这里写
    $callback = function ($msg) {
        echo ' [x] Received ', $msg->body, "\n";
        $msg->ack();
        //$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);// 手动确认ack，确保消息已经处理
    };
    /**
     * queue: hello               // 被消费的队列名称
     * consumer_tag: consumer_tag // 消费者客户端身份标识，用于区分多个客户端
     * no_local: false            // 这个功能属于AMQP的标准，但是RabbitMQ并没有做实现
     * no_ack: true               // 收到消息后，是否不需要回复确认即被认为被消费
     * exclusive: false           // 是否排他，即这个队列只能由一个消费者消费。适用于任务不允许进行并发处理的情况下
     * nowait: false              // 不返回执行结果，但是如果排他开启的话，则必须需要等待结果的，如果两个一起开就会报错
     * callback: $callback        // 回调逻辑处理函数
     */
    // 第四个参数basic_consume为false (true 意味着不响应ack)；消费者挂掉这后，所有没有响应的消息都会重新发送，减小消息丢失的概率，改为false后，则是手动确认，默认是自动确认
    $channel->basic_consume('top1', '', false, false, false, false, $callback); 
    while ($channel->is_open()) {
        $channel->wait();
    }
    $channel->close();
    $connection->close();
?>
