<?php
/* $Id$ */
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


/**
 * Implements the Beanstalk Protocol
 *
 * $bean = Beanstalk::init(); // returns BeanstalkPool instance
 * $bean->addServer('localhost', 11300);
 * $bean->use('my-tube');
 * $bean->put('Hello World!');
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 * @see https://github.com/kr/beanstalkd/blob/master/doc/protocol.txt
 */
class Beanstalk
{

    protected static $_pool;

    /**
     * Init the beanstalkd pool
     *
     * @return BeanstalkPool
     */
    public static function init()
    {
        if (self::$_pool instanceof BeanstalkPool === false)
        {
            self::$_pool = new BeanstalkPool();
        }

        return self::$_pool;
    }

    /**
     * Autoload beanstalk classes
     */
    public static function autoload($className)
    {
        if (strpos($className, 'Beanstalk') !== 0)
        {
            return false;
        }

        if (strpos($className, 'BeanstalkCommand') === 0 && ($className !== 'BeanstalkCommand'))
        {
            require dirname(__FILE__) . '/Beanstalk/Command/' . substr($className, 16) . '.php';
            return true;
        }

        // split on caps
        preg_match_all('/[A-Z][^A-Z]*/', $className, $matches);
        require dirname(__FILE__) . '/' . implode('/', $matches[0]) . '.php';
    }

}

spl_autoload_register(array('Beanstalk', 'autoload'));
