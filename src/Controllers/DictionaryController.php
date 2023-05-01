<?php

namespace Vanier\Api\Controllers;
use Exception;
use Vanier\Api\Helpers\WebServiceInvoker;

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

 }

}
