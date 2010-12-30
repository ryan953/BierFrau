<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */


	Router::parseExtensions('json', 'jqt', 'jqm');
/*
	Router::connect('/',
		array('controller' => 'pages', 'action' => 'display', 'calculator')
	);
	Router::connect('/about',
		array('controller' => 'pages', 'action' => 'display', 'about')
	);
	Router::connect('/calc',
		array('controller' => 'pages', 'action' => 'display', 'calculator')
	);

	Router::connect('/home',
		array('controller' => 'brands', 'action'=>'index')
	);

	Router::connect('/beers/:slug',
		array('controller' => 'pages', 'action' => 'display', 'browser'),
		array('pass'=>'slug')
	);
*/

Router::connect('/',
	array('controller' => 'mobile', 'action' => 'home')
);
/*Router::connect('/offline',
	array('controller' => 'mobile', 'action' => 'offline')
);
Router::connect('/cache.manifest',
	array('controller' => 'mobile', 'action' => 'cache_manifest')
);*/

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*',
		array('controller' => 'pages', 'action' => 'display')
	);


/**
 * API routes
 */

Router::connect('/:controller/:id',
	array('action' => 'view'),
	array('id'=>'[0-9]+')
);

Router::connect('/brewers/:brewer_id/brands',
	array('controller'=>'brands', 'action'=>'index_byBrewer'),
	array('brewer_id'=>'[0-9]+')
);

Router::connect('/packages/:package_id/prices',
	array('controller'=>'prices', 'action'=>'index_byPackage'),
	array('package_id'=>'[0-9]+')
);
Router::connect('/brands/:brand_id/prices',
	array('controller'=>'prices', 'action'=>'index_byBrand'),
	array('brand_id'=>'[0-9]+')
);
Router::connect('/brands/:brand_id/packages/:package_id/prices',
	array('controller'=>'prices', 'action'=>'index_byBrandPackage'),
	array('brand_id'=>'[0-9]+', 'package_id'=>'[0-9]+')
);

Router::connect('/types/:type_id/brands',
	array('controller'=>'types', 'action'=>'index_withBrands'),
	array('type_id'=>'[0-9]+')
);


