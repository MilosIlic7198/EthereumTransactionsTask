<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EtherscanService {

    private $apiKey;
    private $httpClient;

    public function __construct()
    {
        $this->apiKey = env('ETHERSCAN_API_KEY');
        $this->httpClient = Http::withOptions([
            'base_uri' => 'https://api.etherscan.io/v2/api',
            'verify' => false,
        ])->withHeaders([
            'Content-Type' => 'application/json',
        ]);
        /*
        The: 'verify' => false, ... is used to disable SSL certificate verification for each request so it will be easier to run the project without the need for additional configuration.
        Development environment only!
        */
    }

    public function getTransactions($address, $page, $offset)
    {
        $response = $this->httpClient->get('', [
            'chainid' => 1, //Mainnet.
            'module' => 'account',
            'action' => 'tokentx',
            //'contractaddress' => 0x9f8f72aa9304c8b593d555f12ef6589cc3a579a2, I want all token transactions.
            'address' => $address,
            'page' => $page,
            'offset' => $offset,
            'startblock' => 0,
            'endblock' => 99999999,
            'sort' => 'asc',
            'apikey' => $this->apiKey,
        ]);

        return $response->json()['result'];
    }
}
