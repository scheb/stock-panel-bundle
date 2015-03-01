<?php
namespace Scheb\StockPanelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class StockType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currencies = array("EUR" => "EUR", "USD" => "USD");
        $builder
            ->add("symbol")
            ->add("name")
            ->add("currency", "choice", array('choices' => $currencies))
            ->add("initialPrice")
            ->add("quantity")
            ->add("displayChart", null, array('required' => false))
        ;
    }



    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "stock";
    }

}
