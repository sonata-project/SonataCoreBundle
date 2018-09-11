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

namespace Sonata\CoreBundle\Test;

use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Bridge\Twig\Tests\Extension\Fixtures\StubFilesystemLoader;
use Symfony\Bundle\FrameworkBundle\Tests\Templating\Helper\Fixtures\StubTranslator;
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
     * @var FormRenderer
     */
    private $renderer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extension = new FormExtension($this->renderer);
        $environment = $this->getEnvironment();

        $this->renderer = new FormRenderer(
            $this->getRenderingEngine($environment),
            $this->createMock(CsrfTokenManagerInterface::class)
        );

        $environment->addRuntimeLoader(new FactoryRuntimeLoader([
            FormRenderer::class => function () {
                return $this->renderer;
            },
        ]));

        if ($this->extension instanceof InitRuntimeInterface) {
            $this->extension->initRuntime($environment);
        }
    }

    final public function getRenderer()
    {
        return $this->renderer;
    }

    final protected function getEnvironment(): \Twig_Environment
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
    final protected function getTemplatePaths(): array
    {
        // this is an workaround for different composer requirements and different TwigBridge installation directories
        $twigPaths = array_filter([
            // symfony/twig-bridge (running from this bundle)
            __DIR__.'/../../vendor/symfony/twig-bridge/Resources/views/Form',
            // symfony/twig-bridge (running from other bundles)
            __DIR__.'/../../symfony/twig-bridge/Resources/views/Form',
            // symfony/twig-bridge 2.3 (running from other bundles)
            __DIR__.'/../../../../symfony/twig-bridge/Symfony/Bridge/Twig/Resources/views/Form',
            // symfony/symfony (running from this bundle)
            __DIR__.'/../../vendor/symfony/symfony/src/Symfony/Bridge/Twig/Resources/views/Form',
            // symfony/symfony (running from other bundles)
            __DIR__.'/../../../../symfony/symfony/src/Symfony/Bridge/Twig/Resources/views/Form',
        ], 'is_dir');

        $twigPaths[] = __DIR__.'/../Resources/views/Form';

        return $twigPaths;
    }

    final protected function getRenderingEngine(\Twig_Environment $environment): TwigRendererEngine
    {
        return new TwigRendererEngine(['form_div_layout.html.twig'], $environment);
    }

    /**
     * Renders widget from FormView, in SonataAdmin context, with optional view variables $vars. Returns plain HTML.
     *
     * @return string
     */
    final protected function renderWidget(FormView $view, array $vars = []): string
    {
        return (string) $this->renderer->searchAndRenderBlock($view, 'widget', $vars);
    }

    /**
     * Helper method to strip newline and space characters from html string to make comparing easier.
     */
    final protected function cleanHtmlWhitespace(string $html): string
    {
        return preg_replace_callback('/\s*>([^<]+)</', function (array $value): string {
            return '>'.trim($value[1]).'<';
        }, $html);
    }

    final protected function cleanHtmlAttributeWhitespace(string $html): string
    {
        return preg_replace_callback('~<([A-Z0-9]+) \K(.*?)>~i', function (array $m): string {
            return preg_replace('~\s*~', '', $m[0]);
        }, $html);
    }
}
