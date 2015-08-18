<?php

if(count($argv) <= 1){
    printUsage();
    die();
}
$root = $argv[1];
$phpFiles = getPHPFiles($root);

foreach($phpFiles as $file){
        exec('php -l '.escapeshellarg($file), $result);
        if(strpos($result[0],'No syntax errors detected in') === 0){
                continue;
        }else{
                print_r($result);
                die();
        }
}

function getPHPFiles($root){
        $phpFiles = array();
        foreach(scandir($root) as $file){
                if($file == '.' || $file == '..'){
                        continue;
                }
                $file = $root."/".$file;
                if(is_dir($file)){
                        $phpFiles = array_merge($phpFiles,getPHPFiles($file));
                }elseif(strtolower(pathinfo($file,PATHINFO_EXTENSION)) == 'php'){
                        $phpFiles[] = $file;
                }
        }
        return $phpFiles;
}
function printUsage(){
   echo "Usage php ".basename(__FILE__)." pathToPHPProject\n";
}
