<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     		=> \CodeIgniter\Filters\CSRF::class,
		'toolbar'  		=> \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' 		=> \CodeIgniter\Filters\Honeypot::class,
		'authFilter'	=> \App\Filters\AuthFilter::class,
		'signInFilter'	=> \App\Filters\SignInFilter::class,
		'signUpFilter'	=> \App\Filters\SignUpFilter::class,
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			//'honeypot'
			// 'csrf',
		],
		'after'  => [
			'toolbar',
			//'honeypot'
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
	public $filters = [
		'authFilter' => [
			'before'	=> [
				'api/v1/user/profile'
			]
		],
		'signInFilter' => [
			'before' => [
				'api/v1/user/signIn'
			]
		],
		'signUpFilter'	=> [
			'before'	=> [
				'api/v1/user/signUp'
			]
		]
	];
}
