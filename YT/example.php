<?php
if ($_GET['q'] && $_GET['maxResults']) {
  // Call set_include_path() as needed to point to your client library.
  require_once ($_SERVER["DOCUMENT_ROOT"].'/YT/google-api-php-client/src/Google_Client.php');
  require_once ($_SERVER["DOCUMENT_ROOT"].'/YT/google-api-php-client/src/contrib/Google_YouTubeService.php');

  /* Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
  Google APIs Console <http://code.google.com/apis/console#access>
  Please ensure that you have enabled the YouTube Data API for your project. */
  $DEVELOPER_KEY = 'AIzaSyB_nrlYobg4DbHhj32qu7-UeRaClWS8zhI';

  $client = new Google_Client();
  $client->setDeveloperKey($DEVELOPER_KEY);

  $youtube = new Google_YoutubeService($client);

  try {
    $searchResponse = $youtube->search->listSearch('id,snippet', array(
      'q' => $_GET['q'],
      'maxResults' => $_GET['maxResults'],
       'channelId' => 'UCvC4D8onUfXzvjTOM-dBfEA',
        'publishedAfter' => '2018-12-03T00:08:45-08:00',
    ));

    $videos = '';
    $channels = '';

    foreach ($searchResponse['items'] as $searchResult) {
      switch ($searchResult['id']['kind']) {
        case 'youtube#video':
          $videos .= sprintf('<li>%s (%s)</li>', $searchResult['snippet']['title'],
            $searchResult['id']['videoId']."<a href=http://www.youtube.com/watch?v=".$searchResult['id']['videoId']." target=_blank>   Watch This Video</a>");
          break;
        case 'youtube#channel':
          $channels .= sprintf('<li>%s (%s)</li>', $searchResult['snippet']['title'],
            $searchResult['id']['channelId']);
          break;
       }
    }

   } catch (Google_ServiceException $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }
}
?>

<!doctype html>
<html>
  <head>
    <title>YouTube Search</title>
<link href="//www.w3resource.com/includes/bootstrap.css" rel="stylesheet">
<style type="text/css">
body{margin-top: 50px; margin-left: 50px}
</style>
  </head>
  <body>
      <center> <h1>Youtube Search </h1> </center>
    <form method="GET">
  <div>
    Search Term: <input type="search" id="q" name="q" placeholder="Enter Search Term" value="marvel">
  </div>
  <div>
    Max Results: <input type="number" id="maxResults" name="maxResults" min="1" max="50" step="1" value="10">
  </div>
  <input type="submit" value="Search">
</form>
<h3>Videos</h3>
    <ul><?php echo $videos; ?></ul>
    <h3>Channels</h3>
    <ul><?php echo $channels; ?></ul>
</body>
</html>
