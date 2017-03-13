# php youtube-api scripts
## cmd/key.php
###php scr to insert the keyword for youtube search api.


get google php api by composer
```
composer require google/apiclient:^2.0
```


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

