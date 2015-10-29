<?php
namespace Phossa\Logger;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-10-29 at 06:12:48.
 */
class LogEntryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LogEntry
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new LogEntry(LogLevel::ERROR, 'test error');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Phossa\Logger\LogEntry::setMessage
     */
    public function testSetMessage()
    {
        $this->object->setMessage('wow');
        $this->assertEquals('wow', $this->object->getMessage());
    }

    /**
     * @covers Phossa\Logger\LogEntry::getMessage
     */
    public function testGetMessage()
    {
        $this->assertEquals('test error', $this->object->getMessage());
    }

    /**
     * @covers Phossa\Logger\LogEntry::setLevel
     */
    public function testSetLevel()
    {
        $this->object->setLevel(LogLevel::WARNING);
        $this->assertEquals(LogLevel::WARNING, $this->object->getLevel());
    }

    /**
     * @covers Phossa\Logger\LogEntry::getLevel
     */
    public function testGetLevel()
    {
        $this->assertEquals(LogLevel::ERROR, $this->object->getLevel());
    }

    /**
     * @covers Phossa\Logger\LogEntry::setTimestamp
     */
    public function testSetTimestamp()
    {
        $this->object->setTimestamp(10);
        $this->assertEquals(10, $this->object->getTimestamp());
    }

    /**
     * @covers Phossa\Logger\LogEntry::setContexts
     */
    public function testSetContexts()
    {
        $con = [
            'bingo' => 'bingo',
            'wow'   => 'wow'
        ];
        $this->object->setContexts($con);
        $this->assertEquals($con, $this->object->getContexts());
    }

    /**
     * @covers Phossa\Logger\LogEntry::getContexts
     */
    public function testGetContexts()
    {
        $this->assertEquals([], $this->object->getContexts());
    }

    /**
     * @covers Phossa\Logger\LogEntry::mergeContexts
     */
    public function testMergeContexts()
    {
        $con1 = ['bingo' => 'bingo'];
        $con2 = ['wow'   => 'wow'];
        $this->object->mergeContexts($con1);
        $this->assertEquals($con1, $this->object->getContexts());
        $this->object->mergeContexts($con2);
        $this->assertEquals(
            ['bingo' => 'bingo', 'wow' => 'wow'],
            $this->object->getContexts()
        );
    }

    /**
     * @covers Phossa\Logger\LogEntry::setContext
     */
    public function testSetContext()
    {
        $this->object->setContext('wow', 'wow2');
        $this->assertEquals('wow2', $this->object->getContext('wow'));
        $this->assertEquals(null, $this->object->getContext('notfind'));
    }

    /**
     * @covers Phossa\Logger\LogEntry::setFormatted
     * @todo   Implement testSetFormatted().
     */
    public function testSetFormatted()
    {
        $this->object->setFormatted('bingo');
        $this->assertEquals('bingo', $this->object->getFormatted());
    }

    /**
     * @covers Phossa\Logger\LogEntry::getFormatted
     */
    public function testGetFormatted()
    {
        $this->assertEquals(null, $this->object->getFormatted());
        $this->object->setFormatted('bingo');
        $this->assertEquals('bingo', $this->object->getFormatted());
    }

    /**
     * @covers Phossa\Logger\LogEntry::stopCascading
     */
    public function testStopCascading()
    {
        $this->assertEquals(false, $this->object->isCascadingStopped());
        $this->object->stopCascading();
        $this->assertEquals(true, $this->object->isCascadingStopped());
        $this->object->stopCascading(false);
        $this->assertEquals(false, $this->object->isCascadingStopped());
    }

    /**
     * @covers Phossa\Logger\LogEntry::isCascadingStopped
     */
    public function testIsCascadingStopped()
    {
        $this->assertEquals(false, $this->object->isCascadingStopped());
    }

    /**
     * @covers Phossa\Logger\LogEntry::__toString
     */
    public function testToString()
    {
        $line = (string) $this->object;
        $this->assertContains('test error', $line);
    }
}
