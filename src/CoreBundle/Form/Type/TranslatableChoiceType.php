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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * NEXT_MAJOR: remove this class.
 *
 * @deprecated since sonata-project/core-bundle 2.2.0, to be removed in 4.0.
 *             Use form type "choice" with "translation_domain" option instead
 */
class TranslatableChoiceType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     *
     * @todo Remove it when bumping requirements to SF 2.7+
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'catalogue' => 'messages',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        @trigger_error(
            sprintf(
                'Form type "%s" is deprecated since SonataCoreBundle 2.2.0 and will be'
                .' removed in 4.0. Use form type "%s" with "translation_domain" option instead.',
                self::class,
                ChoiceType::class
            ),
            E_USER_DEPRECATED
        );

        parent::buildForm($builder, $options);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['translation_domain'] = $options['catalogue'];
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix()
    {
        return 'sonata_type_translatable_choice';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
