<?php

declare(strict_types=1);

namespace App\System\Queue\Producer;

use Hyperf\Amqp\Annotation\Producer;
use Hyperf\Amqp\Message\ProducerMessage;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * 后台内部消息队列生产处理.
 */
// #[Producer(exchange: "mineadmin", routingKey: "message.routing")]
class MessageProducer extends ProducerMessage
{
    /**
     * @param mixed $data
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct($data)
    {
        console()->info(
            sprintf(
                'created queue message time at: %s, data is: %s',
                date('Y-m-d H:i:s'),
                (is_array($data) || is_object($data)) ? json_encode($data) : $data,
            ),
        );

        $this->payload = $data;
    }
}
