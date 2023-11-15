<?php

namespace App\Services;

use GuzzleHttp\Client;

class RakutenService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            // 楽天APIのベースURIを設定
            'base_uri' => 'https://app.rakuten.co.jp/services/api/BooksTotal/Search/20170404',
        ]);
    }

    public function fetchComics($params)
    {
        // パラメータにapplicationId（楽天のAPIキー）を追加
        $params['applicationId'] = env('1099989328861075116');
        
        // APIリクエストを送信
        $response = $this->client->get('', ['query' => $params]);

        // レスポンスのステータスコードをチェック
        if ($response->getStatusCode() == 200) {
            $body = $response->getBody();
            $data = json_decode($body, true);
            return $data['Items'] ?? [];
        }

        return [];
    }
}
