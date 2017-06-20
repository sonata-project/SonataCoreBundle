<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Form\Type;

use Sonata\CoreBundle\Color\Colors;
use Sonata\CoreBundle\Form\FormHelper;
use Sonata\CoreBundle\Form\Type\ColorSelectorType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColorSelectorTypeTest extends TypeTestCase
{
    public function testBuildForm()
    {
        // NEXT_MAJOR: Hack for php 5.3 only, remove it when requirement of PHP is >= 5.4
        $that = $this;

        $formBuilder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')->disableOriginalConstructor()->getMock();
        $formBuilder
            ->expects($this->any())
            ->method('add')
            ->will($this->returnCallback(function ($name, $type = null) use ($that) {
                // NEXT_MAJOR: Remove this "if" (when requirement of Symfony is >= 2.8)
                if (method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
                    if (null !== $type) {
                        $isFQCN = class_exists($type);
                        if (!$isFQCN && method_exists('Symfony\Component\Form\AbstractType', 'getName')) {
                            // 2.8
                            @trigger_error(
                                sprintf(
                                    'Accessing type "%s" by its string name is deprecated since version 2.8 and will be removed in 3.0.'
                                    .' Use the fully-qualified type class name instead.',
                                    $type
                                ),
                                E_USER_DEPRECATED)
                            ;
                        }

                        $that->assertTrue($isFQCN, sprintf('Unable to ensure %s is a FQCN', $type));
                    }
                }
            }));

        $type = new ColorSelectorType();

        $type->buildForm($formBuilder, array(
            'choices' => Colors::getAll(),
            'translation_domain' => 'SonataCoreBundle',
            'preferred_choices' => array(
                Colors::BLACK,
                Colors::BLUE,
                Colors::GRAY,
                Colors::GREEN,
                Colors::ORANGE,
                Colors::PINK,
                Colors::PURPLE,
                Colors::RED,
                Colors::WHITE,
                Colors::YELLOW,
            ),
        ));
    }

    public function testGetParent()
    {
        $form = new ColorSelectorType();

        // NEXT_MAJOR: Remove this "if" (when requirement of Symfony is >= 2.8)
        if (method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
            $parentRef = $form->getParent();

            $isFQCN = class_exists($parentRef);
            if (!$isFQCN && method_exists('Symfony\Component\Form\AbstractType', 'getName')) {
                // 2.8
                @trigger_error(
                    sprintf(
                        'Accessing type "%s" by its string name is deprecated since version 2.8 and will be removed in 3.0.'
                        .' Use the fully-qualified type class name instead.',
                        $parentRef
                    ),
                    E_USER_DEPRECATED)
                ;
            }

            $this->assertTrue($isFQCN, sprintf('Unable to ensure %s is a FQCN', $parentRef));
        }
    }

    public function testGetDefaultOptions()
    {
        $type = new ColorSelectorType();

        $this->assertSame('sonata_type_color_selector', $type->getName());
        $this->assertSame(
            method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix') ?
                'Symfony\Component\Form\Extension\Core\Type\ChoiceType' :
                'choice',
            $type->getParent()
        );

        FormHelper::configureOptions($type, $resolver = new OptionsResolver());

        $options = $resolver->resolve();

        $expected = array(
            'choices' => array(
                '#F0F8FF' => 'aliceblue',
                '#FAEBD7' => 'antiquewhite',
                '#00FFFF' => 'cyan',
                '#7FFFD4' => 'aquamarine',
                '#F0FFFF' => 'azure',
                '#F5F5DC' => 'beige',
                '#FFE4C4' => 'bisque',
                '#000000' => 'black',
                '#FFEBCD' => 'blanchedalmond',
                '#0000FF' => 'blue',
                '#8A2BE2' => 'blueviolet',
                '#A52A2A' => 'brown',
                '#DEB887' => 'burlywood',
                '#5F9EA0' => 'cadetblue',
                '#7FFF00' => 'chartreuse',
                '#D2691E' => 'chocolate',
                '#FF7F50' => 'coral',
                '#6495ED' => 'cornflowerblue',
                '#FFF8DC' => 'cornsilk',
                '#DC143C' => 'crimson',
                '#00008B' => 'darkblue',
                '#008B8B' => 'darkcyan',
                '#B8860B' => 'darkgoldenrod',
                '#A9A9A9' => 'darkgray',
                '#006400' => 'darkgreen',
                '#BDB76B' => 'darkkhaki',
                '#8B008B' => 'darkmagenta',
                '#556B2F' => 'darkolivegreen',
                '#FF8C00' => 'darkorange',
                '#9932CC' => 'darkorchid',
                '#8B0000' => 'darkred',
                '#E9967A' => 'darksalmon',
                '#8FBC8F' => 'darkseagreen',
                '#483D8B' => 'darkslateblue',
                '#2F4F4F' => 'darkslategray',
                '#00CED1' => 'darkturquoise',
                '#9400D3' => 'darkviolet',
                '#FF1493' => 'deeppink',
                '#00BFFF' => 'deepskyblue',
                '#696969' => 'dimgray',
                '#1E90FF' => 'dodgerblue',
                '#B22222' => 'firebrick',
                '#FFFAF0' => 'floralwhite',
                '#228B22' => 'forestgreen',
                '#FF00FF' => 'magenta',
                '#DCDCDC' => 'gainsboro',
                '#F8F8FF' => 'ghostwhite',
                '#FFD700' => 'gold',
                '#DAA520' => 'goldenrod',
                '#808080' => 'gray',
                '#008000' => 'green',
                '#ADFF2F' => 'greenyellow',
                '#F0FFF0' => 'honeydew',
                '#FF69B4' => 'hotpink',
                '#CD5C5C' => 'indianred',
                '#4B0082' => 'indigo',
                '#FFFFF0' => 'ivory',
                '#F0E68C' => 'khaki',
                '#E6E6FA' => 'lavender',
                '#FFF0F5' => 'lavenderblush',
                '#7CFC00' => 'lawngreen',
                '#FFFACD' => 'lemonchiffon',
                '#ADD8E6' => 'lightblue',
                '#F08080' => 'lightcoral',
                '#E0FFFF' => 'lightcyan',
                '#FAFAD2' => 'lightgoldenrodyellow',
                '#D3D3D3' => 'lightgray',
                '#90EE90' => 'lightgreen',
                '#FFB6C1' => 'lightpink',
                '#FFA07A' => 'lightsalmon',
                '#20B2AA' => 'lightseagreen',
                '#87CEFA' => 'lightskyblue',
                '#778899' => 'lightslategray',
                '#B0C4DE' => 'lightsteelblue',
                '#FFFFE0' => 'lightyellow',
                '#00FF00' => 'lime',
                '#32CD32' => 'limegreen',
                '#FAF0E6' => 'linen',
                '#800000' => 'maroon',
                '#66CDAA' => 'mediumaquamarine',
                '#0000CD' => 'mediumblue',
                '#BA55D3' => 'mediumorchid',
                '#9370DB' => 'mediumpurple',
                '#3CB371' => 'mediumseagreen',
                '#7B68EE' => 'mediumslateblue',
                '#00FA9A' => 'mediumspringgreen',
                '#48D1CC' => 'mediumturquoise',
                '#C71585' => 'mediumvioletred',
                '#191970' => 'midnightblue',
                '#F5FFFA' => 'mintcream',
                '#FFE4E1' => 'mistyrose',
                '#FFE4B5' => 'moccasin',
                '#FFDEAD' => 'navajowhite',
                '#000080' => 'navy',
                '#FDF5E6' => 'oldlace',
                '#808000' => 'olive',
                '#6B8E23' => 'olivedrab',
                '#FFA500' => 'orange',
                '#FF4500' => 'orangered',
                '#DA70D6' => 'orchid',
                '#EEE8AA' => 'palegoldenrod',
                '#98FB98' => 'palegreen',
                '#AFEEEE' => 'paleturquoise',
                '#DB7093' => 'palevioletred',
                '#FFEFD5' => 'papayawhip',
                '#FFDAB9' => 'peachpuff',
                '#CD853F' => 'peru',
                '#FFC0CB' => 'pink',
                '#DDA0DD' => 'plum',
                '#B0E0E6' => 'powderblue',
                '#800080' => 'purple',
                '#663399' => 'rebeccapurple',
                '#FF0000' => 'red',
                '#BC8F8F' => 'rosybrown',
                '#4169E1' => 'royalblue',
                '#8B4513' => 'saddlebrown',
                '#FA8072' => 'salmon',
                '#F4A460' => 'sandybrown',
                '#2E8B57' => 'seagreen',
                '#FFF5EE' => 'seashell',
                '#A0522D' => 'sienna',
                '#C0C0C0' => 'silver',
                '#87CEEB' => 'skyblue',
                '#6A5ACD' => 'slateblue',
                '#708090' => 'slategray',
                '#FFFAFA' => 'snow',
                '#00FF7F' => 'springgreen',
                '#4682B4' => 'steelblue',
                '#D2B48C' => 'tan',
                '#008080' => 'teal',
                '#D8BFD8' => 'thistle',
                '#FF6347' => 'tomato',
                '#40E0D0' => 'turquoise',
                '#EE82EE' => 'violet',
                '#F5DEB3' => 'wheat',
                '#FFFFFF' => 'white',
                '#F5F5F5' => 'whitesmoke',
                '#FFFF00' => 'yellow',
                '#9ACD32' => 'yellowgreen',
            ),
            'translation_domain' => 'SonataCoreBundle',
            'preferred_choices' => array(
                '#000000',
                '#0000FF',
                '#808080',
                '#008000',
                '#FFA500',
                '#FFC0CB',
                '#800080',
                '#FF0000',
                '#FFFFFF',
                '#FFFF00',
            ),
        );

        // NEXT_MAJOR: Remove this "if" (when requirement of Symfony is >= 2.8)
        if (method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
            $expected['choices_as_values'] = true;
            $expected['choices'] = array(
                'aliceblue' => '#F0F8FF',
                'antiquewhite' => '#FAEBD7',
                'cyan' => '#00FFFF',
                'aquamarine' => '#7FFFD4',
                'azure' => '#F0FFFF',
                'beige' => '#F5F5DC',
                'bisque' => '#FFE4C4',
                'black' => '#000000',
                'blanchedalmond' => '#FFEBCD',
                'blue' => '#0000FF',
                'blueviolet' => '#8A2BE2',
                'brown' => '#A52A2A',
                'burlywood' => '#DEB887',
                'cadetblue' => '#5F9EA0',
                'chartreuse' => '#7FFF00',
                'chocolate' => '#D2691E',
                'coral' => '#FF7F50',
                'cornflowerblue' => '#6495ED',
                'cornsilk' => '#FFF8DC',
                'crimson' => '#DC143C',
                'darkblue' => '#00008B',
                'darkcyan' => '#008B8B',
                'darkgoldenrod' => '#B8860B',
                'darkgray' => '#A9A9A9',
                'darkgreen' => '#006400',
                'darkkhaki' => '#BDB76B',
                'darkmagenta' => '#8B008B',
                'darkolivegreen' => '#556B2F',
                'darkorange' => '#FF8C00',
                'darkorchid' => '#9932CC',
                'darkred' => '#8B0000',
                'darksalmon' => '#E9967A',
                'darkseagreen' => '#8FBC8F',
                'darkslateblue' => '#483D8B',
                'darkslategray' => '#2F4F4F',
                'darkturquoise' => '#00CED1',
                'darkviolet' => '#9400D3',
                'deeppink' => '#FF1493',
                'deepskyblue' => '#00BFFF',
                'dimgray' => '#696969',
                'dodgerblue' => '#1E90FF',
                'firebrick' => '#B22222',
                'floralwhite' => '#FFFAF0',
                'forestgreen' => '#228B22',
                'magenta' => '#FF00FF',
                'gainsboro' => '#DCDCDC',
                'ghostwhite' => '#F8F8FF',
                'gold' => '#FFD700',
                'goldenrod' => '#DAA520',
                'gray' => '#808080',
                'green' => '#008000',
                'greenyellow' => '#ADFF2F',
                'honeydew' => '#F0FFF0',
                'hotpink' => '#FF69B4',
                'indianred' => '#CD5C5C',
                'indigo' => '#4B0082',
                'ivory' => '#FFFFF0',
                'khaki' => '#F0E68C',
                'lavender' => '#E6E6FA',
                'lavenderblush' => '#FFF0F5',
                'lawngreen' => '#7CFC00',
                'lemonchiffon' => '#FFFACD',
                'lightblue' => '#ADD8E6',
                'lightcoral' => '#F08080',
                'lightcyan' => '#E0FFFF',
                'lightgoldenrodyellow' => '#FAFAD2',
                'lightgray' => '#D3D3D3',
                'lightgreen' => '#90EE90',
                'lightpink' => '#FFB6C1',
                'lightsalmon' => '#FFA07A',
                'lightseagreen' => '#20B2AA',
                'lightskyblue' => '#87CEFA',
                'lightslategray' => '#778899',
                'lightsteelblue' => '#B0C4DE',
                'lightyellow' => '#FFFFE0',
                'lime' => '#00FF00',
                'limegreen' => '#32CD32',
                'linen' => '#FAF0E6',
                'maroon' => '#800000',
                'mediumaquamarine' => '#66CDAA',
                'mediumblue' => '#0000CD',
                'mediumorchid' => '#BA55D3',
                'mediumpurple' => '#9370DB',
                'mediumseagreen' => '#3CB371',
                'mediumslateblue' => '#7B68EE',
                'mediumspringgreen' => '#00FA9A',
                'mediumturquoise' => '#48D1CC',
                'mediumvioletred' => '#C71585',
                'midnightblue' => '#191970',
                'mintcream' => '#F5FFFA',
                'mistyrose' => '#FFE4E1',
                'moccasin' => '#FFE4B5',
                'navajowhite' => '#FFDEAD',
                'navy' => '#000080',
                'oldlace' => '#FDF5E6',
                'olive' => '#808000',
                'olivedrab' => '#6B8E23',
                'orange' => '#FFA500',
                'orangered' => '#FF4500',
                'orchid' => '#DA70D6',
                'palegoldenrod' => '#EEE8AA',
                'palegreen' => '#98FB98',
                'paleturquoise' => '#AFEEEE',
                'palevioletred' => '#DB7093',
                'papayawhip' => '#FFEFD5',
                'peachpuff' => '#FFDAB9',
                'peru' => '#CD853F',
                'pink' => '#FFC0CB',
                'plum' => '#DDA0DD',
                'powderblue' => '#B0E0E6',
                'purple' => '#800080',
                'rebeccapurple' => '#663399',
                'red' => '#FF0000',
                'rosybrown' => '#BC8F8F',
                'royalblue' => '#4169E1',
                'saddlebrown' => '#8B4513',
                'salmon' => '#FA8072',
                'sandybrown' => '#F4A460',
                'seagreen' => '#2E8B57',
                'seashell' => '#FFF5EE',
                'sienna' => '#A0522D',
                'silver' => '#C0C0C0',
                'skyblue' => '#87CEEB',
                'slateblue' => '#6A5ACD',
                'slategray' => '#708090',
                'snow' => '#FFFAFA',
                'springgreen' => '#00FF7F',
                'steelblue' => '#4682B4',
                'tan' => '#D2B48C',
                'teal' => '#008080',
                'thistle' => '#D8BFD8',
                'tomato' => '#FF6347',
                'turquoise' => '#40E0D0',
                'violet' => '#EE82EE',
                'wheat' => '#F5DEB3',
                'white' => '#FFFFFF',
                'whitesmoke' => '#F5F5F5',
                'yellow' => '#FFFF00',
                'yellowgreen' => '#9ACD32',
            );
        }

        $this->assertSame($expected, $options);
    }
}
