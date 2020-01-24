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

namespace Sonata\Form\Test;

use Sonata\Form\Fixtures\StubFilesystemLoader;
use Sonata\Form\Fixtures\StubTranslator;
use Symfony\Bridge\Twig\AppVariable;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Bridge\Twig\Form\TwigRendererEngineInterface;
use Symfony\Bridge\Twig\Form\TwigRendererInterface;
use Symfony\Component\Form\FormExtensionInterface;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Twig\Environment;
use Twig\Extension\InitRuntimeInterface;
use Twig\RuntimeLoader\FactoryRuntimeLoader;

/**
 * Base class for tests checking rendering of form widgets.
 *
 * @author Christian Gripp <mail@core23.de>
 */
abstract class AbstractWidgetTestCase extends TypeTestCase
{
    /**
     * @var FormExtensionInterface
     */
    private $extension;

    /**
     * @var TwigRenderer
     */
    private $renderer;

    protected function setUp(): void
    {
        parent::setUp();

        // TODO: remove the condition when dropping symfony/twig-bundle < 3.2
        if (method_exists(AppVariable::class, 'getToken')) {
            $this->extension = new FormExtension();
            $environment = $this->getEnvironment();
            $this->renderer = new FormRenderer(
                $this->getRenderingEngine($environment),
                $this->createMock(CsrfTokenManagerInterface::class)
            );
            $runtimeLoader = new FactoryRuntimeLoader([
                FormRenderer::class => [$this, 'getRenderer'],
                TwigRenderer::class => [$this, 'getRenderer'],
            ]);

            $environment->addRuntimeLoader($runtimeLoader);
        } else {
            $this->renderer = new TwigRenderer(
                $this->getRenderingEngine(),
                $this->createMock(CsrfTokenManagerInterface::class)
            );
            $this->extension = new FormExtension($this->renderer);
            $environment = $this->getEnvironment();
        }

        if ($this->extension instanceof InitRuntimeInterface) {
            $this->extension->initRuntime($environment);
        }
    }

    /**
     * @return TwigRendererInterface
     */
    final public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * @return \Twig_Environment
     */
    protected function getEnvironment()
    {
        $loader = new StubFilesystemLoader($this->getTemplatePaths());

        $environment = new Environment($loader, [
            'strict_variables' => true,
        ]);
        $environment->addExtension(new TranslationExtension(new StubTranslator()));
        $environment->addExtension($this->extension);

        return $environment;
    }

    /**
     * Returns a list of template paths.
     *
     * @return string[]
     */
    protected function getTemplatePaths()
    {
        // this is an workaround for different composer requirements and different TwigBridge installation directories
        $twigPaths = array_filter([
            // symfony/twig-bridge (running from this bundle)
            __DIR__.'/../../../vendor/symfony/twig-bridge/Resources/views/Form',
            // symfony/twig-bridge (running from other bundles)
            __DIR__.'/../../../../../symfony/twig-bridge/Resources/views/Form',
            // symfony/symfony (running from this bundle)
            __DIR__.'/../../../vendor/symfony/symfony/src/Symfony/Bridge/Twig/Resources/views/Form',
            // symfony/symfony (running from other bundles)
            __DIR__.'/../../../../../symfony/symfony/src/Symfony/Bridge/Twig/Resources/views/Form',
        ], 'is_dir');

        $twigPaths[] = __DIR__.'/../../CoreBundle/Resources/views/Form';

        return $twigPaths;
    }

    /**
     * NEXT_MAJOR: uncomment and use the $environment argument.
     *
     * @return TwigRendererEngineInterface
     */
    protected function getRenderingEngine(/* \Twig_Environment $environment = null */)
    {
        $environment = current(\func_get_args());
        if (null === $environment && method_exists(AppVariable::class, 'getToken')) {
            @trigger_error(
                'Not passing a \Twig_Environment instance to '.__METHOD__.
                ' is deprecated since 3.3 and will not be possible in 4.0',
                E_USER_DEPRECATED
            );
        }

        return new TwigRendererEngine(['form_div_layout.html.twig'], $environment);
    }

    /**
     * Renders widget from FormView, in SonataAdmin context, with optional view variables $vars. Returns plain HTML.
     *
     * @return string
     */
    final protected function renderWidget(FormView $view, array $vars = [])
    {
        return (string) $this->renderer->searchAndRenderBlock($view, 'widget', $vars);
    }

    /**
     * Helper method to strip newline and space characters from html string to make comparing easier.
     *
     * @param string $html
     *
     * @return string
     */
    final protected function cleanHtmlWhitespace($html)
    {
        return preg_replace_callback('/\s*>([^<]+)</', static function ($value) {
            return '>'.trim($value[1]).'<';
        }, $html);
    }

    /**
     * @param string $html
     *
     * @return string
     */
    final protected function cleanHtmlAttributeWhitespace($html)
    {
        return preg_replace_callback('~<([A-Z0-9]+) \K(.*?)>~i', static function ($m) {
            return preg_replace('~\s*~', '', $m[0]);
        }, $html);
    }
}

class_exists(\Sonata\CoreBundle\Test\AbstractWidgetTestCase::class);
