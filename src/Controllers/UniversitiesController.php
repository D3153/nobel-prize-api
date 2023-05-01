<?php

namespace Vanier\Api\Controllers;
use Exception;
use Vanier\Api\Helpers\WebServiceInvoker;

class UniversitiesController extends WebServiceInvoker
{
    public function GetUniversity() : array
    {
        $invoker = new WebServiceInvoker();

        $search_uni = 'Vanier';

        try {

            $data = $invoker->invokeUri('http://universities.hipolabs.com/search?name=' . $search_uni);
            $words = json_decode($data);
            //TODO: Continue the 2nd API
            }
        }

    
    }
}
