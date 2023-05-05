<?php

namespace Vanier\Api\Controllers;

use Exception;
use Vanier\Api\Helpers\WebServiceInvoker;

/**
 * UniversitiesController
 * Composite resource to get universities
 */
class UniversitiesController extends WebServiceInvoker
{
    /**
     * GetUniversity
     * @param mixed $search_unis
     * @return array
     */
    public function GetUniversity($search_unis): array
    {
        $invoker = new WebServiceInvoker();
        $refined_unis = [];

        try {

            $data = $invoker->invokeUri('http://universities.hipolabs.com/search?name=' . $search_unis);
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
        return $refined_unis;
    }
}
