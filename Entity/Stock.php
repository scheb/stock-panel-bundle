<?php
namespace Scheb\StockPanelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Stock
 *
 * @ORM\Table(name="stock")
 * @ORM\Entity(repositoryClass="Scheb\StockPanelBundle\Entity\Repository\StockRepository")
 * @UniqueEntity("symbol")
 */
class Stock
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="symbol", type="string", length=20, unique=true)
     */
    private $symbol;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=3)
     */
    private $currency;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="initialPrice", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $initialPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="currentPrice", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $currentPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="currentChange", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $currentChange;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedAt;



    /**
     * Init the object
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }


    ////////////////////////////////////////////////////////////////////////////////////////// CONVENIENCE

    /**
     * Return invested money
     * @return float|null
     */
    public function getInvestment()
    {
        if ($this->quantity && $this->initialPrice)
        {
            return $this->quantity * $this->initialPrice;
        }
        else
        {
            return null;
        }
    }

    /**
     * Get current value of investment
     */
    public function getCurrentValue()
    {
        if ($this->quantity && $this->initialPrice && $this->currentPrice)
        {
            return $this->quantity * $this->currentPrice;
        }
        else
        {
            return null;
        }
    }

    /**
     * Return profit
     * @return float
     */
    public function getProfit()
    {
        if ($this->quantity && $this->initialPrice && $this->currentPrice)
        {
            return $this->getCurrentValue() - $this->getInvestment();
        }
        else
        {
            return null;
        }
    }

    /**
     * Return profit percentage
     * @return float
     */
    public function getProfitPercent()
    {
        return $this->getProfit() / $this->getInvestment();
    }

    /**
     * Get percent of current change
     * @return float
     */
    public function getCurrentChangePercent()
    {
        $oldPrice = $this->currentPrice - $this->currentChange;
        return $this->currentChange / $oldPrice;
    }



    ////////////////////////////////////////////////////////////////////////////////////////// GETTER / SETTER

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return \Scheb\StockPanelBundle\Entity\Stock
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $symbol
     * @return \Scheb\StockPanelBundle\Entity\Stock
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;
        return $this;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return \Scheb\StockPanelBundle\Entity\Stock
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @param float $quantity
     * @return \Scheb\StockPanelBundle\Entity\Stock
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float $initialPrice
     * @return \Scheb\StockPanelBundle\Entity\Stock
     */
    public function setInitialPrice($initialPrice)
    {
        $this->initialPrice = $initialPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getInitialPrice()
    {
        return $this->initialPrice;
    }

    /**
     * @return float
     */
    public function getCurrentPrice()
    {
        return $this->currentPrice;
    }

    /**
     * @param float $currentPrice
     * @return \Scheb\StockPanelBundle\Entity\Stock
     */
    public function setCurrentPrice($currentPrice)
    {
        $this->currentPrice = $currentPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getCurrentChange()
    {
        return $this->currentChange;
    }

    /**
     * @param float $currentChange
     * @return \Scheb\StockPanelBundle\Entity\Stock
     */
    public function setCurrentChange($currentChange)
    {
        $this->currentChange = $currentChange;
        return $this;
    }

    /**
     * @return float
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return \Scheb\StockPanelBundle\Entity\Stock
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return \Scheb\StockPanelBundle\Entity\Stock
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

}
