<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    use PhpAmqpLib\Message\AMQPMessage;
    // 建立连接
    $connection = new AMQPStreamConnection('106.13.37.242',  5672, 'guest', 'guest','type1');
    // 创建信息通道
    $channel = $connection->channel();
    /**
     * 创建队列(Queue)
     * name: hello         // 队列名称
     * passive: false      // 如果设置true存在则返回OK，否则就报错。设置false存在返回OK，不存在则自动创建
     * durable: true       // 是否持久化，设置false是存放到内存中的，RabbitMQ重启后会丢失
     * exclusive: false    // 是否排他，指定该选项为true则队列只对当前连接有效，连接断开后自动删除
     * auto_delete: false  // 是否自动删除，当最后一个消费者断开连接之后队列是否自动被删除
     */
    $channel->queue_declare('top1', false, true, false, false);
    /**
     * 创建AMQP消息类型
     * delivery_mode 消息是否持久化
     * AMQPMessage::DELIVERY_MODE_NON_PERSISTENT  不持久化
     * AMQPMessage::DELIVERY_MODE_PERSISTENT      持久化 
     */
    $msg = new AMQPMessage('你好，top1',array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
    $channel->basic_publish($msg, '', 'top1');

    echo " [x] Sent '你好，top1'\n";
    $channel->close();
    $connection->close();

?>
   

