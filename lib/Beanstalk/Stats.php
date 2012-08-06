<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


class BeanstalkStats
{

    protected $_stats = array();

    /**
     * Constructor
     *
     * @param string $data Set stats from input data in the form "stat-1: value\nstat-2: value"
     */
    public function __construct($data = null)
    {
        if ($data !== null)
        {
            preg_match_all('/^(.+):\s+(.+)$/m', $data, $matches, PREG_SET_ORDER);
            foreach ($matches as $match)
            {
                $this->setStat($match[1], trim($match[2]));
            }
        }
    }

    /**
     * Set a stat to a given value
     *
     * @param string $stat
     * @param string $value
     * @return void
     */
    public function setStat($stat, $value)
    {
        $this->_stats[$stat] = $value;
    }

    /**
     * Get the value of a given stat
     *
     * @param string $stat Stat name to get the value of
     * @return string Stat's value
     * @return boolean false when value not set
     */
    public function getStat($stat)
    {
        if (isset($this->_stats[$stat]))
        {
            return $this->_stats[$stat];
        }

        return false;
    }

    /**
     * Get all the stats as an array
     *
     * @return array ( 'stat1-name' => 'value' , 'stat2-name' => 'value' , ... )
     */
    public function getStats()
    {
        return $this->_stats;
    }

}
