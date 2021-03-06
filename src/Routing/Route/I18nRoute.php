<?php
declare(strict_types=1);

namespace ADmad\I18n\Routing\Route;

use Cake\Core\Configure;
use Cake\Routing\Route\DashedRoute;
use Cake\Utility\Hash;

class I18nRoute extends DashedRoute
{
    /**
     * Regular expression for `lang` route element.
     *
     * @var string|null
     */
    protected static $_langRegEx = null;

    /**
     * Constructor for a Route.
     *
     * @param string $template Template string with parameter placeholders
     * @param array $defaults Array of defaults for the route.
     * @param array $options Array of parameters and additional options for the Route
     * @return void
     */
    public function __construct(string $template, array $defaults = [], array $options = [])
    {
        if (strpos($template, '{lang}') === false) {
            $template = '/{lang}' . $template;
        }
        if ($template === '/{lang}/') {
            $template = '/{lang}';
        }

        $options['inflect'] = 'dasherize';
        $options['persist'][] = 'lang';

        if (!array_key_exists('lang', $options)) {
            $langs = Configure::read('I18n.languages');
            if (self::$_langRegEx === null && $langs) {
                self::$_langRegEx = implode('|', array_keys(Hash::normalize($langs)));
            }
            $options['lang'] = self::$_langRegEx;
        }

        parent::__construct($template, $defaults, $options);
    }
}
