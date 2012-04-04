<?php

/*
 * Created on 2011-3-1
 *
 * @author yijian.cen
 *
 */

class System_Db_Adapter_Amqp {

    protected $_conn;
    protected $_channel;
    protected $_exchange;
    protected $_queue;
    protected $_routingKey;

    public function connect($amqp_host, $amqp_port, $amqp_user, $amqp_pwd, $amqp_vhost) {
        $this->conn = new AMQPConnection(array('host' => $amqp_host, 'port' => $amqp_port, 'login' => $amqp_user, 'password' => $amqp_pwd, 'vhost' => $amqp_vhost));
        if (!$this->conn->connect()) {
            throw new Exception('Cannot connect to the amqp');
        }
        $this->_channel = new AMQPChannel($this->conn);
        $this->_exchange = new AMQPExchange($this->_channel);
        $this->_queue = new AMQPQueue($this->_channel);
        return $this;
    }

    public function setRules($exchange, $queue, $routingKey='default') {
        $this->_routingKey=$routingKey;
        //exchange
        $this->_exchange->setName($exchange);
        $this->_exchange->setType(AMQP_EX_TYPE_DIRECT);
        $this->_exchange->setFlags(AMQP_DURABLE);
        $this->_exchange->declare();
        //queue
        $this->_queue->setName($queue);
        $this->_queue->setFlags(AMQP_DURABLE);
        $this->_queue->declare();
        $this->_queue->bind($exchange, $this->_routingKey);
    }

    public function publish($message) {
        $this->_channel->startTransaction();
        $this->_exchange->publish($message, $this->_routingKey); //将你的消息通过制定routingKey发送
        $this->_channel->commitTransaction();
        $this->conn->disconnect();
    }

}

?>