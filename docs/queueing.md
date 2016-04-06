
![](2277644988_c17dc49e8d_b.jpg)
# [fit] Queueing

### [fit]and the QPush Bundle

---

# PubSub Message Queue

![inline](queue pub sub.png)

---

![](5997668107_0b139b80cf_b.jpg)

# PubSub MQ Benefits

- Jobs can be non-blocking, improving performance
- Architectural separation of concerns
- Works well with observer pattern/events
- Programming language agnostic
- Pubs/Subs/Queues can be scaled independently

---

![](2D2960A700000578-3263440-image-a-21_1444219471545.jpg)

# Example use cases for MQ

- Report generation
- Sending Emails
- Fetching data from third-party APIs
- Anything intensive (and asynchronous)

---

![](2548214235_60f9d0e7b1_o.jpg)

# MQ Considerations

- Redundancy
- Message retries
- Message priority
- Speed
- Ordering
- Delivery confirmation

---

# MQ Considerations

- Security
- Platform stability/compatibility
- Community support
- Extra technology to install, maintain and learn
- Licence/usage cost

---

# MQ Solutions

### Self hosted

- Active MQ
- RabbitMQ
- Beanstalk

---

# MQ Solutions

### Cloud Hosted
- IronMQ
- Amazon SQS
- WebSphereMQ
- Cloud AMQP
- RackSpace

---

# QPush Bundle with IronMQ

- Easy to use and integrate with Symfony
- Already in use on the project

---

# QPush Offers an abstraction layer on top of several queues

- AWS SNS
- IronMQ
- Sync
- File
- Custom

---

# QPush Instalation

Require the package

`$ composer require uecode/qpush`

---

# QPush Instalation

Register the bundle

```php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Uecode\Bundle\QPushBundle\UecodeQPushBundle(),
    );

    return $bundles;
}
```

---

# QPush Config

```
# app/config/config.yml
uecode_qpush:
    providers:
        ironmq:
            driver:     ironmq
            token:      AbCdEfGhIjKlMnOp
            project_id: 12345678901234567890
            host:       mq-aws-eu-west-1-1
    queues:
        my_queue:
            provider: ironmq
            options:
                push_notifications: false
                messages_to_receive: 3
                message_expiration: 300
        ...
```

---

# Creating a queue

`$ bin/console uecode:qpush:build`


---

# Publishing a message

### The manual way:

```
$ bin/console uecode:qpush:publish my_queue \
'{"userId": 123, "emailType": "welcome_email"}'
```

---

# Publishing a message

```php
class MyController
{
	/** @var ProviderInterface */
    private $queue;

    public function action()
    {
    	$message = ['userId' => 456, 'emailType' => 'welcome_email'];

        $this->queue->publish($message);
    }
}
```

---

# Publishing a message

```xml
<!-- services.xml -->
<?xml version="1.0" ?>
<container >
    <services>
        <service id="my_app.my_controller" class="MyController">
            <argument type="service" id="uecode_qpush.my_queue" />
        </service>
        <!-- other services -->
    </services>
</container>
```

---

# Consuming a message

### The manual way:

```
$ bin/console uecode:qpush:receive my_queue
```

---

# Consuming a message

### Or with Symfony as a subscriber:

```
# app/config/config.yml
uecode_qpush:
    queues:
        my_queue:
            provider: ironmq
            options:
                push_notifications: true
			    subscribers:
			        - { endpoint: 'https://example.com/qpush?token=%authentication_token%', protocol: https }
```

---

# Consuming a message

```php
class MessageConsumer
{
    private $emailService;

    public function sendEmail(MessageEvent $messageEvent)
    {
        $body = $messageEvent->getMessage()->getBody();

        $userId = $body['userId'];
        $emailType = $body['emailType'];

        $this->emailService->sendEmailToUser($userId, $emailType);
    }
}
```

---

# Tagging a service

```xml
<!-- services.xml -->
<?xml version="1.0" ?>
<container >
    <services>
        <service id="my_app.message_consumer" class="MessageConsumer">
            <tag name="uecode_qpush.event_listener"
            	 event="my_queue.message_received"
            	 method="sendEmail" />
        </service>
        <!-- other services -->
    </services>
</container>
```

---

# Options

