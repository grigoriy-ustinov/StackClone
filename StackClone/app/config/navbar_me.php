<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [
			'Home' => [
            'text'  =>'Home', 
            'url'   =>'',  
            'title' => 'Home'
        ],

		'Questions' => [
            'text'  =>'Questions', 
            'url'   =>'questions',  
            'title' =>'Questions'
        ],
		'About' => [
            'text'  =>'About', 
            'url'   =>'about',  
            'title' =>'About'
        ],
		'Tags' => [
			'text'  =>'Tags',
			'url'   =>'tags',
			'title' =>'Tags',
		],
        'Source' => [
            'text'  =>'Source', 
            'url'   =>'source',  
            'title' => 'Source'
        ],
    ],
 
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function($url) {
        if ($url == $this->di->get('request')->getRoute()) {
            return true;
        }
    },

    // Callback to create the urls
    'create_url' => function($url) {
        return $this->di->get('url')->create($url);
    },
];
