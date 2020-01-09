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

namespace Sonata\CoreBundle\Color;

@trigger_error(
    'The '.__NAMESPACE__.'\Colors class is deprecated since version 3.10 and will be removed in 4.0.',
    E_USER_DEPRECATED
);

/**
 * NEXT_MAJOR: remove this class.
 *
 * @deprecated since sonata-project/core-bundle 3.10, to be removed in 4.0.
 *
 * Handles A list of all HTML colors.
 * @see http://www.w3schools.com/HTML/html_colornames.asp
 *
 * @author Quentin Somazzi <qsomazzi@ekino.com>
 */
class Colors
{
    public const ALICEBLUE = '#F0F8FF';
    public const ANTIQUEWHITE = '#FAEBD7';
    public const AQUA = '#00FFFF';
    public const AQUAMARINE = '#7FFFD4';
    public const AZURE = '#F0FFFF';
    public const BEIGE = '#F5F5DC';
    public const BISQUE = '#FFE4C4';
    public const BLACK = '#000000';
    public const BLANCHEDALMOND = '#FFEBCD';
    public const BLUE = '#0000FF';
    public const BLUEVIOLET = '#8A2BE2';
    public const BROWN = '#A52A2A';
    public const BURLYWOOD = '#DEB887';
    public const CADETBLUE = '#5F9EA0';
    public const CHARTREUSE = '#7FFF00';
    public const CHOCOLATE = '#D2691E';
    public const CORAL = '#FF7F50';
    public const CORNFLOWERBLUE = '#6495ED';
    public const CORNSILK = '#FFF8DC';
    public const CRIMSON = '#DC143C';
    public const CYAN = '#00FFFF';
    public const DARKBLUE = '#00008B';
    public const DARKCYAN = '#008B8B';
    public const DARKGOLDENROD = '#B8860B';
    public const DARKGRAY = '#A9A9A9';
    public const DARKGREEN = '#006400';
    public const DARKKHAKI = '#BDB76B';
    public const DARKMAGENTA = '#8B008B';
    public const DARKOLIVEGREEN = '#556B2F';
    public const DARKORANGE = '#FF8C00';
    public const DARKORCHID = '#9932CC';
    public const DARKRED = '#8B0000';
    public const DARKSALMON = '#E9967A';
    public const DARKSEAGREEN = '#8FBC8F';
    public const DARKSLATEBLUE = '#483D8B';
    public const DARKSLATEGRAY = '#2F4F4F';
    public const DARKTURQUOISE = '#00CED1';
    public const DARKVIOLET = '#9400D3';
    public const DEEPPINK = '#FF1493';
    public const DEEPSKYBLUE = '#00BFFF';
    public const DIMGRAY = '#696969';
    public const DODGERBLUE = '#1E90FF';
    public const FIREBRICK = '#B22222';
    public const FLORALWHITE = '#FFFAF0';
    public const FORESTGREEN = '#228B22';
    public const FUCHSIA = '#FF00FF';
    public const GAINSBORO = '#DCDCDC';
    public const GHOSTWHITE = '#F8F8FF';
    public const GOLD = '#FFD700';
    public const GOLDENROD = '#DAA520';
    public const GRAY = '#808080';
    public const GREEN = '#008000';
    public const GREENYELLOW = '#ADFF2F';
    public const HONEYDEW = '#F0FFF0';
    public const HOTPINK = '#FF69B4';
    public const INDIANRED = '#CD5C5C';
    public const INDIGO = '#4B0082';
    public const IVORY = '#FFFFF0';
    public const KHAKI = '#F0E68C';
    public const LAVENDER = '#E6E6FA';
    public const LAVENDERBLUSH = '#FFF0F5';
    public const LAWNGREEN = '#7CFC00';
    public const LEMONCHIFFON = '#FFFACD';
    public const LIGHTBLUE = '#ADD8E6';
    public const LIGHTCORAL = '#F08080';
    public const LIGHTCYAN = '#E0FFFF';
    public const LIGHTGOLDENRODYELLOW = '#FAFAD2';
    public const LIGHTGRAY = '#D3D3D3';
    public const LIGHTGREEN = '#90EE90';
    public const LIGHTPINK = '#FFB6C1';
    public const LIGHTSALMON = '#FFA07A';
    public const LIGHTSEAGREEN = '#20B2AA';
    public const LIGHTSKYBLUE = '#87CEFA';
    public const LIGHTSLATEGRAY = '#778899';
    public const LIGHTSTEELBLUE = '#B0C4DE';
    public const LIGHTYELLOW = '#FFFFE0';
    public const LIME = '#00FF00';
    public const LIMEGREEN = '#32CD32';
    public const LINEN = '#FAF0E6';
    public const MAGENTA = '#FF00FF';
    public const MAROON = '#800000';
    public const MEDIUMAQUAMARINE = '#66CDAA';
    public const MEDIUMBLUE = '#0000CD';
    public const MEDIUMORCHID = '#BA55D3';
    public const MEDIUMPURPLE = '#9370DB';
    public const MEDIUMSEAGREEN = '#3CB371';
    public const MEDIUMSLATEBLUE = '#7B68EE';
    public const MEDIUMSPRINGGREEN = '#00FA9A';
    public const MEDIUMTURQUOISE = '#48D1CC';
    public const MEDIUMVIOLETRED = '#C71585';
    public const MIDNIGHTBLUE = '#191970';
    public const MINTCREAM = '#F5FFFA';
    public const MISTYROSE = '#FFE4E1';
    public const MOCCASIN = '#FFE4B5';
    public const NAVAJOWHITE = '#FFDEAD';
    public const NAVY = '#000080';
    public const OLDLACE = '#FDF5E6';
    public const OLIVE = '#808000';
    public const OLIVEDRAB = '#6B8E23';
    public const ORANGE = '#FFA500';
    public const ORANGERED = '#FF4500';
    public const ORCHID = '#DA70D6';
    public const PALEGOLDENROD = '#EEE8AA';
    public const PALEGREEN = '#98FB98';
    public const PALETURQUOISE = '#AFEEEE';
    public const PALEVIOLETRED = '#DB7093';
    public const PAPAYAWHIP = '#FFEFD5';
    public const PEACHPUFF = '#FFDAB9';
    public const PERU = '#CD853F';
    public const PINK = '#FFC0CB';
    public const PLUM = '#DDA0DD';
    public const POWDERBLUE = '#B0E0E6';
    public const PURPLE = '#800080';
    public const REBECCAPURPLE = '#663399';
    public const RED = '#FF0000';
    public const ROSYBROWN = '#BC8F8F';
    public const ROYALBLUE = '#4169E1';
    public const SADDLEBROWN = '#8B4513';
    public const SALMON = '#FA8072';
    public const SANDYBROWN = '#F4A460';
    public const SEAGREEN = '#2E8B57';
    public const SEASHELL = '#FFF5EE';
    public const SIENNA = '#A0522D';
    public const SILVER = '#C0C0C0';
    public const SKYBLUE = '#87CEEB';
    public const SLATEBLUE = '#6A5ACD';
    public const SLATEGRAY = '#708090';
    public const SNOW = '#FFFAFA';
    public const SPRINGGREEN = '#00FF7F';
    public const STEELBLUE = '#4682B4';
    public const TAN = '#D2B48C';
    public const TEAL = '#008080';
    public const THISTLE = '#D8BFD8';
    public const TOMATO = '#FF6347';
    public const TURQUOISE = '#40E0D0';
    public const VIOLET = '#EE82EE';
    public const WHEAT = '#F5DEB3';
    public const WHITE = '#FFFFFF';
    public const WHITESMOKE = '#F5F5F5';
    public const YELLOW = '#FFFF00';
    public const YELLOWGREEN = '#9ACD32';

