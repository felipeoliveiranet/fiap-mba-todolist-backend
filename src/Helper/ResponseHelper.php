<?php

namespace App\Helper;

use Psr\Http\Message\ResponseInterface;


class ResponseHelper
{
    public static function processResponse($response, $data)
    {

        if (isset($data) && $data['status'] == 'success') {

            return self::withOk($response, $data);

        } elseif (isset($data) && ($data['status'] == 'error' or $data['status'] == 'fail')) {

            return self::withError($response, $data);

        } else {

            $response->getBody()->write(AppHelper::parseToJSON($data['data']));

            return $response->withStatus(500);
        }
    }

    public static function withOk(ResponseInterface $response, $data)
    {

        $status_code = 200;

        if (isset($data['data']) && !empty($data['data']) && $data['action'] == 'insert')
            $status_code = 201;
        elseif ($data['data'] == null && empty($data['data']) && in_array($data['action'], ['list', 'get', 'delete']))
            $status_code = 204;

        $response->getBody()->write(AppHelper::parseToJSON($data['data']));

        return $response->withStatus($status_code);
    }

    public static function withError(ResponseInterface $response, array $data)
    {
        $response->getBody()->write(AppHelper::parseToJSON($data['data']));

        return $response->withStatus($data['status'] == 'error' ? 404 : 406);
    }
}
