<?php

namespace Vanier\Api\Helpers;
use Vanier\Api\Validations\Validator;

class ValidationHelper
{
    /**
     *  Validates paging parameters. Both values are being validated at the same time.
     *
     * @param array $paging_params The array containing the page and page_size values.
     * @return bool indicating whether the received paging values are valid.
     * mixed returns boolean or an array
     */
    public static function IsValidPagingParams(array $paging_params): mixed
    {
        // $is_valid = false;   
        if (isset($paging_params["page"]) && isset($paging_params["page_size"])) {
            // The page param has to be > 1
            $page = self::isInt($paging_params["page"], 1);
            // The page_size param has to be > 5
            $page_size = self::isInt($paging_params["page_size"], 5);
            
            if ($page !== false && $page_size !== false) {
                return array("page" => $page, "page_size" => $page_size);
            }
         }
        return false;
    }

    
    public function isValidPub($publication)
    {
        $validator = new Validator($publication);

        // rules to validate 
        $rules = array(
            'laureateid' => array(
                'required',
                'integer'
            ),
            'fieldid' => array(
                'required',
                'integer'
            ),
            'publication_name' => array(
                'required'
            ),
            'publication_desc' => array(
                'required'
            )
        );
        // pass new publication through rules array to check
        $validator->mapFieldsRules($rules);
        // validate the new publication, else catch error 
        if ($validator->validate()) {
            return true;
        } else {
            var_dump($validator->errorsToJson());
            return false;
        }
    }
            
    public function isValidPeople($people)
    {
        $validator = new Validator($people);

        // rules to validate 
        $rules = array(
            'addressid' => array(
                'required',
                'integer'
            ),
            'first_name' => array(
                'required'
            ),
            'last_name' => array(
                'required'
            ),
            'dob' => array(
                'required',
                'date'
            ),
            // 'phonenumber' => array(
            //     'required'
            // ),
            'email' => array(
                'email'
            ),
            'occupation' => array(
                'required'
            )
        );
        // pass new publication through rules array to check
        $validator->mapFieldsRules($rules);
        // validate the new publication, else catch error 
        if ($validator->validate()) {
            return true;
        } else {
            var_dump($validator->errorsToJson());
            return false;
        }
    }

    public function isValidOrg($organization)
    {
        $validator = new Validator($organization);

        // rules to validate 
        $rules = array(
            'laureateid' => array(
                'required',
                'integer'
            ),
            'addressid' => array(
                'required',
                'integer'
            ),
            'orgname' => array(
                'required'
            ),
            'phonenumber' => array(
                'required'
            ),
            'email' => array(
                'required',
                'email'
            )
        );
        // pass new publication through rules array to check
        $validator->mapFieldsRules($rules);
        // validate the new publication, else catch error 
        if ($validator->validate()) {
            return true;
        } else {
            var_dump($validator->errorsToJson());
            return false;
        }
    }

    public function isValidNomination($nomination)
    {
        $validator = new Validator($nomination);

        // rules to validate 
        $rules = array(
            'laureateid' => array(
                'required',
                'integer'
            ),
            'fieldid' => array(
                'required',
                'integer'
            ),
            'nomination_reason' => array(
                'required'
            ),
            'yearofnomination' => array(
                'required'
            ),
            'nominators' => array(
                'required'
            )
        );
        // pass new publication through rules array to check
        $validator->mapFieldsRules($rules);
        // validate the new publication, else catch error 
        if ($validator->validate()) {
            return true;
        } else {
            var_dump($validator->errorsToJson());
            return false;
        }
    }

    //Check if string contains a valid number
    /**
     * isInt
     *
     * @param [type] $input -> input to check if its int
     * @param integer $min
     * @return mixed
     */
    public static function isInt($input, int $min = -1): mixed
    {
        if ($min >= 0) {
            return filter_var($input, FILTER_VALIDATE_INT, self::getMinRangeOptions($min));
        }

        return filter_var($input, FILTER_VALIDATE_INT);
    }

    public static function isIntInRange($input, $min, $max): mixed
    {
        return filter_var($input, FILTER_VALIDATE_INT, self::getRangeOptions($min, $max));
    }

    public static function getMinRangeOptions(int $min): array
    {
        return array("options" => array("min_range" => $min));
    }

    public static function getRangeOptions(int $min, int $max): array
    {
        return array("options" => array("min_range" => $min, "max_range" => $max));
    }
}
