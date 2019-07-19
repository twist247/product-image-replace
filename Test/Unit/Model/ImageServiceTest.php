<?php

namespace AT\ImageReplace\Test\Unit\Model;

use AT\ImageReplace\Model\ImageService;
use PHPUnit\Framework\TestCase;

class ImageService extends TestCase
{
    /**
     * @var Inchoo\Testing\TestingClass\SampleClass
     */
    protected $sampleClass;

    /**
     * @var string
     */
    protected $expectedMessage;

    public function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->sampleClass = $objectManager->getObject('Inchoo\Testing\TestingClass\SampleClass');
        $this->expectedMessage = 'Hello, this is sample test';
    }

    public function testGetMessage()
    {
        $this->assertEquals($this->expectedMessage, $this->sampleClass->getMessage());
    }
}