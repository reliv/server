<?php
/**
 * config.php
 */
return [
    'dependencies' => [
        'factories' => [
            \Reliv\Server\Entity\Environment::class => \Reliv\Server\Factory\Environment::class
        ],
    ],
];
