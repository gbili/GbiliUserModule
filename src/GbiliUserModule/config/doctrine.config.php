<?php
namespace GbiliUserModule;
return array(
   'authentication' => array(
       'orm_default' => array(
           'object_manager' => 'Doctrine\ORM\EntityManager',
           'identity_class' => 'User\Entity\User',
           'identity_property' => 'email',
           'credential_property' => 'password',
           'credential_callable' => function (\User\Entity\User $user, $passwordGiven) {
               return $user->isThisPassword($passwordGiven);
           },
       ),
   ),
   'driver' => array(
        __NAMESPACE__ . '_driver' => array(
            'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            'cache' => 'array',
            'paths' => array(
                __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
            ),
        ),
        'orm_default' => array(
            'drivers' => array(
                __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
            ),
        ),
    ),
);
