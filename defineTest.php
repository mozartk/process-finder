<?php
/**
 * defineTest.php
 * User: mozartk-mac
 * Date: 2018. 5. 16.
 * Time: PM 9:25
 *
 * Make the phpunit.xml file based on OS
 */

function getOSFile(){
    $systemMacOS = "MacOS.php";
    $systemWindows = "Windows.php";
    $systemUnix = "Unix.php";

    switch (true) {
        case mb_stristr(PHP_OS, 'DAR'): return $systemMacOS;
        case mb_stristr(PHP_OS, 'WIN'): return $systemWindows;
        default: return $systemUnix;
    }
}

$targetXMLFiles = "phpunit.xml.dist";
$loadXMLFiles   = "phpunit.xml.origin";
$excludeFileDir = __DIR__."/src/Drivers";
$xml = file_get_contents(__DIR__."/".$loadXMLFiles);
$files = scandir($excludeFileDir);
$excludeFile = "";
$skiplist = array(
    ".",
    "..",
    "AbstractDrivers.php",
    "DriversInterface.php",
    getOSFile()
);

$skiptestFiles = array();

foreach($files as $filename) {
    if(in_array($filename, $skiplist)) {
       continue;
    }
    $skiptestFiles[] = $excludeFileDir."/".$filename;
    $excludeFile .= "<file>".$excludeFileDir."/".$filename."</file>";
}
$newXml = str_replace("{{excludeTest}}", $excludeFile, $xml);

file_put_contents(__DIR__."/".$targetXMLFiles, $newXml);

echo "[processFinder]\nmake new ".$targetXMLFiles."...\n\n";
echo "add OS files... \n";
echo getOSFile();
echo "\n\n";
echo "skip OS files.... \n";
print_r($skiptestFiles);