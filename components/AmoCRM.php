<?php

namespace App\Component;


use Exception;

class AmoCRM
{
    public function __construct($data)
    {
        $this->login = $data['login'];
        $this->hash = $data['hash'];

        if (!$this->auth()) {
            throw new \Exception("Ошибка авторизации");
        }
    }

    public function auth()
    {
        $user = [
            'USER_LOGIN' => $this->login,
            'USER_HASH' => $this->hash
        ];

        $subdomain = 'sktkxm';

        $link = 'https://' . $subdomain . '.amocrm.ru/private/api/auth.php?type=json';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($user));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, ROOT . "/cookies/crm_auth.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR,ROOT . "/cookies/crm_auth.txt");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code = (int) $code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        );
        try
        {
            if ($code != 200 && $code != 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
            }

        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }

        $response = json_decode($data, true);
        $response = $response['response'];
        if (isset($response['auth']))
        {
            return true;
        }

        return false;
    }

    public function sendData($data)
    {
        $json = $this->getJson($data);

        $subdomain = 'sktkxm';

        $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/leads';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($json));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, ROOT . "/cookies/crm_auth.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR,ROOT . "/cookies/crm_auth.txt");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE );
        curl_close($curl);

        $code = (int) $code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
        ];
        try
        {
            if ($code != 200 || $contentType != "application/hal+json") {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
            }

        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }

        return true;
    }

    public function getJson($data)
    {
        $json = [];


        $custom = [
            [
                'field_id' => 3,
                'values' => [[
                    'value' => $data['company']
                ]]
            ],
            [
                'field_id' => 3,
                'values' => [[
                    'value' => $data['contactName']
                ]]
            ],
            [
                'field_id' => 3,
                'values' => [[
                    'value' => $data['phone']
                ]]
            ],
            [
                'field_id' => 3,
                'values' => [[
                    'value' => $data['formId']
                ]]
            ],
            [
                'field_id' => 3,
                'values' => [[
                    'value' => $data['utm_source']
                ]]
            ],
            [
                'field_id' => 3,
                'values' => [[
                    'value' => $data['utm_medium']
                ]]
            ],
            [
                'field_id' => 3,
                'values' => [[
                    'value' => $data['utm_campaign']
                ]]
            ],
            [
                'field_id' => 3,
                'values' => [[
                    'value' => $data['utm_content']
                ]]
            ],
            [
                'field_id' => 3,
                'values' => [[
                    'value' => $data['utm_term']
                ]]
            ],
        ];
        if (isset($data['oferta'])){
            $custom[] = [
                'field_id' => 5,
                'values' => [[
                    'value' => true
                ]]
            ];
        }
        if (isset($data['mailAgree'])){
            $custom[] = [
                'field_id' => 5,
                'values' => [[
                    'value' => true
                ]]
            ];
        }

        $json = [[
                'name' => $data['name'],
                'custom_fields_values' => $custom
        ]];
        return $json;
    }

}