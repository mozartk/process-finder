<?php

namespace mozartk\ProcessFinder\Drivers;

use Symfony\Component\Process\Process;

abstract class AbstractDrivers
{
    public function runProcess($cmd)
    {
        $process = new Process($cmd);
        $process->run();
        return trim($process->getOutput());
    }

    public function getAllProcesses()
    {
        $result = $this->runProcess("ps -eo ".$this->options);

        return $this->parse($result);
    }

    public function getProcessByPid($pid)
    {
        $result = $this->runProcess("ps -p $pid -o ".$this->options);

        return $this->parse($result);
    }
}
