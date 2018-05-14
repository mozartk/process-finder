<?php

namespace mozartk\ProcessFinder\Drivers;

interface DriversInterface {
    /**
     * @return \mozartk\ProcessFinder\Process[]
     */
    function getAllProcesses ();

    /**
     * @param $pid
     *
     * @return \mozartk\ProcessFinder\Process[]
     */
    function getProcessByPid ($pid);
}