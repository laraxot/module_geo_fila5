<?php

declare(strict_types=1);

return [
    'fields' => [
        'dal' => [
            'label' => 'dal',
            'description' => 'dal',
            'helper_text' => '',
            'placeholder' => 'dal',
        ],
        'al' => [
            'label' => 'al',
            'description' => 'al',
            'helper_text' => '',
            'placeholder' => 'al',
        ],
        'note' => [
            'description' => '',
            'helper_text' => '',
            'label' => 'Compiti con Responsabilità Procedimentale di Coordinamento (minimo 2 addetti)',
            'label1' => 'Descrivere meglio compiti che comportano la responsabilità',
            'placeholder' => '',
        ],
        'ratings' => [
            12 => [
                'pivot' => [
                    'value' => [
                        'description' => 'ratings.12.pivot.value',
                        'helper_text' => 'ratings.12.pivot.value',
                        'placeholder' => 'ratings.12.pivot.value',
                        'label' => 'ratings.12.pivot.value',
                    ],
                ],
            ],
            11 => [
                'pivot' => [
                    'value' => [
                        'description' => 'ratings.11.pivot.value',
                        'helper_text' => 'ratings.11.pivot.value',
                        'placeholder' => 'ratings.11.pivot.value',
                        'label' => 'ratings.11.pivot.value',
                    ],
                ],
            ],
            3 => [
                'pivot' => [
                    'value' => [
                        'description' => 'ratings.3.pivot.value',
                        'helper_text' => 'ratings.3.pivot.value',
                        'placeholder' => 'ratings.3.pivot.value',
                        'label' => 'ratings.3.pivot.value',
                    ],
                ],
            ],
            4 => [
                'pivot' => [
                    'value' => [
                        'description' => 'ratings.4.pivot.value',
                        'helper_text' => 'ratings.4.pivot.value',
                        'placeholder' => 'ratings.4.pivot.value',
                        'label' => 'ratings.4.pivot.value',
                    ],
                ],
            ],
            10 => [
                'pivot' => [
                    'value' => [
                        'description' => 'ratings.10.pivot.value',
                        'helper_text' => 'ratings.10.pivot.value',
                        'placeholder' => 'ratings.10.pivot.value',
                        'label' => 'ratings.10.pivot.value',
                    ],
                ],
            ],
            9 => [
                'pivot' => [
                    'value' => [
                        'description' => 'ratings.9.pivot.value',
                        'helper_text' => 'ratings.9.pivot.value',
                        'placeholder' => 'ratings.9.pivot.value',
                        'label' => 'ratings.9.pivot.value',
                    ],
                ],
            ],
            7 => [
                'pivot' => [
                    'value' => [
                        'description' => 'ratings.7.pivot.value',
                        'helper_text' => 'ratings.7.pivot.value',
                        'placeholder' => 'ratings.7.pivot.value',
                        'label' => 'ratings.7.pivot.value',
                    ],
                ],
            ],
            6 => [
                'pivot' => [
                    'value' => [
                        'description' => 'ratings.6.pivot.value',
                        'helper_text' => 'ratings.6.pivot.value',
                        'placeholder' => 'ratings.6.pivot.value',
                        'label' => 'ratings.6.pivot.value',
                    ],
                ],
            ],
            5 => [
                'pivot' => [
                    'value' => [
                        'description' => 'ratings.5.pivot.value',
                        'helper_text' => 'ratings.5.pivot.value',
                        'placeholder' => 'ratings.5.pivot.value',
                        'label' => 'ratings.5.pivot.value',
                    ],
                ],
            ],
        ],
    ],
    'sections' => [
        'empty' => [
            'heading' => 'empty',
            'label' => 'empty',
        ],
        'Risultati' => [
            'heading' => 'Risultati',
            'label' => 'Risultati',
        ],
    ],
    'actions' => [
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'back' => [
            'tooltip' => 'back',
        ],
    ],
    'title' => 'compila indennita responsabilita',
];
