<?php
/**
 * Created by PhpStorm.
 * User: ThaoNguyen
 * Date: 06/05/2019
 * Time: 11:20
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content');
    }

}