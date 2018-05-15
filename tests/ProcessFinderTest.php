<?php

namespace mozartk\ProcessChecker\Test;

use mozartk\ProcessFinder\ProcessFinder;
use Symfony\Component\Process\Process;
use PHPUnit\Framework\TestCase;

class ProcessCheckerTest extends TestCase
{


    /**
     * return Process instance with php result
     *
     * @return bool|\mozartk\ProcessFinder\Process
     */
    private function getPHPProcess()
    {
        $processFinder = new ProcessFinder();
        $process = $processFinder->getAllProcesses();

        $pattern = '/php/';
        $pid = "";

        foreach ($process as $p) {
            if (preg_match($pattern, $p->getName())) {
                return $p;
            }
        }

        return false;
    }

    public function testGetProcess()
    {
        $processFinder = new ProcessFinder();
        $p = $this->getPHPProcess();
        $pid = $p->getPid();

        $process = $processFinder->getProcess($pid);
        $this->assertEquals($pid, $process->getPid());
    }

    public function testSetPID()
    {
        $processFinder = new ProcessFinder();
        $p = $this->getPHPProcess();
        $pid = $p->getPid();

        $processFinder->setPid($pid);
        $process = $processFinder->getProcess($pid);
        $this->assertEquals($pid, $process->getPid());
    }

    public function testGetAllProcess()
    {
        $processFinder = new ProcessFinder();
        $allProcess = $processFinder->getAllProcesses();
        $cnt = count($allProcess);
        $name1 = trim($allProcess[0]->getName());
        $name2 = trim($allProcess[$cnt-1]->getName());

        $this->assertTrue(!empty($name1) && !empty($name2) && $cnt > 1);
    }

    public function testIsRunning()
    {
        $processFinder = new ProcessFinder();
        $process = $processFinder->getAllProcesses();

        $pattern = '/php/';
        $pid = "";

        foreach ($process as $p) {
            if (preg_match($pattern, $p->getName())) {
                $this->assertTrue($p->isRunning());
                break;
            }
        }
    }

    public function testIsNotRunning()
    {
        $processFinder = new ProcessFinder();
        $running = $processFinder->isRunning("99999999");

        $this->assertFalse($running);
    }

    /**
     *  hmm...???
     */
    public function testGetSessionName()
    {
        $p = $this->getPHPProcess();
        $this->assertContains($p->getSessionName(), array(false, strlen($p->getSessionName())>0));
    }

    public function testGetSession()
    {
        $p = $this->getPHPProcess();
        $this->assertTrue(is_numeric($p->getSession()));
    }

    public function testGetMemUsed()
    {
        $p = $this->getPHPProcess();
        $this->assertNotEmpty($p->getMemUsed());
    }

    public function testGetStatus()
    {
        $p = $this->getPHPProcess();
        $this->assertNotEmpty($p->getStatus());
    }

    public function testGetUsername()
    {
        $p = $this->getPHPProcess();
        $this->assertNotEmpty($p->getUsername());
    }

    public function testGetCputime()
    {
        $p = $this->getPHPProcess();
        $this->assertNotEmpty($p->getCputime());
    }

    public function testWindowsTitle()
    {
        $processFinder = new ProcessFinder();
        $p = $this->getPHPProcess();
        $title = $p->getWindowTitle();

        if(!stristr(PHP_OS, 'DAR') && stristr(PHP_OS, 'WIN')){
            $this->assertNotEmpty($title);
        } else {
            $this->assertEmpty($title);
        }
    }

    /**
     * @expectedException \mozartk\ProcessFinder\Exception\ProcessFinderException
     */
    public function testGetProcessWithoutPID()
    {
        $processFinder = new ProcessFinder();
        $processFinder->getProcess();
    }

    /**
     * @expectedException \mozartk\ProcessFinder\Exception\NotExistsDriversException
     */
    public function testNotExistOS()
    {
        $processFinder = new ProcessFinder();
        $ref = new \ReflectionClass(get_class($processFinder));
        $method = $ref->getMethod("loadDrivers");
        $method->setAccessible(true);
        $method->invokeArgs($processFinder, array("OsDoesNotExistIntheWorld"));
    }
}
