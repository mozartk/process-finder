<?php

require_once "vendor/autoload.php";

$processFinder = new \mozartk\ProcessFinder\ProcessFinder();
$process = new \Symfony\Component\Process\Process('wait 5');
$process->start();
$pid = $process->getPid();
echo $pid."\n";
$process = $processFinder->getProcess($pid);
print_r($process);
print_r($process->isRunning());
print_r($process->getWindowTitle());

