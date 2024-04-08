<?php

namespace App\Form;

use App\Entity\Socio;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class SocioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('empresa', HiddenType::class, [
                'mapped' => false, // Não mapeie este campo para uma propriedade da entidade
                'data' => $options['empresa_id'], // Defina o valor do ID da empresa                
            ])
            ->add('nome', TextType::class, [
                'label' => 'Nome',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('cpf', TextType::class, [
                'label' => 'CPF',
                'attr' => ['class' => 'form-control', 'maxlength' => 11], // Tamanho máximo do CPF
            ])
            ->add('contato', TextType::class, [
                'label' => 'Contato',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Salvar',
                'attr'  => ['class' => 'btn btn-primary', 'style' => 'float:left; margin-right:10px;'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Socio::class,
            'empresa_id' => null,
        ]);
    }
}
