<?php
namesapace GbiliUserModule;

return array(
    'gbiliuser_profile_controller' => array(
        'alias' => 'ajax_media_upload',
        'controller_plugin' => array(
            'route_success' => array(
                'route'                => 'profile_edit',
                'reuse_matched_params' => true,
            ),
        ),
    ),
);
