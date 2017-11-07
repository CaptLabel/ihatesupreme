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
                        'class' => 'form-control',
                        'maxlength' => '55'
                    )
                )
            )->add(
                'firstname',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control',
                        'maxlength' => '55'
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
                        'class' => 'form-control',
                        'maxlength' => '255'
                    )
                )
            )
            ->add(
                'zip_code',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control',
                        'maxlength' => '5'
                    )
                )
            )
            ->add(
                'city',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control',
                        'maxlength' => '55'
                    )
                )
            )
            ->add(
                'email',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control',
                        'maxlength' => '55'
                    )
                )
            )
            ->add(
                'number',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control',
                        'maxlength' => '10'
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
