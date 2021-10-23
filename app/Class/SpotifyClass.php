<?php
namespace App\Class;
 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;


class SpotifyClass
{
    public static function generateAccessToken()
    {
        try {

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode(env('CLIENT_ID')  . ':' . env('CLIENT_SECRET'))            
                ])->asForm()
                ->post('https://accounts.spotify.com/api/token', [      
                     
                    'grant_type' => 'client_credentials',
                    
                ]);
           
             $body = json_decode((string) $response->getBody());
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
        
        return $body->access_token;
    }
    public static function getUserId($token,$name)
    {
        if(!isset($name) || $name==""){
            throw new HttpException(500, 'El nombre del artista no es valido');
        }
        try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$token, 
            'Content-Type' => 'application/json',
                    'Accepts' => 'application/json',    
            ])->asForm()
            ->get('https://api.spotify.com/v1/search', [    
                     
                'q' => $name,
                'type' => 'artist',
                'limit' => 1
                
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
     
        $body = json_decode((string) $response->getBody());     
        if(!isset($body->artists->items[0])){
            throw new HttpException(500, 'Artista no encontrado');
        } 
        return $body->artists->items[0]->id;
    }
    public static function getalbumsByArtistId($token,$id)
    {
        try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$token, 
            'Content-Type' => 'application/json',
            'Accepts' => 'application/json',    
            ])->asForm()
            ->get('https://api.spotify.com/v1/artists/'.$id.'/albums',[    
                     
                'include_groups' => 'album',
               
                
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
     
        $body = json_decode((string) $response->getBody());
        if(!isset($body->items)){
            throw new HttpException(500, 'No se encontro ningun Album');
        } 
        return $body;
    }

    public static function ProcessAlbum($data){
        $new_album = [];
        
        foreach( $data->items as $key=>$row){
            
           if(!in_array($row->name,array_column($new_album,'name'))){
            $new = [];
            $new['name'] = $row->name;
            $new['released'] = $row->release_date;
            $new['tracks'] = $row->total_tracks;
            $new['cover'] = $row->images;
            array_push($new_album, $new);
           }
            
        } 
        return  $new_album;
    }
}