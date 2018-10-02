<?php

namespace App\Form\Type;

use App\Entity\Product;
use App\Model\OrderItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OrderItemType extends AbstractType
{
    protected $urlGenerator;
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($this->urlGenerator->generate('add_cart'))
            ->add(
                'quantity',
                integerType::class,
                [
                    'required' => true,
                    'data' => 1
                ]
            )
            ->add(
                'product',
                EntityType::class,
                [
                    'required' => true,
                    'class'     => Product::class,
                    'choice_label' => 'id',
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                ['label' => 'app.cart.btn.addItem']
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => OrderItem::class,
        ));
    }
}