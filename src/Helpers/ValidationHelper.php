<?php

namespace Vanier\Api\Helpers;
use Vanier\Api\Validations\Validator;

/**
 * ValidationHelper
 * Handles all validation 
 */
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
            $page_size = self::isInt($paging_params["page_size"], 2);
            
            if ($page !== false && $page_size !== false) {
                return array("page" => $page, "page_size" => $page_size);
            }
         }
        return false;
    }

    
    /**
     * isValidPub
     * checks if the publication is valid for POST
     * @param mixed $publication
     * @return bool
     */
    public function isValidPub($publication)
    {
        $validator = new Validator($publication);

        // rules to validate 
        $rules = array(
            'laureateid' => array(
                'required',
                'integer',
                ['min', 1]
            ),
            'fieldid' => array(
                'required',
                'integer',
                ['max', 6],
                ['min', 1]
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

    /**
     * Summary of isValidPubUpdate
     * checks if the publication is valid for PUT
     * @param mixed $publication
     * @return bool
     */
    public function isValidPubUpdate($publication)
    {
        $validator = new Validator($publication);

        // rules to validate 
        $rules = array(
            'publicationid' => array(
                'required',
                'numeric',
                ['min', 1]
                // 'required'
            ),
            'laureateid' => array(
                'integer',
                ['min', 1]
                // 'required'
            ),
            'fieldid' => array(
                'integer',
                ['max', 6],
                ['min', 1]
                // 'required'
            ),
            'publication_name' => array(
                // 'required'
            ),
            'publication_desc' => array(
                // 'required'
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
            
    /**
     * Summary of isValidPeople
     * checks if the laureate is valid for POST
     * @param mixed $people
     * @return bool
     */
    public function isValidPeople($people)
    {
        $validator = new Validator($people);

        // rules to validate 
        $rules = array(
            'addressid' => array(
                'required',
                'integer',
                ['min', 1]
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
            'phonenumber' => array(
                'numeric'
            ),
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

    /**
     * Summary of isValidPeopleUpdate
     * checks if the laureate is valid for PUT
     * @param mixed $people
     * @return bool
     */
    public function isValidPeopleUpdate($people)
    {
        $validator = new Validator($people);

        // rules to validate 
        $rules = array(
            'laureateid' => array(
                'required',
                'integer',
                ['min', 1]
            ),
            'addressid' => array(
                'integer',
                ['min', 1]
                // 'required'
            ),
            'first_name' => array(
                // 'required'
            ),
            'last_name' => array(
                // 'required'
            ),
            'dob' => array(
                'date'
                // 'required'
            ),
            'phonenumber' => array(
                'numeric'
                // 'required'
            ),
            'email' => array(
                'email'
                // 'required'
            ),
            'occupation' => array(
                // 'required'
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

    /**
     * isValidAddress
     * checks if the address is valid for POST
     * @param mixed $address
     * @return bool
     */
    public function isValidAddress($address)
    {
        $validator = new Validator($address);

        // rules to validate 
        $rules = array(
            'streetname' => array(
                'required'
            ),
            'city' => array(
                'required'
            ),
            'country' => array(
                'required'
            ),
            'state' => array(
                'required'
            ),
            'zipcode' => array(
                'required',
                'slug',
                ['lengthMin', 6],
                ['lengthMax', 6]
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

    /**
     * isValidAddressUpdate
     * checks if the address is valid for PUT
     * @param mixed $address
     * @return bool
     */
    public function isValidAddressUpdate($address)
    {
        $validator = new Validator($address);

        // rules to validate 
        $rules = array(
            'addressid' => array(
                'required',
                'integer',
                ['min', 1]
            ),
            'streetname' => array(
                // 'required'
            ),
            'city' => array(
                // 'required'
            ),
            'country' => array(
                // 'required'
            ),
            'state' => array(
                // 'required'
            ),
            'zipcode' => array(
                // 'required',
                'slug',
                ['lengthMin', 6],
                ['lengthMax', 6]
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

    /**
     * isValidOrg
     * checks if the organization is valid for POST
     * @param mixed $organization
     * @return bool
     */
    public function isValidOrg($organization)
    {
        $validator = new Validator($organization);

        // rules to validate 
        $rules = array(
            'laureateid' => array(
                'required',
                'integer',
                ['min', 1]
            ),
            'addressid' => array(
                'required',
                'integer',
                ['min', 1]
            ),
            'orgname' => array(
                'required'
            ),
            'phonenumber' => array(
                'required'
            ),
            'email' => array(
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

    /**
     * isValidOrgUpdate
     * checks if the organization is valid for PUT
     * @param mixed $organization
     * @return bool
     */
    public function isValidOrgUpdate($organization)
    {
        $validator = new Validator($organization);

        // rules to validate 
        $rules = array(
            'orgid' => array(
                'required',
                'integer',
                ['min', 1]
            ),
            'laureateid' => array(
                // 'required',
                'integer',
                ['min', 1]
            ),
            'addressid' => array(
                // 'required',
                'integer',
                ['min', 1]
            ),
            'orgname' => array(
                // 'required'
            ),
            'phonenumber' => array(
                // 'required'
            ),
            'email' => array(
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

    /**
     * isValidNomination
     * checks if the nomination is valid for POST
     * @param mixed $nomination
     * @return bool
     */
    public function isValidNomination($nomination)
    {
        $validator = new Validator($nomination);

        // rules to validate 
        $rules = array(
            'laureateid' => array(
                'required',
                'integer',
                ['min', 1]
            ),
            'fieldid' => array(
                'required',
                'integer',
                ['min', 1],
                ['max', 6]
            ),
            'nomination_reason' => array(
                'required'
            ),
            'yearofnomination' => array(
                'required',
                'integer'
            ),
            'nominators' => array(
                'required',
                // 'array'
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

    /**
     * isValidNominationUpdate
     * checks if the nomination is valid for PUT
     * @param mixed $nomination
     * @return bool
     */
    public function isValidNominationUpdate($nomination)
    {
        $validator = new Validator($nomination);

        // rules to validate 
        $rules = array(
            'nominationid' => array(
                'required',
                'integer',
                ['min', 1]
            ),
            'laureateid' => array(
                // 'required',
                'integer',
                ['min', 1]
            ),
            'fieldid' => array(
                // 'required',
                'integer',
                ['min', 1],
                ['max', 6]
            ),
            'nomination_reason' => array(
                // 'required'
            ),
            'yearofnomination' => array(
                // 'required',
                'integer'
            ),
            'nominators' => array(
                // 'required'
                // 'array'
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

    /**
     * isValidAwardUpdate
     * checks if the award is valid for PUT
     * @param mixed $nomination
     * @return bool
     */
    public function isValidAwardUpdate($nomination)
    {
        $validator = new Validator($nomination);

        // rules to validate 
        $rules = array(
            'awardid' => array(
                'required',
                'integer',
                ['min', 1]
            ),
            'fieldid' => array(
                // 'required',
                'integer',
                ['min', 1],
                ['max', 6]
            ),
            'award_name' => array(
                // 'required'
            ),
            'award_desc' => array(
                // 'required',
                'integer'
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
    
    /**
     * isValidFieldUpdate
     * checks if the field is valid for PUT
     * @param mixed $nomination
     * @return bool
     */
    public function isValidFieldUpdate($nomination)
    {
        $validator = new Validator($nomination);

        // rules to validate 
        $rules = array(
            'fieldid' => array(
                'required',
                'integer',
                ['min', 1],
                ['max', 7]
            ),
            'field_name' => array(
                // 'required'
            ),
            'field_desc' => array(
                // 'required',
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

    /**
     * Summary of isIntInRange
     * @param mixed $input
     * @param mixed $min
     * @param mixed $max
     * @return mixed
     */
    public static function isIntInRange($input, $min, $max): mixed
    {
        return filter_var($input, FILTER_VALIDATE_INT, self::getRangeOptions($min, $max));
    }

    /**
     * Summary of getMinRangeOptions
     * @param int $min
     * @return array
     */
    public static function getMinRangeOptions(int $min): array
    {
        return array("options" => array("min_range" => $min));
    }

    /**
     * Summary of getRangeOptions
     * @param int $min
     * @param int $max
     * @return array
     */
    public static function getRangeOptions(int $min, int $max): array
    {
        return array("options" => array("min_range" => $min, "max_range" => $max));
    }
}
