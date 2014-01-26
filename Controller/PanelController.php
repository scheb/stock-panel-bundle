<?php
namespace Scheb\StockPanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PanelController extends Controller
{

    /**
     * Show the stock panel
     * @Route("/", name="stock_panel")
     */
    public function indexAction()
    {
        return $this->render("SchebStockPanelBundle:Panel:index.html.twig");
    }


    /**
     * Force stock update
     * @Route("/update", name="stock_update")
     */
    public function updateAction()
    {
        $stockProvider = $this->get("scheb_stock_panel.stock_provider");
        $stockProvider->updateStocks();
        $stocks = $stockProvider->getStocks();
        return $this->render("SchebStockPanelBundle:Panel:table.html.twig", array(
        	'stocks' => $stocks,
        ));
    }
}
