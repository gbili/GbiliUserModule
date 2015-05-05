<?php
namespace GbiliUserModule;
return array(
    'invokables' => array(
        'GbiliUserModule\Service\Nonce' => __NAMESPACE__ . '\Service\Nonce',
    ),

    'factories' => array(
        'gbili_user_navigation' => __NAMESPACE__ . '\Service\PublicUserNavigationFactory',
        'Zend\Authentication\AuthenticationService' => function ($sm) {
            return $sm->get('doctrine.authenticationservice.orm_default');
        },
    ),
);
