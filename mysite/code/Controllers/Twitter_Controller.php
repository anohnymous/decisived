<?php

class Twitter_Controller extends Controller {
    public static $allowed_actions = array(
        'index' => true,
        'twitterauth' => true,
        'userfriends' => true
    );

    public static $twitter_cache_enabled = false;
    public static $twitter_cache_key;
    public static $twitter_cache_id;

    public static $twitter_consumer_key = "FlMzAgdlm9F03uIbU38g";
    public static $twitter_consumer_secret = "kW2WEQ63deAy2jDm7OtLM9SulEnfmQ9LQ6SKWdn0";
    public static $twitter_oauth_token = "1925740556-fpn2GPw2Dhs7OgQtphksNr6wMrOxj5mpbzFfk0q";
    public static $twitter_oauth_token_secret = "661JBu8JNrHNmJaBnaQcC8lZNrFtelXypZhm7Oq5FaQSz";

    public function init(){
        parent::init();
    }

    public function Link() {
        return 'twitter';
    }

    public function index(){
      $twitterdump = $this->queryTwitter();
      echo "<pre>";
      var_dump($twitterdump);
      echo "</pre>";
      echo $twitterdump->search_metadata->refresh_url;
      return;  
    }

    public function queryTwitter($qterm){

        if(self::$twitter_cache_enabled){
            $cache = SS_Cache::factory(self::$twitter_cache_key);
            $cacheID = self::$twitter_cache_id;
        }

        if(!self::$twitter_cache_enabled || (isset($cache) && (!$output = unserialize($cache->load($cacheID))))){

            require_once( TWITTEROAUTHPATH . '/twitteroauth.php');
            
            $connection = new TwitterOAuth(
                self::$twitter_consumer_key,
                self::$twitter_consumer_secret,
                self::$twitter_oauth_token,
                self::$twitter_oauth_token_secret
            );

            $config['count'] = '30';  
            $config['q'] = $qterm;
            $config['include_entities'] = 'false'; 
            $config['result_type'] = 'recent';

			$returntweets = new ArrayList();
            $rawTweets = $connection->get('search/tweets.json?',$config);
            foreach($rawTweets->statuses as $tweet){
                $tweetData = new ArrayData(array(
                        'tweettext' => $tweet->text,
                        'created_at' => $tweet->created_at,
                        'screen_name' => $tweet->user->screen_name,
                    )
                );
                $returntweets->add($tweetData);
            }
            
			//echo "<pre>";
			//var_dump($returntweets);
			//echo "</pre>";
				
            return $returntweets;
            /*
            $view = new ViewableData();
            //$output = $view->renderWith('TwitterFeed', array('Tweets' => $tweetList));

            if(self::$twitter_cache_enabled){
                $cache->save(serialize($output), $cacheID);
            }
            */
        }

        return;
      
    }

    public function twitterauth(){
        $this->loginWithTwitter();
    }

    public function loginWithTwitter(){
        echo 'call';
        require_once( TWITTEROAUTHPATH . '/twitteroauth.php');

        $connection = new TwitterOAuth(
            self::$twitter_consumer_key,
            self::$twitter_consumer_secret,
            self::$twitter_oauth_token,
            self::$twitter_oauth_token_secret
        );

        $config['oauth_callback'] = urlencode("twitterauth");

        $tokenRequest = $connection->getRequestToken();
        var_dump($tokenRequest);

    }

    public function userfriends(){
        require_once( TWITTEROAUTHPATH . '/twitteroauth.php');

        $connection = new TwitterOAuth(
            self::$twitter_consumer_key,
            self::$twitter_consumer_secret,
            self::$twitter_oauth_token,
            self::$twitter_oauth_token_secret
        );

        $config['screen_name'] = '';

        $following = $connection->get('friends/ids.json',$config);
        var_dump($following);
    }

}