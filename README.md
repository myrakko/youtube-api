# php youtube-api + youtube-dl
somewhat clumsy so need a rewrite.
## dir structure
php/key.php
php/dl.php
cmd/dl.sh
ls/keyword.ls

###php/key.php
php scr to write video ids using youtube search api.

```
vi php/key.php
$_GET['q']="
southpark
";

```
###php/dl.php

write video ids to ls/keyword.ls.

```
php/dl.php keyword
```
###cmd/dl.sh

dl videos from ls/keyword.ls

```
############################################################
```

## scripts

### get google php api by composer
```
composer require google/apiclient:^2.0
```

### php/key.php

####php scr to insert the keyword for youtube search api.
```
<?php

$_GET['q']="
southpark
";
$_GET['maxResults']="3";

if ($_GET['q'] && $_GET['maxResults']) {
require_once ('vendor/autoload.php');

$DEVELOPER_KEY = 'yourkey';

$client = new Google_Client();
$client->setDeveloperKey($DEVELOPER_KEY);

$youtube = new Google_Service_YouTube($client);

try {
$searchResponse = $youtube->search->listSearch('id,snippet', array(
'q' => $_GET['q'],
'maxResults' => $_GET['maxResults'],
));

$vtit = '';
$vid = '';
$channels = '';
$playlists = '';

foreach ($searchResponse['items'] as $searchResult) {
    $thu=    $searchResult['snippet']['thumbnails']['default']['url'];
$iarr[]=$thu;
echo $thu;

}


foreach ($searchResponse['items'] as $searchResult) {
switch ($searchResult['id']['kind']) {
case 'youtube#video':
$vtit = $searchResult['snippet']['title'];
$vid=$searchResult['id']['videoId'];
//echo $vtit.":".$vid."\n";
break;
case 'youtube#channel':
$channels .= sprintf('<li>%s (%s)</li>',
$searchResult['snippet']['title'], $searchResult['id']['channelId']);
break;
case 'youtube#playlist':
$playlists .= sprintf('<li>%s (%s)</li>',
$searchResult['snippet']['title'], $searchResult['id']['playlistId']);
break;
}
$varr[]=$vid;
$tarr[]=$vtit;


}

} catch (Google_Service_Exception $e) {
$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
htmlspecialchars($e->getMessage()));
} catch (Google_Exception $e) {
$htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
htmlspecialchars($e->getMessage()));
}
}

//echo $htmlBody;
?>

```
### php/dl.php

write video ids to ls/keyword.ls.

```
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

``` 
### cmd/dl.sh
dl videos using youtube-dl from ls/keyword.ls.
#!/bin/bash

cat1=$(cat $1)
sed "1d" $1 > $1.2
cat2=$(cat $1.2)

for i in $cat2
do
#echo $i
youtube-dl -f mp4 $i

done
```