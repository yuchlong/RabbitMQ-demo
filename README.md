# PHP code for RabbitMQ tutorials

Here you can find PHP code examples from [RabbitMQ
tutorials](https://www.rabbitmq.com/getstarted.html).

To successfully use the examples you will need a running RabbitMQ server.

## Requirements

### PHP 7.0+

You need `PHP 7.0` and `php-amqplib`. To get these
dependencies on Ubuntu type:

    sudo apt-get install git-core php5-cli


### Composer

Then [install Composer](https://getcomposer.org/download/) per instructions on their site.


### Client Library

Then you can install `php-amqplib` using [Composer](https://getcomposer.org).

To do that install Composer and add it to your path, then run the following command
inside this project folder:

    composer.phar install
    
Or you can require it to the existing project using a command:

    composer.phar require php-amqplib/php-amqplib

## Code

[Tutorial one: "Hello World!"](https://www.rabbitmq.com/tutorials/tutorial-one-php.html):

    php send.php
    php receive.php


[Tutorial two: Work Queues](https://www.rabbitmq.com/tutorials/tutorial-two-php.html):

    php sendwork.php
    php receivework.php


[Tutorial three: Publish/Subscribe](https://www.rabbitmq.com/tutorials/tutorial-three-php.html)

    php sendfanoutlogs.php
    php receivefanoutlogs.php

[Tutorial four: Routing](https://www.rabbitmq.com/tutorials/tutorial-four-php.html):

    php senddirectmsg.php
    php receivedirectmsg.php


[Tutorial five: Topics](https://www.rabbitmq.com/tutorials/tutorial-five-php.html):

    php sendtopicmsg.php"
    php receivetopicmsg.php
    php receivetopicmsg2.php

[Tutorial six: RPC](https://www.rabbitmq.com/tutorials/tutorial-six-php.html):

    php rpc_server.php
    php rpc_client.php
