<?php
namespace Scheb\StockPanelBundle\Provider;

use Scheb\YahooFinanceApi\ApiClient;

class SearchResultProvider
{

    /**
     * @var \Scheb\YahooFinanceApi\ApiClient
     */
    private $api;



    /**
     * Init the search API
     * @param \Scheb\YahooFinanceApi\ApiClient $api
     */
    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }



    /**
     * Search Yahoo Finance stocks
     * @param string $searchTerm
     * @return array
     */
    public function search($searchTerm)
    {
        $data = $this->api->search($searchTerm);
        return $this->createResult($data);
    }



    /**
     * Create result set from raw data
     * @param data
     * @return array
     */
    private function createResult($data)
    {
        $resultSet = array();
        foreach ($data['ResultSet']['Result'] as $result)
        {
            $resultSet[] = array(
            	'symbol' => $result['symbol'],
                'name' => $result['name'],
                'exchange' => !empty($result['exchDisp']) ? $result['exchDisp'] : null,
            );
        }
        return $resultSet;
    }

}