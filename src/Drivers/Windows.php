<?php

namespace mozartk\ProcessFinder\Drivers;

use mozartk\ProcessFinder\Exception\ProcessFinderException;
use mozartk\ProcessFinder\Process as Process2;
use Symfony\Component\Process\Process;

class Windows extends AbstractDrivers implements DriversInterface
{
    protected $options = " /V";

    public function getProcessByPid($pid)
    {
        $command = "tasklist /V /fi \"pid eq $pid\"";
        $result = $this->runProcess($command);

        return $this->parse($result);
    }

    public function parse($output)
    {
        $op = explode("\n", $output);
        if (count($op) == 1) {
            return array();
        }
        $sessions = explode(" ", $op[1]);
        $cs = array();
        foreach ($sessions as $session) {
            $cs[] = mb_strlen($session);
        }
        $processes = array();

        foreach ($op as $k => $o) {
            if ($k < 2) {
                continue;
            }

            $p = array(
                'name'         => trim(mb_substr($o, 0, $cs[0] + 1)),
                'pid'          => trim(mb_substr($o, $cs[0] + 1, $cs[1] + 1)),
                'session_name' => trim(mb_substr($o, $cs[0] + $cs[1] + 2, $cs[2] + 1)),
                'session'      => trim(mb_substr($o, $cs[0] + $cs[1] + $cs[2] + 3, $cs[3] + 1)),
                'mem_used'     => trim(mb_substr($o, $cs[0] + $cs[1] + $cs[2] + $cs[3] + 4, $cs[4] + 1)),
                'status'       => trim(mb_substr($o, $cs[0] + $cs[1] + $cs[2] + $cs[3] + $cs[4] + 5, $cs[5] + 1)),
                'username'     => trim(mb_substr($o, $cs[0] + $cs[1] + $cs[2] + $cs[3] + $cs[4] + $cs[5] + 6, $cs[6] + 1)),
                'cpu_time'     => trim(mb_substr($o, $cs[0] + $cs[1] + $cs[2] + $cs[3] + $cs[4] + $cs[5] + $cs[6] + 7, $cs[7] + 1)),
                'window_title' => trim(mb_substr($o, $cs[0] + $cs[1] + $cs[2] + $cs[3] + $cs[4] + $cs[5] + $cs[6] + $cs[7] + 8, $cs[8] + 1)),
            );

            $processes[] = new Process2(
                $p['name'],
                $p['pid'],
                $p['session_name'],
                $p['session'],
                $p['mem_used'],
                $p['status'],
                $p['username'],
                $p['cpu_time'],
                $p['window_title']
            );
        }

        return $processes;
    }
}
