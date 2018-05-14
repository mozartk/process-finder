<?php

namespace mozartk\ProcessFinder;

use mozartk\ProcessFinder\Drivers\DriversInterface;
use mozartk\ProcessFinder\Drivers\MacOS;
use mozartk\ProcessFinder\Drivers\Unix;
use mozartk\ProcessFinder\Drivers\Windows;
use mozartk\ProcessFinder\Exception\ProcessFinderException;

class ProcessFinder {
    /**
     * @var string
     */
    public $operatingSystem;

    /**
     * @var DriversInterface
     */
    public $api;

    const systemMacOS = "MacOS";
    const systemWindows = "Win";
    const systemUnix = "Unix";

    /**
     * @var int
     */
    private $pid;

    /**
     * ProcessFinder constructor.
     *
     * @param $pid
     */
    public function __construct ($pid = null) {
        $this->pid = $pid;
        $this->operatingSystem = $this->getCurrentOS();

        switch($this->operatingSystem){
            case self::systemMacOS:
                $this->api = new MacOS();
                break;
            case self::systemWindows:
                $this->api = new Windows();
                break;
            case self::systemUnix:
                $this->api = new Unix();
                break;
        }

        return $this->api;
    }

    /**
     * @param $pid
     *
     * @return $this
     */
    public function setPid ($pid) {
        $this->pid = $pid;

        return $this;
    }

    /**
     * If the process exists will return the array
     * else if not found will return false.
     *
     * @param null $pid
     *
     * @return \mozartk\ProcessFinder\Process|boolean
     * @throws \mozartk\ProcessFinder\Exception\ProcessFinderException
     */
    public function getProcess ($pid = null) {
        if (is_null($pid))
            $pid = $this->pid;

        if (is_null($pid))
            throw new ProcessFinderException('Pid is required');

        $process = $this->api->getProcessByPid($pid);

        return count($process) ? $process[0] : false;
    }

    /**
     * Returns a list of processes in array.
     * if no processes were found will return empty array.
     *
     * @return \mozartk\ProcessFinder\Process[]
     */
    public function getAllProcesses () {
        return $this->api->getAllProcesses();
    }

    /**
     * @param null $pid
     *
     * @return bool
     */
    public function isRunning ($pid = null) {
        $process = $this->getProcess($pid);

        return !$process ? false : true;
    }

    /**
     * Returns a current OS systems string using uname.
     * You can find a list of uname strings :
     * https://en.wikipedia.org/wiki/Uname#Table_of_standard_uname_output
     *
     * @return string
     */
    private function getCurrentOS () {
        switch (true) {
            case stristr(PHP_OS, 'DAR'): return self::systemMacOS;
            case stristr(PHP_OS, 'WIN'): return self::systemWindows;
            default : return self::systemUnix;
        }
    }
}
