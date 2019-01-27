.. index::
    double: Test Widgets; Definition

Testing
=======

Test Widgets
~~~~~~~~~~~~

You can write unit tests for Twig form rendering with the following code::

    use Sonata\Form\Test\AbstractWidgetTestCase;

    class CustomTest extends AbstractWidgetTestCase
    {
        public function testAcmeWidget()
        {
            $options = [
                'foo' => 'bar',
            ];

            $form     = $this->factory->create('Acme\Form\CustomType', null, $options);
            $html     = $this->renderWidget($form->createView());
            $expected = '<input foo="bar"/>';

            $this->assertContains($expected, $this->cleanHtmlWhitespace($html));
        }
    }