```
- queue_name
- push_notifications
- notification_retries
- message_delay
- message_timeout
- message_expiration
- messages_to_receive
- receive_wait_time
- subscribers
- logging_enabled
- cache_service
```

---

# Testing With Behat

- Integration tests - just one or two that actually touch the api.
- For the rest you can use an in-memory simulated queue.

---

![](3947612657_35db34783e_b.jpg)

# Issues
	
- Qpush bundle clients are not kept up to date.
- Docs aren't always clear.
- Some questionable code, constructor in interface.
- Tests aren't catching errors.

---

# Thanks

---

### images credits

```
- people outside st pancras phttps://www.flickr.com/photos/bensutherland/5279672999/in/photolist-7oPNZu-93xGve-93xGjg-93xGL4-93xGQP-6E5KC-93ubS1-93AMZS-93pCCk-93rb5P-y2iasM-9FHkAG-cw9FXf-Ng512-c12GAy-7uZqkt-MDGds-9PWpdP-4QVKQE-5d8c49-c2Qvns-4LALkJ-58wkwV-btLZ1U-7p17wR-8E5qdo-i9KQkn-bJduug-7ZG4HN-6E8Ka9-3SNiC-7ZCTnR-7ZG4SS-qZraFi-8A6bBh-55s5TD-2uphTE-2Mt5rm-3ZVFc-2ujTCk-2MoAuz-2ujP7K-2up5Mo-bCeojV-2ujMPk-7ZG4Qu-2ujHNZ-7ZG4NA-2ujKjt-D1Esk/
- sheep queue https://www.flickr.com/photos/_dinu/2548214235/in/photolist-5Bxcu1-4Tbgjc-9NJybd-9NFVNX-o8pnDV-fVpQag-pKJNAr-fVq3fM-pKFDiB-n6H3q4-q36PUi-7QTtae-DntCis-D5WetA-fVqafi-Dx3MUV-CYy9Cc-q2CD6i-rTiGwr-asMbjt-9KA6XB-8ppZo1-5SgRvB
- m25 traffic jam https://www.flickr.com/photos/timo_w2s/2277644988/in/photolist-6yFAP6-ZEgJ2-6rSfDE-4tgwvb-952AR1-a9Tj1v-a8Z5zW-a8Wfyg-4w2ak7-4w2a9f-8QwkYk-awSHGp-a8Zfv5-7Vjomu-a9YJ2Q-a9ksZc-aadraU-im7X5-oBiuP-Tx1VU-8EaVN7-62oE6A-hmDr1-7RdFHm-brApPC-zZqQnJ-8XVD3J-5t5Gz9-938Svw-8x2mPv-im7Mi-8x5kpQ-im89w-4iwnkq
- m25 fast https://www.flickr.com/photos/highwaysagency/5997668107/in/photolist-a9YSY5-aBzt6c-a9YSG9-a9YTvQ-a9XvPL-a8Zyo8-6XTjHE-5PLv1T-5PQKkJ-a8KXv3-76VPsi-3aRAZb-a9UMPP-a8ZBLP-a8Wsxx-a9UKaF-6XPinV-EANm4
- many laned motorway http://www.dailymail.co.uk/news/peoplesdaily/article-3263440/Thousands-motorists-stranded-Beijing-motorway-incredible-50-lane-traffic-jam-week-long-national-holiday-wraps-up.html
- f1 crash https://www.flickr.com/photos/mypoorbrain/3947612657/in/photolist-iYF3j4-iKrUr5-iQPw4e-9NGKrb-kuysnP-9NFVNX-g4P8w-9NEwpU-9NBBMn-9NKJWL-9NH11D-m4tfVT-9NGabs-9Nv8dj-9NDZCz-m49Ut8-qJTbkF-m4Xihc-m48Gf2-m4Zgt7-9NJKMw-9NC5eF-awz4sm-cWEfrY-5YaAW3-dkpYrM-apYmmR-78aKP8-4jFvvK-utP7qK-eaR4uc-9YvRMT-eZKSBS-artHwi-atuLRf-arwmmL-artHtp-oHEyeN-6bvgA2-arwmaW-71QwMz-71QxHc-hjerpQ-4VwB3w-7FUSFJ-4yMRGS-a9j5dP/
```