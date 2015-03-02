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

    /**
     * Get DateTime of last update
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        $qb = $this->createQueryBuilder("s");
        $qb->select("MAX(s.updatedAt)");
        $lastUpdate = $qb->getQuery()->getSingleScalarResult();
        return $lastUpdate ? new \DateTime($lastUpdate) : new \DateTime("-1 day");
    }
}
