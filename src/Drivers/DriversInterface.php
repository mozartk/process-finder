<?php

namespace mozartk\ProcessFinder\Drivers;

interface DriversInterface
{
    /**
     * @return \mozartk\ProcessFinder\Process[]
     */
    public function getAllProcesses();

    /**
     * @param $pid
     *
     * @return \mozartk\ProcessFinder\Process[]
     */
    public function getProcessByPid($pid);

    public function parse($result);
}
