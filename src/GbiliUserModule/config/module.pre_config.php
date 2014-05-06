<?php
namespace GbiliUserModule;
return array(
    'regex_patterns' => array(
        'lang'       => '(?:en)|(?:es)|(?:fr)|(?:de)|(?:it)',
        'id'         => '[0-9]+',
        'uniquename' => '[A-Za-z0-9](?:[-_.]?[A-Za-z0-9]){3,}', //'[A-Za-z0-9]+(?:[-_.]?[A-Za-z0-9]+){3,}',
    ),
);
