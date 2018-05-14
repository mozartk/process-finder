<?php

namespace mozartk\ProcessChecker\Test;

use mozartk\ProcessFinder\ProcessFinder;
use Symfony\Component\Process\Process;
use PHPUnit\Framework\TestCase;

class ProcessCheckerTest extends TestCase
{
    public function testGetProcess()
    {

        $processFinder = new ProcessFinder();
        $process = new Process('wait 5');
        $process->start();
        $pid = $process->getPid();

        $process = $processFinder->getProcess($pid);
        $this->assertEquals($pid, $process->getPid());
    }
}
