<?php

use Timber\Timber;

$context = Timber::context();
$context['handbook'] = Flynt\Handbook\getSingleContext($context['post']);

Timber::render('templates/single-handbook.twig', $context);
