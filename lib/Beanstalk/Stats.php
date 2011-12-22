<?php
/* $Id$ */
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


class BeanstalkStats
{

    public function __construct($data = null)
    {
        if ($data !== null)
        {
            preg_match_all('/^(.+):\s+(.+)$/m', $data, $matches, PREG_SET_ORDER);
            foreach ($matches as $match)
            {
                $this->setStat($match[1], $match[2]);
            }
        }
    }

    protected $_stats;

    public function setStat($stat, $value)
    {
        $this->_stats[$stat] = $value;
    }

    public function getStat($stat)
    {
        if (isset($this->_stats[$stat]))
        {
            return $this->_stats[$stat];
        }
    }

}
