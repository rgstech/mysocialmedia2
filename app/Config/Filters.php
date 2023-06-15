<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
    //  'invalidchars'  => InvalidChars::class,
    //  'secureheaders' => SecureHeaders::class,
		    'cors'     => \App\Filters\Cors::class,
		    'auth'     => \App\Filters\Auth::class,
		    'authjwt'  => \App\Filters\AuthJwtFilter::class
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
 	public $globals = [
		'before' => [
                     'cors',
                     'auth' => [ 'except' => [  'login/*', 
                                                'login/',
                                                 'account/signup',
                                                 'account/signup/*',
                                                 'account/createaccount',
                                                 'account/createaccount/*',  //exceção para pagina de login, pois e necessario logar pra autenticar
					                                       'account/testsucess/*',
                                                 'account/testsucess/',
                                                 'api/', 
                                                 'api/*', 
                                                 '/webservice/login/*', 
                                                 '/webservice/login',
												                         'closure/',
												                         'closure/*' ] 
                                ],   //exceção para api, pois sera autenticada com jwt
	              'honeypot',
		            'csrf', 
		],
		'after'  => [
			'toolbar',
		  'honeypot',
		],
	];
    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    	public $filters = [ 'authjwt'  => [ 'before' => [ 'api/*',
			                                                  'api/' 
                                                      ],
                                        ]
                        ];
}
