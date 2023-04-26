<?php

namespace Vanier\Api\Controllers;
use Exception;
use WebServiceInvoker;

class DictionaryController extends WebServiceInvoker
{
 public function getDefinitionWord() : array
 {
        $invoker = new WebServiceInvoker();
        $search_word = 'physiology';

        try {

            $data = $invoker->invokeUri('https://api.dictionaryapi.dev/api/v2/entries/en/' . $search_word);
            $words = json_decode($data);
            $refined_words = [];
            foreach ($words as $key => $word) {
                $refined_words[$key]['meanings'] = $word->meanings;
                $refined_words[$key]['phonetic'] = $word->phonetic;       
                
            }
        }

        catch (Exception $e) {
            var_dump($e->getMessage());
        }
        return $refined_words;

        // 1) invoke a target resource exposed by the remote API
        // We will send an HTTP message, and process the response.

    //     $shows_uri = 'https://api.dictionaryapi.dev/api/v2/entries/en/oi';
    //     $data = $this->invokeUri($shows_uri);
    //     $words = json_decode($data);
    //     $meanings = json_decode($data);
    //     //2) process the pulled data: we can retain some of the values
    //     //that have been returned by the remote API.
    //     $refined_words = [];
    //     $index = 0;

    // foreach ($words as $key => $word) {

    //     foreach ($meanings as $key => $meaning) {
    //     $refined_words[$index]['word'] = $word -> name;        
    //     $refined_words[$index]['meaning'] = $meaning -> meaning;

    //     }
    //     }
    //     return $refined_words;   
 }

}
