<?php
namesapace GbiliUserModule;
return array(
    'routes' => array(
        'auth_login' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '[/:lang]/login',
                'constraints' => array(
                    'lang' => $preConfig['regex_patterns']['lang'],
                ),
                'defaults' => array(
                    'lang' => 'en',
                    'controller' => 'auth',
                    'action' => 'login',
                ),
            ),
        ),
        'auth_recoverpassword' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '[/:lang]/recover',
                'constraints' => array(
                    'lang' => $preConfig['regex_patterns']['lang'],
                ),
                'defaults' => array(
                    'lang' => 'en',
                    'controller' => 'auth',
                    'action' => 'recoverpassword',
                ),
            ),
        ),
        'auth_register' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '[/:lang]/register',
                'constraints' => array(
                    'lang' => $preConfig['regex_patterns']['lang'],
                ),
                'defaults' => array(
                    'lang' => 'en',
                    'controller' => 'auth',
                    'action' => 'register',
                ),
            ),
        ),
        'auth_logout' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '[/:lang]/logout',
                'constraints' => array(
                    'lang' => $preConfig['regex_patterns']['lang'],
                ),
                'defaults' => array(
                    'lang' => 'en',
                    'controller' => 'auth',
                    'action' => 'logout',
                ),
            ),
        ),
        'admin_index' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '[/:lang]/admin[/]',
                'constraints' => array(
                    'lang' => $preConfig['regex_patterns']['lang'],
                ),
                'defaults' => array(
                    'lang' => 'en',
                    'controller' => 'admin',
                    'action' => 'index',
                ),
            ),
        ),
        'admin_edit' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '[/:lang]/admin/edit[/:id]',
                'constraints' => array(
                    'lang' => $preConfig['regex_patterns']['lang'],
                    'id' => $preConfig['regex_patterns']['id'],
                ),
                'defaults' => array(
                    'lang' => 'en',
                    'controller' => 'admin',
                    'action' => 'edit',
                ),
            ),
        ),
        'admin_delete' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '[/:lang]/admin/delete/:id',
                'constraints' => array(
                    'lang' => $preConfig['regex_patterns']['lang'],
                    'id' => $preConfig['regex_patterns']['id'],
                ),
                'defaults' => array(
                    'lang' => 'en',
                    'controller' => 'admin',
                    'action' => 'delete',
                ),
            ),
        ),
        'profile_edit' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '[/:lang]/profile/edit/:uniquename',
                'constraints' => array(
                    'lang' => $preConfig['regex_patterns']['lang'],
                    'uniquename' => $preConfig['regex_patterns']['uniquename'],
                ),
                'defaults' => array(
                    'lang' => 'en',
                    'controller' => 'gbiliuser_profile_controller',
                    'action' => 'edit',
                    'uniquename' => false,
                ),
            ),
        ),
        //displays logged in user data
        'profile_private' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '[/:lang]/profile',
                'constraints' => array(
                    'lang' => $preConfig['regex_patterns']['lang'],
                ),
                'defaults' => array(
                    'lang' => 'en',
                    'controller' => 'gbiliuser_profile_controller',
                    'action' => 'private',
                ),
            ),
        ),
        //displays uniquename user restricted set of data
        'profile_publicly_available' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '[/:lang]/profile/:uniquename',
                'constraints' => array(
                    'lang' => $preConfig['regex_patterns']['lang'],
                    'uniquename' => $preConfig['regex_patterns']['uniquename'],
                ),
                'defaults' => array(
                    'lang' => 'en',
                    'controller' => 'gbiliuser_profile_controller',
                    'action' => 'public',
                    'uniquename' => false,
                ),
            ),
        ),
        //displays uniquename profile of friend 
/*        'profile_of_friend' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '[/:lang]/friend/:uniquename',
                'constraints' => array(
                    'lang' => $preConfig['regex_patterns']['lang'],
                    'uniquename' => $preConfig['regex_patterns']['uniquename'],
                ),
                'defaults' => array(
                    'lang' => 'en',
                    'controller' => 'gbiliuser_profile_controller',
                    'action' => 'index',
                    'uniquename' => false,
                ),
            ),
        ), */
        'profile_list' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '[/:lang]/profiles',
                'constraints' => array(
                    'lang' => $preConfig['regex_patterns']['lang'],
                ),
                'defaults' => array(
                    'lang' => 'en',
                    'controller' => 'gbiliuser_profile_controller',
                    'action' => 'list',
                ),
            ),
        ),
    ),
);
