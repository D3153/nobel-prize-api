<?php

namespace Vanier\Api\Helpers;

use Dotenv\Dotenv;
use Firebase\JWT\JWT;

/**
 * Description of JWTManager
 *
 * @author Sleiman Rabah
 */
class JWTManager {

    /**
     * secret_key
     * @var
     */
    private $secret_key;

    /**
     * __construct
     */
    public function __construct() {
        
    }

    /**
     * getSecretKey
     * @return mixed
     */
    public static function getSecretKey() {
        $dotenv = Dotenv::createImmutable(APP_BASE_DIR, APP_ENV_CONFIG);
        $dotenv->load();
        //TODO: throw an exception if the key is empty.
        $secret = isset($_ENV['SECRET_KEY']) ? $_ENV['SECRET_KEY'] : "";
        return $secret;
    }

    /**
     * generateToken
     * @param mixed $user_info
     * @param mixed $expires_in
     * @return string
     */
    public static function generateToken($user_info, $expires_in) {
        // For more information about the registered claims
        // @see: https://www.rfc-editor.org/rfc/rfc7519.html#section-4.1
        //"nbf" (Not Before) Claim
        //@see:  https://www.rfc-editor.org/rfc/rfc7519.html#section-4.1.5
        $payload = [
            'iss' => 'localhost',
            'aud' => 'localhost',
            'iat' => time(),
            'exp' => $expires_in,
        ];
        $jwt_payload = array_merge($payload, $user_info);

        /**
         * IMPORTANT:
         * You must specify supported algorithms for your application. See
         * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
         * for a list of spec-compliant algorithms.
         */
        self::getSecretKey();
        $jwt_secret = $_ENV['SECRET_KEY'];
        $jwt = JWT::encode($jwt_payload, $jwt_secret, 'HS256');
        //$decoded = JWT::decode($jwt, new Key($secret, 'HS256'));
        //print_r($jwt);
        return $jwt;
    }

}
