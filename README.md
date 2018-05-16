# process-finder
<p align="left">
<a href="https://travis-ci.org/mozartk/process-finder?branch=master"><img src="https://travis-ci.org/mozartk/process-finder.svg?branch=master" alt="Build Status"></a>
<a href='https://travis-ci.org/mozartk/process-finder?branch=master'><img src="https://img.shields.io/travis/php-v/mozartk/process-finder.svg"></a>
<a href='https://coveralls.io/github/mozartk/process-finder?branch=master'><img src='https://coveralls.io/repos/github/mozartk/process-finder/badge.svg?branch=master' alt='Coverage Status' /></a>
<a href='https://opensource.org/licenses/MIT'><img src='https://img.shields.io/badge/License-MIT-green.svg' alt='License MIT' /></a>
<a href='OJDDEV.md'><img src="https://img.shields.io/badge/OJD-mozartk-green.svg" alt="OJD" title="WE ARE OJD"></a>
</p>

This is fork version of [craftpip/process-handler](https://github.com/craftpip/process-handler).


Get list of running processes by name or pid, supports windows and unix, macOS
  
I struggled to find a library that returns the processes list for the operating system.
My use case was to find if my spawned process was running or not.

## Usage


```php
// Include your autoload 
require_once 'vendor/autoload.php';

use \mozartk\ProcessFinder\ProcessFinder;
use \Symfony\Component\Process\Process;

// Initialize your library
$processFinder = new ProcessFinder();

// Spawn a process and check if a process by its pid exists.
$symfonyProcess = new Process('ls');
$symfonyProcess->start();
$pid = $symfonyProcess->getPid(); // 8378

$process = $processFinder->getProcess($pid);
if($process){
    $name = $process->getName();
    $pid = $process->getPid();
    $mem_used = $process->getMemUsed();
    $cpu_time = $process->getCpuTime();
    $session = $process->getSession();
    $session_name = $process->getSessionName();
    $status = $process->getStatus();
    $username = $process->getUsername();
    $window_title = $process->getWindowTitle();
    $is_running = $process->isRunning();
    
    /*
    Examples
    returns the following on UNIX
    [0] => Array
            (
                [name] => [sh] <defunct>
                [pid] => 8378
                [session_name] => 
                [session] => 6065
                [mem_used] => 0 KB
                [status] => RUNNING
                [username] => root
                [cpu_time] => 00:00:00
                [window_title] => 
            )
            
    returns the following on WINDOWS
    [0] => Array
            (
                [name] => cmd.exe
                [pid] => 6380
                [session_name] => Console
                [session] => 1
                [mem_used] => 3,504 K
                [status] => Unknown
                [username] => BONIFACE-PC\boniface
                [cpu_time] => 0:00:00
                [window_title] => N/A
            )
    */
}else{
    // process was not found.
}


// get all processes 
$allProcesses = $processFinder->getAllProcesses();
```

## Methods
```php
$processFinder = new ProcessFinder();
$processFinder->getAllProcesses();
$processFinder->getProcess($pid);
$processFinder->isRunning($pid);
```

## Installation

Run the composer command 
```cmd
composer require mozartk/process-finder
```

ProcessFinder can be installed with Composer by adding the library as a dependency to your composer.json file.
```json
{
    "require": {
        "mozartk/process-finder": "~1.0"
    }
}
```


## Copyright and license

Made by mozartk.  
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.  
  
This is fork version of [craftpip/process-handler](https://github.com/craftpip/process-handler).