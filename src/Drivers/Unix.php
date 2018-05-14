<?php

namespace mozartk\ProcessFinder\Drivers;

use mozartk\ProcessFinder\Process as Process2;
use Symfony\Component\Process\Process;

class Unix implements DriversInterface {
    /**
     * @return \mozartk\ProcessFinder\Process[]
     */
    function getAllProcesses () {
        $process = new Process('ps -eo pid,time,size,user,session,cmd');
        $process->run();
        $op = trim($process->getOutput());

        return $this->parse($op);
    }

    /**
     * @param $pid
     *
     * @return \mozartk\ProcessFinder\Process[]
     */
    function getProcessByPid ($pid) {
        $process = new Process("ps -p $pid -o pid,time,size,user,session,cmd");
        $process->run();
        $op = trim($process->getOutput());

        return $this->parse($op);
    }

    /**
     * @param $output
     *
     * @return \mozartk\ProcessFinder\Process[]
     */
    private function parse ($output) {
        $op = explode("\n", $output);

        $processes = [];
        foreach ($op as $k => $item) {
            if ($k < 1)
                continue;

            $item = explode(" ", $item);
            $line = [];
            foreach ($item as $i) {
                if ($i != '')
                    $line[] = $i;
            }
            $processName = implode(" ", array_slice($line, 5));
            $processes[] = new Process2($processName, $line[0], false, $line[4], $line[2] . ' KB', 'RUNNING', $line[3], $line[1], false);
        }

        return $processes;
    }
}