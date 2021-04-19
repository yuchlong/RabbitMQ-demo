<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    use PhpAmqpLib\Message\AMQPMessage;
    // 建立连接
    $connection = new AMQPStreamConnection('106.13.37.242',  5672, 'guest', 'guest','type4');
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
    $channel->exchange_declare('directlogs', 'direct', false, false, false);
    $argv=['A'=>'走路由消息A','B'=>'走路由消息B','C'=>'走路由消息C','D'=>'走路由消息D','E'=>'走路由消息E'];
    foreach($argv as $KEY=> $value){

        /**
         * 创建AMQP消息类型
         * delivery_mode 消息是否持久化
         * AMQPMessage::DELIVERY_MODE_NON_PERSISTENT  不持久化
         * AMQPMessage::DELIVERY_MODE_PERSISTENT      持久化 
         */
        $msg = new AMQPMessage($value);
        /**
         * 发送消息
         * msg: $msg       // AMQP消息内容
         * exchange: logs  // 交换机名称
         * queue: hello    // 队列名称
         */
        $channel->basic_publish($msg, 'directlogs', $KEY);
        echo ' [x] Sent ', $KEY, ':',$value, "\n";
    }
    $channel->close();
    $connection->close();
