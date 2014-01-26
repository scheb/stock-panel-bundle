<?php
namespace Scheb\StockPanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{

    /**
     * Show the stock panel
     * @Route("/search", name="stock_search")
     */
    public function searchAction()
    {
        return $this->render("SchebStockPanelBundle:Search:search.html.twig");
    }



    /**
     * Execute the search
     * @Route("/searchResult", name="stock_search_result")
     */
    public function searchResultAction(Request $request)
    {
        $searchTerm = $request->get("term");
        $result = array();

        if ($searchTerm)
        {
            $searchProvider = $this->get("scheb_stock_panel.search_provider");
            $result = $searchProvider->search($searchTerm);
        }

        $response = $this->render("SchebStockPanelBundle:Search:result.html.twig", array(
        	'result' => $result,
        ));
        $response->setExpires(new \DateTime("+1 hours"));
        return $response;
    }

}
