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
            $unis = json_decode($data);
            $Uni_names = [];
            foreach ($unis as $key => $uni) {
                $Uni_names[$key]['name'] = $uni -> name;
                $Uni_names[$key]['country'] = $uni -> country;
                $Uni_names[$key]['domains'] = $uni -> domains;
            }
            return $Uni_names;

            }
            catch (Exception $e) {
                var_dump($e->getMessage());
            }
        }

    
}

