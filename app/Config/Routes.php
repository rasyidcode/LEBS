<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/api/v1/testRoute', 'API\User::testRoute');

// Web
$routes->group('user', function($routes)
{
	$routes->get('verification', 'WEB\User::verificationView');
	$routes->get('verification/template', 'WEB\User::emailTemplate');
});

// API
$routes->group('api', function($routes)
{
	$routes->group('v1', function($routes)
	{
		// Test route
		$routes->group('test', function($routes)
		{
			$routes->post('sendMail', 'API\Test::sendMail');
			$routes->get('testCaesarCipher_Encrypt', 'API\Test::testCaesarCipherEncrypt');
			$routes->get('testCaesarCipher_Decrypt', 'API\Test::testCaesarCipherDecrypt');
			$routes->get('testChiperAlgorithm', 'API\Test::testChiperAlgorithm');
			$routes->get('testDecryptUsernameFromEmail', 'API\Test::testDecryptUsernameFromEmail');
			$routes->get('testEnvironment', 'API\Test::testEnvironment');
		});

		// User route
		$routes->group('user', function($routes)
		{
			$routes->post('signIn', 'API\User::signIn');
			$routes->post('signUp', 'API\User::signUp');
			$routes->get('me', 'API\User::profile');
			$routes->post('forgotPassword', 'API\User::forgotPassword');
		});
	});
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
