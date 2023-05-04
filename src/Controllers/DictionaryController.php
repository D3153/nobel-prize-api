<?php

namespace Vanier\Api\Controllers;

use Exception;
use Vanier\Api\Helpers\WebServiceInvoker;

class DictionaryController extends WebServiceInvoker
{
    public function getDefinitionWord($search_words): array
    {
        $invoker = new WebServiceInvoker();
        $refined_words = [];

        try {
                $data = $invoker->invokeUri('https://api.dictionaryapi.dev/api/v2/entries/en/' . $search_words);
                $words = json_decode($data);
                foreach ($words as $key => $word) {
                    $refined_words['word'] = $word->word;
                    $refined_words['meanings'] = $word->meanings;
                }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
        return $refined_words;
    }
}
