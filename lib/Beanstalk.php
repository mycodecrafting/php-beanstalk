<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
namespace Beanstalk;

/**
 * Implements the Beanstalk Protocol
 *
 * <code>
 * $bean = Beanstalk::init(); // returns BeanstalkPool instance
 * $bean->addServer('localhost', 11300);
 * $bean->useTube('my-tube');
 * $bean->put('Hello World!');
 * </code>
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
        if (self::$_pool instanceof Pool === false)
        {
            self::$_pool = new Pool();
        }

        return self::$_pool;
    }

}
