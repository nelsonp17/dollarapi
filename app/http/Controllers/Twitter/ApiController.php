<?php

namespace App\Http\Controllers\Twitter;

use TwitterAPIExchange;

use App\Http\Controllers\Controller;

class ApiController extends Controller {
    public function run(){
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $requestMethod = 'GET';
        $getfield = '?screen_name=enparalelovzla&count=10'; // Cambia "nombre_de_usuario" por el nombre de usuario de la cuenta que deseas obtener los tweets.

        $twitter = new TwitterAPIExchange(twitter_api);
        $response = $twitter->setGetfield($getfield)
                        ->buildOauth($url, $requestMethod)
                        ->performRequest();

        $tweets = json_decode($response, true);

        foreach ($tweets as $tweet) {
            //echo $tweet['text'] . "<br>";
            var_dump($tweet);
        }
    }
}