    /**
     * Return the list of colors.
     *
     * @return array
     */
    public static function getAll()
    {
        return [
            self::ALICEBLUE => 'aliceblue',
            self::ANTIQUEWHITE => 'antiquewhite',
            self::AQUA => 'aqua',
            self::AQUAMARINE => 'aquamarine',
            self::AZURE => 'azure',
            self::BEIGE => 'beige',
            self::BISQUE => 'bisque',
            self::BLACK => 'black',
            self::BLANCHEDALMOND => 'blanchedalmond',
            self::BLUE => 'blue',
            self::BLUEVIOLET => 'blueviolet',
            self::BROWN => 'brown',
            self::BURLYWOOD => 'burlywood',
            self::CADETBLUE => 'cadetblue',
            self::CHARTREUSE => 'chartreuse',
            self::CHOCOLATE => 'chocolate',
            self::CORAL => 'coral',
            self::CORNFLOWERBLUE => 'cornflowerblue',
            self::CORNSILK => 'cornsilk',
            self::CRIMSON => 'crimson',
            self::CYAN => 'cyan',
            self::DARKBLUE => 'darkblue',
            self::DARKCYAN => 'darkcyan',
            self::DARKGOLDENROD => 'darkgoldenrod',
            self::DARKGRAY => 'darkgray',
            self::DARKGREEN => 'darkgreen',
            self::DARKKHAKI => 'darkkhaki',
            self::DARKMAGENTA => 'darkmagenta',
            self::DARKOLIVEGREEN => 'darkolivegreen',
            self::DARKORANGE => 'darkorange',
            self::DARKORCHID => 'darkorchid',
            self::DARKRED => 'darkred',
            self::DARKSALMON => 'darksalmon',
            self::DARKSEAGREEN => 'darkseagreen',
            self::DARKSLATEBLUE => 'darkslateblue',
            self::DARKSLATEGRAY => 'darkslategray',
            self::DARKTURQUOISE => 'darkturquoise',
            self::DARKVIOLET => 'darkviolet',
            self::DEEPPINK => 'deeppink',
            self::DEEPSKYBLUE => 'deepskyblue',
            self::DIMGRAY => 'dimgray',
            self::DODGERBLUE => 'dodgerblue',
            self::FIREBRICK => 'firebrick',
            self::FLORALWHITE => 'floralwhite',
            self::FORESTGREEN => 'forestgreen',
            self::FUCHSIA => 'fuchsia',
            self::GAINSBORO => 'gainsboro',
            self::GHOSTWHITE => 'ghostwhite',
            self::GOLD => 'gold',
            self::GOLDENROD => 'goldenrod',
            self::GRAY => 'gray',
            self::GREEN => 'green',
            self::GREENYELLOW => 'greenyellow',
            self::HONEYDEW => 'honeydew',
            self::HOTPINK => 'hotpink',
            self::INDIANRED => 'indianred',
            self::INDIGO => 'indigo',
            self::IVORY => 'ivory',
            self::KHAKI => 'khaki',
            self::LAVENDER => 'lavender',
            self::LAVENDERBLUSH => 'lavenderblush',
            self::LAWNGREEN => 'lawngreen',
            self::LEMONCHIFFON => 'lemonchiffon',
            self::LIGHTBLUE => 'lightblue',
            self::LIGHTCORAL => 'lightcoral',
            self::LIGHTCYAN => 'lightcyan',
            self::LIGHTGOLDENRODYELLOW => 'lightgoldenrodyellow',
            self::LIGHTGRAY => 'lightgray',
            self::LIGHTGREEN => 'lightgreen',
            self::LIGHTPINK => 'lightpink',
            self::LIGHTSALMON => 'lightsalmon',
            self::LIGHTSEAGREEN => 'lightseagreen',
            self::LIGHTSKYBLUE => 'lightskyblue',
            self::LIGHTSLATEGRAY => 'lightslategray',
            self::LIGHTSTEELBLUE => 'lightsteelblue',
            self::LIGHTYELLOW => 'lightyellow',
            self::LIME => 'lime',
            self::LIMEGREEN => 'limegreen',
            self::LINEN => 'linen',
            self::MAGENTA => 'magenta',
            self::MAROON => 'maroon',
            self::MEDIUMAQUAMARINE => 'mediumaquamarine',
            self::MEDIUMBLUE => 'mediumblue',
            self::MEDIUMORCHID => 'mediumorchid',
            self::MEDIUMPURPLE => 'mediumpurple',
            self::MEDIUMSEAGREEN => 'mediumseagreen',
            self::MEDIUMSLATEBLUE => 'mediumslateblue',
            self::MEDIUMSPRINGGREEN => 'mediumspringgreen',
            self::MEDIUMTURQUOISE => 'mediumturquoise',
            self::MEDIUMVIOLETRED => 'mediumvioletred',
            self::MIDNIGHTBLUE => 'midnightblue',
            self::MINTCREAM => 'mintcream',
            self::MISTYROSE => 'mistyrose',
            self::MOCCASIN => 'moccasin',
            self::NAVAJOWHITE => 'navajowhite',
            self::NAVY => 'navy',
            self::OLDLACE => 'oldlace',
            self::OLIVE => 'olive',
            self::OLIVEDRAB => 'olivedrab',
            self::ORANGE => 'orange',
            self::ORANGERED => 'orangered',
            self::ORCHID => 'orchid',
            self::PALEGOLDENROD => 'palegoldenrod',
            self::PALEGREEN => 'palegreen',
            self::PALETURQUOISE => 'paleturquoise',
            self::PALEVIOLETRED => 'palevioletred',
            self::PAPAYAWHIP => 'papayawhip',
            self::PEACHPUFF => 'peachpuff',
            self::PERU => 'peru',
            self::PINK => 'pink',
            self::PLUM => 'plum',
            self::POWDERBLUE => 'powderblue',
            self::PURPLE => 'purple',
            self::REBECCAPURPLE => 'rebeccapurple',
            self::RED => 'red',
            self::ROSYBROWN => 'rosybrown',
            self::ROYALBLUE => 'royalblue',
            self::SADDLEBROWN => 'saddlebrown',
            self::SALMON => 'salmon',
            self::SANDYBROWN => 'sandybrown',
            self::SEAGREEN => 'seagreen',
            self::SEASHELL => 'seashell',
            self::SIENNA => 'sienna',
            self::SILVER => 'silver',
            self::SKYBLUE => 'skyblue',
            self::SLATEBLUE => 'slateblue',
            self::SLATEGRAY => 'slategray',
            self::SNOW => 'snow',
            self::SPRINGGREEN => 'springgreen',
            self::STEELBLUE => 'steelblue',
            self::TAN => 'tan',
            self::TEAL => 'teal',
            self::THISTLE => 'thistle',
            self::TOMATO => 'tomato',
            self::TURQUOISE => 'turquoise',
            self::VIOLET => 'violet',
            self::WHEAT => 'wheat',
            self::WHITE => 'white',
            self::WHITESMOKE => 'whitesmoke',
            self::YELLOW => 'yellow',
            self::YELLOWGREEN => 'yellowgreen',
        ];
    }
}
