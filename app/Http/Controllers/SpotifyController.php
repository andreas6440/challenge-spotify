<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Class\SpotifyClass as SpotifyClass;

class SpotifyController extends BaseController
{
    Public function getAlbumsByArtist($band_name){        
        
        $token =  SpotifyClass::generateAccessToken();
        $user_id = SpotifyClass::getUserId($token,$band_name);
        $all_data= SpotifyClass::getalbumsByArtistId($token,$user_id);
        $albums = SpotifyClass::ProcessAlbum($all_data);
        return $albums;
    }
}
