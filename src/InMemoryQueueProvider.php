<?php

use Doctrine\Common\Cache\Cache;
use Monolog\Logger;

class InMemoryQueueProvider
{
    /**
     * @var array
     */
    private $mq = [];

    /**
     * {@inheritdoc}
     */
    public function __construct($name, array $options, $client, Cache $cache, Logger $logger)
    {
        // why is this here?
    }

    /**
     * {@inheritdoc}
     */
    public function getProvider()
    {
        return 'InMemory';
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        // way ahead of you, it's just an array
    }

    /**
     * {@inheritdoc}
     */
    public function publish(array $message, array $options = [])
    {
        $this->mq[] = $message;
        end($this->mq);

        return key($this->mq);
    }

    /**
     * {@inheritdoc}
     */
    public function receive(array $options = [])
    {
        return $this->mq;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        if (array_key_exists($id, $this->mq)) {
            unset($this->mq[$id]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function destroy()
    {
        $this->mq = [];
    }
}
