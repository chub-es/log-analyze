Log Analyze
=================

Программа предоставляет временные интервалы, в которые доля отказов системы превышала указанную границу


Установка
------------

```bash
composer require 3b1t/log-analyze
```

Использование
-----------

```bash
cat access.log | php analyze.php -u 70 -t 99.9
```

Допустим, у вас есть файл журнала `access.log` со следующим содержимым:

```
192.168.32.181 - - [14/06/2017:16:47:02 +1000] "PUT /rest/v1.4/documents?zone=default&_rid=6076537c HTTP/1.1" 200 2 44.510983 "-" "@list-item-updater" prio:0
192.168.36.181 - - [14/06/2017:16:47:13 +1000] "PUT /rest/v1.4/documents?zone=default&_rid=6076537c HTTP/1.1" 500 2 45.510983 "-" "@list-item-updater" prio:0
192.168.33.181 - - [14/06/2017:16:47:25 +1000] "PUT /rest/v1.4/documents?zone=default&_rid=6076537c HTTP/1.1" 540 2 13.510983 "-" "@list-item-updater" prio:0
192.168.31.181 - - [14/06/2017:16:47:27 +1000] "PUT /rest/v1.4/documents?zone=default&_rid=6076537c HTTP/1.1" 200 2 46.510983 "-" "@list-item-updater" prio:0
192.168.32.141 - - [14/06/2017:16:47:32 +1000] "PUT /rest/v1.4/documents?zone=default&_rid=6076537c HTTP/1.1" 501 2 53.510983 "-" "@list-item-updater" prio:0
192.168.32.181 - - [14/06/2017:16:47:38 +1000] "PUT /rest/v1.4/documents?zone=default&_rid=6076537c HTTP/1.1" 200 2 44.510983 "-" "@list-item-updater" prio:0
192.168.36.181 - - [14/06/2017:16:47:41 +1000] "PUT /rest/v1.4/documents?zone=default&_rid=6076537c HTTP/1.1" 500 2 45.510983 "-" "@list-item-updater" prio:0
192.168.33.181 - - [14/06/2017:16:47:56 +1000] "PUT /rest/v1.4/documents?zone=default&_rid=6076537c HTTP/1.1" 540 2 13.510983 "-" "@list-item-updater" prio:0
```

Необходимо создать экземпляр объекта `Log` и в качестве параметра передать источник данных

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use \Analyze\Log;

$params = getopt('u:t:');

$analyze = new Log('php://stdin');
$analyze->setParams($params)
    ->Read()
    ->getList();
```

В приведенном выше примере будет выводиться:

```
16:47:25     16:47:27        75
16:47:27     16:47:32        80
16:47:38     16:47:41        71.4
16:47:41     16:47:56        75
```
