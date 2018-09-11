<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Form\Type;

use Sonata\CoreBundle\Form\EventListener\ResizeFormListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventSubscriber(new ResizeFormListener(
            $options['type'],
            $options['type_options'],
            $options['modifiable'],
            $options['pre_bind_data_callback']
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['btn_add'] = $options['btn_add'];
        $view->vars['btn_catalogue'] = $options['btn_catalogue'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'modifiable' => false,
            'type' => TextType::class,
            'type_options' => [],
            'pre_bind_data_callback' => null,
            'btn_add' => 'link_add',
            'btn_catalogue' => 'SonataCoreBundle',
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'sonata_type_collection';
    }
}
