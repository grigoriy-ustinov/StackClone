<?php
date_default_timezone_set("Europe/Stockholm");
require __DIR__.'/config_with_app.php'; 
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$di->setShared('db', function() {
	$db = new \Mos\Database\CDatabaseBasic();
	$db->setOptions(require ANAX_APP_PATH . 'config/database_mysql.php');
	$db->connect();
	return $db;
});
$di->set('QuestionController', function() use ($di) {
    $controller = new \Anax\Question\QuestionController();
    $controller->setDI($di);
    return $controller;
});
$di->set('TagController', function() use ($di) {
    $controller = new \Anax\Tag\TagController();
    $controller->setDI($di);
    return $controller;
});

$di->set('UsersController', function() use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$app = new \Anax\Kernel\CAnax($di);


$app->router->add('', function() use ($app) {
	
	$app->theme->setTitle("Latest questions and tags");
	$users = $app->dispatcher->forward([
			'controller' => 'users',
			'action'     => 'mostActive',
		]);
		
	$tags = $app->dispatcher->forward([
        'controller' => 'question',
        'action'     => 'getTags',
    ]);
	
	$app->views->add('tags/all', ['tags' => $tags], 'featured-1');
	
	$app->views->add('users/list-all',['users' => $users], 'featured-2');
		$app->dispatcher->forward([
        'controller' => 'question',
        'action'     => 'getLatest',
    ]);
	$user = $app->dispatcher->forward([
		'controller'	=> 'users',
		'action'		=> 'checkLogin',
	]);
	if($user)
	{
		$app->views->add('users/profile',['user' => $user], 'sidebar');	
	}
	else
	{
		$app->views->add('users/login', [
		'title'	=>'Login'], 'sidebar'
		);
	}

 
});

$app->router->add('questions', function() use ($app) {
	
	$app->theme->setTitle("All questions");
	$users = $app->dispatcher->forward([
			'controller' => 'users',
			'action'     => 'mostActive',
		]);
/*		$app->views->add('users/list-all', [
				'users'	=>$users], 'sidebar'
				);*/
	$app->dispatcher->forward([
        'controller' => 'question',
        'action'     => 'getAll',
    ]);
	$user = $app->dispatcher->forward([
		'controller'	=> 'users',
		'action'		=> 'checkLogin',
	]);
	if($user)
	{
		$app->views->add('users/profile',['user' => $user], 'sidebar');	
	}
	else
	{
		$app->views->add('users/login', [
		'title'	=>'Login'], 'sidebar'
		);
	}

 
});


$app->router->add('about', function() use ($app) {
	
    $app->theme->setTitle("about");

    $content = $app->fileContent->get('about.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
	
	
    $app->views->add('me/page', [
        'content' => $content,
    ]); 
	$user = $app->dispatcher->forward([
		'controller'	=> 'users',
		'action'		=> 'checkLogin',
	]);
	if($user)
	{
		$app->views->add('users/profile',['user' => $user], 'sidebar');	
	}
	else
	{
		$app->views->add('users/login', [
		'title'	=>'Login'], 'sidebar'
		);
	}

 
});

$app->router->add('tags', function() use ($app) {
	
	$app->theme->setTitle("All tags");
	$users = $app->dispatcher->forward([
			'controller' => 'users',
			'action'     => 'mostActive',
		]);
/*		$app->views->add('users/list-all', [
				'users'	=>$users], 'sidebar'
				);*/
	$tags = $app->dispatcher->forward([
        'controller' => 'question',
        'action'     => 'getTags',
    ]);
	
	$app->views->add('tags/all', ['tags' => $tags]);
	
	$user = $app->dispatcher->forward([
		'controller'	=> 'users',
		'action'		=> 'checkLogin',
	]);
	if($user)
	{
		$app->views->add('users/profile',['user' => $user], 'sidebar');	
	}
	else
	{
		$app->views->add('users/login', [
		'title'	=>'Login'], 'sidebar'
		);
	}

 
});

$app->router->add('source', function() use ($app) {
 
    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Source");
 
    $source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);
 
    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
 
}); 

$app->router->handle();
$app->theme->render();