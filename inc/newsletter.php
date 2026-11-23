<?php

/**
 * Newsletter sign-up (Brevo).
 *
 * The form markup lives in templates/Partials/_newsletter.twig and is used by
 * NavigationFooter, BlockWysiwygColumns and BlockWysiwygAccordion when
 * "Enable Newsletter Form" is on. The Brevo form URL is set once under
 * Global Options → Newsletter.
 */

namespace Flynt\Newsletter;

use Flynt\Utils\Options;
use Twig\TwigFunction;

Options::addGlobal('Newsletter', [
    [
        'label' => __('Brevo Form URL', 'flynt'),
        'instructions' => __('In Brevo: Contacts → Forms → open the sign-up form → Share → "Embed code". Copy the URL from the form\'s action="…" attribute (it looks like https://xxxx.sibforms.com/serve/…). If empty, the newsletter form is hidden.', 'flynt'),
        'name' => 'brevoFormUrl',
        'type' => 'url',
        'placeholder' => 'https://xxxx.sibforms.com/serve/…',
    ],
    [
        'label' => __('Placeholder', 'flynt'),
        'name' => 'placeholder',
        'type' => 'text',
        'default_value' => 'Your email',
        'wrapper' => ['width' => 50],
    ],
    [
        'label' => __('Button Label', 'flynt'),
        'name' => 'buttonLabel',
        'type' => 'text',
        'default_value' => 'Send',
        'wrapper' => ['width' => 50],
    ],
    [
        'label' => __('Success Message', 'flynt'),
        'name' => 'successMessage',
        'type' => 'text',
        'default_value' => 'Thank you! Please check your inbox to confirm your subscription.',
        'wrapper' => ['width' => 50],
    ],
    [
        'label' => __('Error Message', 'flynt'),
        'name' => 'errorMessage',
        'type' => 'text',
        'default_value' => 'Something went wrong. Please try again.',
        'wrapper' => ['width' => 50],
    ],
]);

add_filter('timber/twig', function ($twig) {
    $twig->addFunction(new TwigFunction('newsletter_options', function () {
        $options = Options::getGlobal('Newsletter') ?: [];
        return [
            'formUrl' => $options['brevoFormUrl'] ?? '',
            'placeholder' => ($options['placeholder'] ?? '') ?: 'Your email',
            'buttonLabel' => ($options['buttonLabel'] ?? '') ?: 'Send',
            'successMessage' => ($options['successMessage'] ?? '') ?: 'Thank you! Please check your inbox to confirm your subscription.',
            'errorMessage' => ($options['errorMessage'] ?? '') ?: 'Something went wrong. Please try again.',
            'locale' => substr(get_locale(), 0, 2),
        ];
    }));
    return $twig;
});
