<?php

use ACFComposer\ACFComposer;
use Flynt\Utils\Options;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'handbookMeta',
        'title' => 'Handbook Entry',
        'style' => '',
        'menu_order' => 1,
        'position' => 'acf_after_title',
        'fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Short Answer', 'flynt'),
                'instructions' => __('40–60 words. Answer "What is [title]?" in the first sentence, in plain language, so it can be quoted on its own. Shown at the top and used as meta description.', 'flynt'),
                'name' => 'handbookDefinition',
                'type' => 'textarea',
                'rows' => 3,
                'required' => 1,
                'new_lines' => '',
            ],
            [
                'label' => __('Key Takeaways', 'flynt'),
                'instructions' => __('3–5 short, factual statements.', 'flynt'),
                'name' => 'handbookTakeaways',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => __('Add Takeaway', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Takeaway', 'flynt'),
                        'name' => 'text',
                        'type' => 'text',
                    ],
                ],
            ],
            [
                'label' => __('Content', 'flynt'),
                'instructions' => __('Use H2 headings phrased the way people ask (e.g. "How does X work?"). Add numbers, examples and sources where possible.', 'flynt'),
                'name' => 'handbookContent',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => __('FAQ', 'flynt'),
                'name' => 'faqTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Questions', 'flynt'),
                'instructions' => __('Real questions clients ask. Answer each in 1–3 sentences.', 'flynt'),
                'name' => 'handbookFaq',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Add Question', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Question', 'flynt'),
                        'name' => 'question',
                        'type' => 'text',
                    ],
                    [
                        'label' => __('Answer', 'flynt'),
                        'name' => 'answer',
                        'type' => 'textarea',
                        'rows' => 3,
                        'new_lines' => 'br',
                    ],
                ],
            ],
            [
                'label' => __('Meta', 'flynt'),
                'name' => 'metaTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Last Reviewed', 'flynt'),
                'instructions' => __('Update when the content is checked. Shown on the page and in structured data.', 'flynt'),
                'name' => 'handbookReviewed',
                'type' => 'date_picker',
                'display_format' => 'd.m.y',
                'return_format' => 'Y-m-d',
                'first_day' => 1,
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Author', 'flynt'),
                'name' => 'handbookAuthor',
                'type' => 'text',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Related Entries', 'flynt'),
                'name' => 'handbookRelated',
                'type' => 'relationship',
                'post_type' => ['handbook'],
                'filters' => ['search'],
                'return_format' => 'id',
                'max' => 6,
            ],
            [
                'label' => __('Related Service', 'flynt'),
                'instructions' => __('Optional link to the matching service or case study.', 'flynt'),
                'name' => 'handbookCta',
                'type' => 'link',
                'return_format' => 'array',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'handbook',
                ],
            ],
        ],
    ]);

    Options::addTranslatable('Handbook', [
        [
            'label' => __('Call to Action Title', 'flynt'),
            'name' => 'ctaTitle',
            'type' => 'text',
        ],
        [
            'label' => __('Call to Action Link', 'flynt'),
            'name' => 'ctaLink',
            'type' => 'link',
            'return_format' => 'array',
        ],
    ]);
});
