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

class OrderItemQuantityType extends AbstractType
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
            ->setAction($this->urlGenerator->generate('update_cart_quantity'))
            ->add(
                'quantity',
                integerType::class,
                [
                    'required' => true
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
                ['label' => 'app.cart.btn.update_item']
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => OrderItem::class,
        ));
    }
}