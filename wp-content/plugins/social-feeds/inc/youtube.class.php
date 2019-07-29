<?php
/**
 * WP Custom Youtube Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* Check if Class Exists. */
if ( ! class_exists( 'Youtube' ) ) {

  class Youtube {

    public $ytid = '';
    public $name = '';
    public $limit = 25;
    private $yt;
    const YT_PATH = 'vendors/google/';

    public function __construct($appid) {
        require_once self::YT_PATH .'autoload.php';
        $client = new Google_Client();
        $client->setDeveloperKey($appid);
        $this->yt = new Google_Service_YouTube($client);
    }

    //Handle Youtube API
    public function load_youtube_api() {
        $data = $this->search_youtube();
        if(!empty($data)) {
          return $this->yt_write($data);
        } else return 'empty';
    }

    //Handle Youtube Play list API
    public function load_youtube_playlist_api($full=false) {
        $data = $this->playlist_youtube($full);
        if(!empty($data)) {
          return $this->yt_write($data);
        } else return 'empty';
    }

    private function search_youtube() {
        $searchResponse = $this->yt->search->listSearch('id,snippet', array(
              'type' => 'video',
              'q' => $this->name,
              'maxResults' => $this->limit,
            ));
        $data = [];
        $videoResults = array();
        # Merge video ids
        foreach ($searchResponse['items'] as $searchResult) {
          array_push($videoResults, $searchResult['id']['videoId']);
        }
        $videoIds = join(',', $videoResults);
        # Call the videos.list method to retrieve location details for each video.
        $videosResponse = $this->yt->videos->listVideos('snippet, statistics', array(
            'id' => $videoIds,
        ));
        if(!empty($videosResponse)) {
            foreach ($videosResponse['items'] as $videoResult) {
                $data[$videoResult['id']] = array( 'snippet' => $videoResult['snippet'], 'statistics' => $videoResult['statistics']);
            }
        }
        return $data;
    }

    private function playlist_youtube() {
        $data = $videoIds = [];
        $playlistItemsResponse = $this->yt->activities->listActivities('snippet, contentDetails', array(
            'channelId' => $this->ytid,
            'maxResults' => $this->limit
          ));
        if(!empty($playlistItemsResponse)) {
            foreach ($playlistItemsResponse['items'] as $videoResult) {
                $_vid = $videoResult['contentDetails']['upload']['videoId'];
                $data[$_vid] =  array(
                    'vid' => $_vid,
                    'publishedAt' => $videoResult['snippet']['publishedAt'],
                    'title' => $videoResult['snippet']['title'],
                    'thumb' => $videoResult['snippet']['thumbnails']['high']['url'],
                );
                $videoIds[] = $_vid;
            }

            $videosResponse = $this->yt->videos->listVideos('id, snippet, statistics', array(
                'id' => join(',', $videoIds),
            ));
            if(!empty($videosResponse)) {
                foreach ($videosResponse['items'] as $videoResult) {
                  $data[$videoResult['id']] += array('statistics' => $videoResult['statistics']);
                }
            }
            return $data;
        }
    }

    private function yt_write($data=null) {
      global $wpdb;
      if(empty($data)) return null;
      $table_name = $wpdb->prefix . 'social_feeds';
      //Wipe Data from DB
      $wpdb->delete($table_name, array('type' => 'youtube'));
      foreach($data as $yid => $entry) {
          $_data = array(
              'type' => 'youtube',
              'pubdate' => strtotime($entry['publishedAt']),
              'user' => $this->name,
              'image' => $entry['thumb'],
              'link' => 'https://www.youtube.com/watch?v='.$yid,
              'title' => $entry['title'],
              'text' => '',
              'count' => (!empty($entry['statistics']->viewCount)) ? $entry['statistics']->viewCount : 0,
              'count2' => (!empty($entry['statistics']->likeCount)) ? $entry['statistics']->likeCount : 0
          );
          $wpdb->insert($table_name, $_data, array('%s', '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d'));
      }
      return 'passed';
    }
  }
}
?>
