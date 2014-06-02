<?php
namespace GbiliUserModule;
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
        ),
    ),

    'controller_plugins'       => include __DIR__ . '/controller_plugins.config.php',
    'controllers'              => include __DIR__ . '/controllers.config.php',
    'doctrine'                 => include __DIR__ . '/doctrine.config.php',
    'doctrine_event_listeners' => include __DIR__ . '/doctrine_event_listeners.config.php',
    'navigation'               => include __DIR__ . '/navigation.config.php', 
    'router'                   => include __DIR__ . '/router.config.php',
    'service_manager'          => include __DIR__ . '/service_manager.config.php',
    'translator'               => include __DIR__ . '/translator.config.php',
    'file_uploader'            => include __DIR__ . '/file_uploader.config.php',
    'view_helpers'             => include __DIR__ . '/view_helpers.config.php',
);
