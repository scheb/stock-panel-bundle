<?php
namespace Scheb\StockPanelBundle\Provider;

use Doctrine\ORM\EntityManager;
use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\Exception\ApiException;
use Scheb\StockPanelBundle\Entity\Stock;

class StockPriceProvider
{

    /**
     * @var \Scheb\YahooFinanceApi\ApiClient
     */
    private $api;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Scheb\StockPanelBundle\Entity\Repository\StockRepository
     */
    private $stockRepo;



    /**
     * Init the stock price API
     * @param \Doctrine\ORM\EntityManager $em
     * @param \Scheb\YahooFinanceApi\ApiClient $api
     */
    public function __construct(EntityManager $em, ApiClient $api)
    {
        $this->em = $em;
        $this->stockRepo = $em->getRepository("SchebStockPanelBundle:Stock");
        $this->api = $api;
    }



    /**
     * Return all stocks with prices updated
     * @return array
     */
    public function getStocksAndUpdate()
    {
        if ($this->hasToUpdate()) {
            $this->updateStocks();
        }

        return $this->getStocks();
    }



    /**
     * Return all stocks
     * @return array
     */
    public function getStocks() {
        $stocks = $this->stockRepo->getAll();
        return $stocks;
    }



    /**
     * Create a stock object by symbol
     * @param symbol
     */
    public function createStock($symbol)
    {
        $stock = new Stock();
        $data = $this->fetchData(array($symbol));
        $result = $data['query']['results']['quote'];
        if ($result)
        {
            $stock
                ->setName($result['Name'])
                ->setSymbol($result['symbol'])
                ->setInitialPrice($result['LastTradePriceOnly'])
            ;
        }
        return $stock;
    }



    /**
     * Update all stocks
     */
    public function updateStocks()
    {
        $stocks = $this->getStocks();
        $symbols = array_keys($stocks);
        $data = $this->fetchData($symbols);
        $results = $data['query']['results']['quote'];
        foreach ($results as $stockData)
        {
            $symbol = $stockData['symbol'];
            $stock = $stocks[$symbol];
            $stock
                ->setCurrentPrice($stockData['LastTradePriceOnly'])
                ->setCurrentChange($stockData['Change'])
                ->setUpdatedAt(new \DateTime())
            ;
            $this->em->persist($stock);
        }
        $this->em->flush();
    }


    /**
     * Check if stocks need to be updated
     */
    public function hasToUpdate()
    {
        $timeout = new \DateTime("-5 minutes");
        return $this->stockRepo->getLastUpdate() < $timeout;
    }



    /**
     * Fetch stock data for symbols
     * @param array $symbols
     * @param integer $try Number of this try
     */
    private function fetchData($symbols, $try = 0)
    {
        try
        {
            return $this->api->getQuotes($symbols);
        }
        catch (ApiException $e)
        {
            //Yahoo Finance API is sometimes slow or doesn't return a result
            //Maximum of 3 retries
            if ($try < 3)
            {
                return $this->api->getQuotes($symbols, $try + 1);
            }
        }
        return null;
    }

}
