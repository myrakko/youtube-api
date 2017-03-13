<?php
if(!isset($argv[1])){
$argv[1]=null;
}
$arg=$argv[1];
echo $arg;

$dir1="/mnt/vid/Vid";
//include "lib-fun.php";
include "$dir1/fun/php/key.php";

system("rm ls/$arg.ls");
system("touch ls/$arg.ls");

echo count($varr)."\n";

$txt="";

foreach ($varr as $val) {

$txt=$txt."https://www.youtube.com/watch?v=$val"."\n";
  //    echo "https://www.youtube.com/watch?v=$val";

//chdir("/mnt/vid/Vid/jar");
//echo  getcwd();

$myf = fopen("ls/$arg.ls", "w+") or die("Unable to open file!");
fwrite($myf, $txt);
fclose($myf);

exec("cmd/dl.sh ls/$arg.ls");

}



?>
