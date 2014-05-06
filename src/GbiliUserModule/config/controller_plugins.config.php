<?php
namesapace GbiliUserModule;
return array(
    'invokables' => array(
        'actionNonceDelete' => __NAMESPACE__ . '\Controller\Plugin\NonceDeleteAction',
    ),
    'factories' => array(
        'nonce' => function ($controllerPluginManager) {
            $sm = $controllerPluginManager->getServiceLocator();
            $service = $sm->get('User\Service\Nonce');
            $plugin = new Controller\Plugin\Nonce;
            $plugin->setService($service);
            return $plugin;
        },
    ),
);
