<?php

namespace Vanier\Api\Helpers;
use Vanier\Api\Validation\Validations\Validator;

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

    /**
     * isValidActor
     *
     * @param array $publication -> array from the body, to check if passed values are valid
     * @return boolean
     */
    public function isValidPub($publication)
    {
        var_dump($publication);
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

        // stores new actor data
        $validator = new Validator($publication);

        // pass new actor through rules array to check
        $validator->mapFieldsRules($rules);
        // validate the new actor, else catch error 
        if ($validator->validate()) {
            echo"valid!!!!!!!!!!!!";
            return true;
        } else {
            echo"invalid!!!!!!!!!!!!";
            $errors = $validator->errors();
            $error_messages = array();
            foreach($errors as $field => $field_errors){
                foreach($field_errors as $error){
                    $error_messages[] = "$field: $error";
                }
            }
            $error_message = implode("; ", $error_messages);
            // throw new InvalidArgumentException("Invalid: $error_message");
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
