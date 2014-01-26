<?php
namespace Scheb\StockPanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Scheb\StockPanelBundle\Form\Type\StockType;
use Scheb\StockPanelBundle\Entity\Stock;

class AdminController extends Controller
{

    /**
     * Add a stock
     * @Route("/add", name="stock_add")
     */
    public function addAction(Request $request)
    {
        $stock = new Stock();
        if ($symbol = $request->get("symbol"))
        {
            $stockProvider = $this->get("scheb_stock_panel.stock_provider");
            $stock = $stockProvider->createStock($symbol);
        }

        $form = $this->createForm(new StockType(), $stock);
        if ($request->getMethod() === "POST")
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $em = $this->getEntityManager();
                $em->persist($stock);
                $em->flush();
                return $this->redirect($this->generateUrl("stock_panel"));
            }
        }

        return $this->render("SchebStockPanelBundle:Admin:add.html.twig", array(
            'form' => $form->createView(),
        ));
    }



    /**
     * Edit a stock
     * @Route("/edit/{id}", name="stock_edit")
     */
    public function editAction(Request $request, $id)
    {
        $stock = $this->getStock($id);
        if (!$stock)
        {
            throw $this->createNotFoundException("Stock id ".$id." not found!");
        }

        $form = $this->createForm(new StockType(), $stock);
        if ($request->getMethod() === "POST")
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $em = $this->getEntityManager();
                $em->persist($stock);
                $em->flush();
                return $this->redirect($this->generateUrl("stock_panel"));
            }
        }

        return $this->render("SchebStockPanelBundle:Admin:edit.html.twig", array(
            'form' => $form->createView(),
            'id' => $id,
        ));
    }



    /**
     * Remove a stock
     * @Route("/delete/{id}", name="stock_delete", requirements={"id": "[0-9]+"})
     */
    public function deleteAction(Request $request, $id)
    {
        $stock = $this->getStock($id);
        if ($stock)
        {
            $em = $this->getEntityManager();
            $em->remove($stock);
            $em->flush();
        }
        return $this->redirect($this->generateUrl("stock_panel"));
    }



    /**
     * Find Stock object by id
     * @param integer $id
     * @return \Scheb\StockPanelBundle\Entity\Stock
     */
    private function getStock($id)
    {
        return $this->getStockRepo()->findOneById($id);
    }



    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }



    /**
     * @return \Scheb\StockPanelBundle\Entity\Repository\StockRepository
     */
    private function getStockRepo()
    {
        return $this->getEntityManager()->getRepository("SchebStockPanelBundle:Stock");
    }

}
