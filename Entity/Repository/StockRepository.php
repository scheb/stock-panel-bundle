<?php
namespace Scheb\StockPanelBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class StockRepository extends EntityRepository
{

    /**
     * Get all stocks
     * @return array Indexed by symbol
     */
    public function getAll()
    {
        $qb = $this->createQueryBuilder("s");
        $qb
            ->orderBy("s.name", "ASC")
        ;
        $stocks = $qb->getQuery()->execute();
        $index = array();
        foreach ($stocks as $stock)
        {
            $index[$stock->getSymbol()] = $stock;
        }
        return $index;
    }

}
