<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class GoogleMapPlaceSearch extends Field
{
    public function updated() {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://maps.googleapis.com/maps/api/place/autocomplete/json?input=Kathmandu%2C%20Nepal&key=AIzaSyC0YxLFkhdwYG1evBrpWijD3pHvUYDL2qE',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        echo $response;
    }
    
    protected string $view = 'forms.components.google-map-place-search';
}
