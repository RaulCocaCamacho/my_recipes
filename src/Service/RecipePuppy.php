<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

/**
 * Class RecipePuppy http://www.recipepuppy.com/about/api/
 * @package App\Entity
 */
class RecipePuppy {
    private $url_base;
    const INGREDIENTS = 'i';
    const QUERY = 'q';
    const PAGE = 'p';

    //    const format = 'format';

    public function __construct() {
        $this->url_base = 'http://www.recipepuppy.com/api/';
    }

    /**
     * @param $data
     * @param $method
     * @param $url
     * @return mixed
     * @throws HsfException
     */
    protected function curl($params) {
        $client = HttpClient::create();
        $url = $this->url_base . "?" . self::composeParams($params);
        $response = $client->request('GET', $url);
        try {
            $content = json_decode($response->getContent());
            $result = $content->results;
            if (!empty($result)) {
                return $result;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $text
     * @return mixed
     * @throws HsfException
     */
    public function searchRecipe($text) {
        $params[self::QUERY] = $text;
        $resp = $this->curl($params);

        return $resp;
    }

    /**
     * @param int $page
     * @return mixed
     * @throws HsfException
     */
    public function getListByPage($page = 1) {
        $params[self::PAGE] = $page;
        $resp = $this->curl($params);

        return $resp;
    }

    /**
     * @param $params
     * @return string
     */
    public static function composeParams($params) {
        $p = array();
        foreach ($params as $key => $value) {
            $p[] = $key . "=" . urlencode($value);
        }

        return implode("&", $p);
    }
}
