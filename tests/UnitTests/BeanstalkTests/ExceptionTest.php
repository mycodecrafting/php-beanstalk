<?php
/* $Id$ */
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\ExceptionTest;

use \PHPUnit_Framework_TestCase;
use \BeanstalkException;

require_once 'PHPUnit/Autoload.php';

require_once dirname(__FILE__) . '/../../../lib/Beanstalk/Exception.php';

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCodeAsStringDefaultsToUnknown()
    {
        $e = new BeanstalkException('error message');
        $this->assertEquals('Unknown', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeUNKNOWN()
    {
        $e = new BeanstalkException('error message', BeanstalkException::UNKNOWN);
        $this->assertEquals('Unknown', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeBURIED()
    {
        $e = new BeanstalkException('error message', BeanstalkException::BURIED);
        $this->assertEquals('Buried', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeNOT_FOUND()
    {
        $e = new BeanstalkException('error message', BeanstalkException::NOT_FOUND);
        $this->assertEquals('Not Found', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeEXPECTED_CRLF()
    {
        $e = new BeanstalkException('error message', BeanstalkException::EXPECTED_CRLF);
        $this->assertEquals('Expected CRLF', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeJOB_TOO_BIG()
    {
        $e = new BeanstalkException('error message', BeanstalkException::JOB_TOO_BIG);
        $this->assertEquals('Job Too Big', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeDEADLINE_SOON()
    {
        $e = new BeanstalkException('error message', BeanstalkException::DEADLINE_SOON);
        $this->assertEquals('Deadline Soon', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeTIMED_OUT()
    {
        $e = new BeanstalkException('error message', BeanstalkException::TIMED_OUT);
        $this->assertEquals('Timed Out', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeTUBE_NAME_TOO_LONG()
    {
        $e = new BeanstalkException('error message', BeanstalkException::TUBE_NAME_TOO_LONG);
        $this->assertEquals('Tube Name Too Long', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeNOT_IGNORED()
    {
        $e = new BeanstalkException('error message', BeanstalkException::NOT_IGNORED);
        $this->assertEquals('Not Ignored', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeOUT_OF_MEMORY()
    {
        $e = new BeanstalkException('error message', BeanstalkException::OUT_OF_MEMORY);
        $this->assertEquals('Out of Memory', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeINTERNAL_ERROR()
    {
        $e = new BeanstalkException('error message', BeanstalkException::INTERNAL_ERROR);
        $this->assertEquals('Internal Error', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeBAD_FORMAT()
    {
        $e = new BeanstalkException('error message', BeanstalkException::BAD_FORMAT);
        $this->assertEquals('Bad Format', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeUNKNOWN_COMMAND()
    {
        $e = new BeanstalkException('error message', BeanstalkException::UNKNOWN_COMMAND);
        $this->assertEquals('Unknown Command', $e->getCodeAsString());
    }

    public function testAppendsCodeAsStringToMessage()
    {
        $e = new BeanstalkException('error message', BeanstalkException::JOB_TOO_BIG);
        $this->assertEquals('Job Too Big: error message', $e->getMessage());

        $e = new BeanstalkException('another error message', BeanstalkException::EXPECTED_CRLF);
        $this->assertEquals('Expected CRLF: another error message', $e->getMessage());
    }

    public function run(\PHPUnit_Framework_TestResult $result = NULL)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

}
