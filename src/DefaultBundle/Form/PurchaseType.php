<?php

namespace DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchaseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                'lastname',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )->add(
                'firstname',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'purchase_list',
                HiddenType::class,
                array(
                    'mapped' => false,
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'adress',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'zip_code',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'city',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'email',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'number',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DefaultBundle\Entity\Purchase'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'defaultbundle_purchase';
    }


}
