<?php
namespace GbiliUserModule;

return array(
    'gbiliuser_profile_controller' => array(
        'alias' => 'ajax_media_upload',
        'controller_plugin' => array(
            'route_success' => array(
                'route'                => 'profile_edit',
                'reuse_matched_params' => true,
            ),
        ),
        // Override some profile controller actions 
        'action_override' => array(
            'edit' => array( //tell uploader to set the form route to different than controller
                'view_helper' => array(
                    //overrides the on success, to add medias to wall
                    'include_packaged_js_script_from_basename' => 'image_picker_aware_media_upload.js.phtml', 
                ),
            ),
        ), 
    ),
);
