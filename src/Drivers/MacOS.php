<?php

namespace mozartk\ProcessFinder\Drivers;

use mozartk\ProcessFinder\Process as Process2;

class MacOS extends AbstractDrivers implements DriversInterface
{
    protected $options = "pid,time,rss,user,sess,args";

    public function parse($output)
    {
        $op = explode("\n", $output);

        $processes = array();
        foreach ($op as $k => $item) {
            if ($k < 1) {
                continue;
            }

            $item = explode(" ", preg_replace('!\s+!', ' ', trim($item)));
            $line = array();
            foreach ($item as $i) {
                if ($i != '') {
                    $line[] = $i;
                }
            }

            $processName = implode(" ", array_slice($line, 5));
            $processes[] = new Process2($processName, $line[0], false, $line[4], $line[2] . ' KB', 'RUNNING', $line[3], $line[1], false);
        }

        return $processes;
    }
}
