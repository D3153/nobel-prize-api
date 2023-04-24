<?php

//@author Jonathan Dimitriu

require_once('vendor/autoload.php');
require_once('src/Helpers/WebServiceInvoker');

$search_word = 'Oi';
$invoker = new WebServiceInvoker();
try {
    $data = $invoker->invokeUri('https://api.dictionaryapi.dev/api/v2/entries/en/' . $search_word);
    $words = json_decode($data);
    $refined_words = [];
    $index = 0;
    foreach ($words as $key => $word) {
        $refined_words[$key]['meanings'] = $word->meanings;
        $refined_words[$key]['phonetic'] = $word->phonetic;       
        
        //var_dump($word);exit;
        // foreach ($word->meanings as $key => $) {
        //     $refined_words[$index]['word'] = $word->name;
        //     $refined_words[$index]['meaning'] = $meaning->meaning;
        // }
    }
    //echo 'Oi <br>';
     //var_dump($refined_words);    
     echo json_encode($refined_words);
}
// var_dump($shows);    
catch (Exception $e) {
    var_dump($e->getMessage());
}
//$data = $invoker->invokeUri('https://api.tvmaze.com/shows');



// TODO: Implement your HTTP client here. 

// base URI: https://api.tvmaze.com

// // Create a client with a base URI
// $client = new GuzzleHttp\Client(['base_uri' => 'https://api.tvmaze.com/']);

// //The original way
// $response = $client->get('/shows');


// //check the status code
// if($response->getStatusCode() !== 200){
//     throw new Exception("Oops don't work", $response->getReasonPhrase());
// }


// // List of shows: /shows
// // Send a request to https://foo.com/api/test
// // website's way
// //$response = $client->request('GET', 'shows');


// if (!str_contains($response->getHeader('Content-Type')[0],'application/json')) {
//     throw new Exception("Unprocessable document: JSON data required", $response->getReasonPhrase());
// }

// $data = $response->getBody()->getContents();
// $shows = json_decode($data);
// //var_dump($shows);

//echo '<pre>';


// foreach ($shows as $key => $show) {
// //    var_dump($show); exit;
//     echo $show->name . '<br>';

//     $all_genres = '';

//     foreach ($show->genres as $key => $genre) {
//         $all_genres = $genre . ' |';
//     }
//     echo $all_genres . '<br>';
//     echo $show->status . '<br>';
//     echo $show->premiered . '<br>';
//     echo $show->ended . '<br>';
//     echo $show->language . '<br>';
//     echo $show->status . '<br>';

// }

// website's way
// $code = $response->getStatusCode(); // 200
// $reason = $response->getReasonPhrase(); // OK

// website's way
// Get all of the response headers.
// foreach ($response->getHeaders() as $name => $values) {
//     echo $name . ': ' . implode(', ', $values) . "\r\n";
// }



//var_dump($data[0]->show->name);




// TODO: Parse the response and build the HTML table here. 


// $data = $response->getBody()->getContents();

// $shows = json_decode($data);
// var_dump($shows);