A beanstalkd client for PHP 5.3+

[![Build Status](https://travis-ci.org/smarterwebdev/php-beanstalk.png?branch=master)](https://travis-ci.org/smarterwebdev/php-beanstalk)

## Quickstart

### As a Producer

```php
<?php
// returns BeanstalkPool instance
$bean = Beanstalk::init();
$bean->addServer('localhost', 11300);
$bean->use('my-tube');
$bean->put('Hello World!');
```

### As a Consumer

```php
<?php
$bean = Beanstalk::init();
$bean->addServer('localhost', 11300);
$bean->watch('my-tube');

while (true)
{
    try
    {
        $job = $bean->reserve($timeout = 10);

        /* process job ... */

        $job->delete();
    }
    catch (BeanstalkException $e)
    {
        switch ($e->getCode())
        {
            case BeanstalkException::TIMED_OUT:
                echo "Timed out waiting for a job.  Retrying in 1 second."
                sleep(1);
                continue;
                break;

            default:
                throw $e;
                break;
        }
    }
}
```

### Built in JSON support

#### Objects are automatically converted

```php
<?php
$bean = Beanstalk::init();
$bean->addServer('localhost', 11300);
$bean->use('my-tube');

$obj = new stdClass;
$obj->content = 'Hello World!';
$bean->put($obj); // stored in beanstalkd as '{"content":"Hello World!"}'

$bean->watch('my-tube');
$job = $bean->reserve();
print_r($job->getMessage());
```

    stdClass Object
    (
        [content] => Hello World!
    )

#### Send a custom JSON string

```php
<?php
$bean = Beanstalk::init();
$bean->addServer('localhost', 11300);
$bean->use('my-tube');
$bean->put('[123,456,789]');

$bean->watch('my-tube');
$job = $bean->reserve();
print_r($job->getMessage());
```

    Array
    (
        [0] => 123
        [1] => 456
        [2] => 789
    )
