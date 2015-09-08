<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\ExceptionTest;

use PHPUnit_Framework_TestCase;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCodeAsStringDefaultsToUnknown()
    {
        $e = new \Beanstalk\Exception('error message');
        $this->assertEquals('Unknown', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeUNKNOWN()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::UNKNOWN);
        $this->assertEquals('Unknown', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeBURIED()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::BURIED);
        $this->assertEquals('Buried', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeNOT_FOUND()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::NOT_FOUND);
        $this->assertEquals('Not Found', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeEXPECTED_CRLF()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::EXPECTED_CRLF);
        $this->assertEquals('Expected CRLF', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeJOB_TOO_BIG()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::JOB_TOO_BIG);
        $this->assertEquals('Job Too Big', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeDEADLINE_SOON()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::DEADLINE_SOON);
        $this->assertEquals('Deadline Soon', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeTIMED_OUT()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::TIMED_OUT);
        $this->assertEquals('Timed Out', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeTUBE_NAME_TOO_LONG()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::TUBE_NAME_TOO_LONG);
        $this->assertEquals('Tube Name Too Long', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeNOT_IGNORED()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::NOT_IGNORED);
        $this->assertEquals('Not Ignored', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeOUT_OF_MEMORY()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::OUT_OF_MEMORY);
        $this->assertEquals('Out of Memory', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeINTERNAL_ERROR()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::INTERNAL_ERROR);
        $this->assertEquals('Internal Error', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeBAD_FORMAT()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::BAD_FORMAT);
        $this->assertEquals('Bad Format', $e->getCodeAsString());
    }

    public function testGetCodeAsStringForCodeUNKNOWN_COMMAND()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::UNKNOWN_COMMAND);
        $this->assertEquals('Unknown Command', $e->getCodeAsString());
    }

    public function testAppendsCodeAsStringToMessage()
    {
        $e = new \Beanstalk\Exception('error message', \Beanstalk\Exception::JOB_TOO_BIG);
        $this->assertEquals('Job Too Big: error message', $e->getMessage());

        $e = new \Beanstalk\Exception('another error message', \Beanstalk\Exception::EXPECTED_CRLF);
        $this->assertEquals('Expected CRLF: another error message', $e->getMessage());
    }

}
