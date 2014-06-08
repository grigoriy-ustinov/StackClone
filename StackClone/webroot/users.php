<?php
date_default_timezone_set("Europe/Stockholm");
require __DIR__.'/config_with_app.php'; 
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$di->set('form', '\Mos\HTMLForm\CForm');

session_name('forms'); // Any session name works
session_start();



$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_mysql.php');
    $db->connect();
    return $db;
});
$di->set('UsersController', function() use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});


$app = new \Anax\Kernel\CAnax($di);


$app->router->add('', function() use ($app) {
 		$app->theme->setTitle("Users");
		
	$app->dispatcher->forward([
	'controller' => 'users',
	'action'     => 'list',
]);
	
});

$app->router->add('setup', function() use ($app) {
	
	    //$app->db->setVerbose();
 
    $app->db->dropTableIfExists('user')->execute();
 
    $app->db->createTable(
        'user',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime'],
        ]
    )->execute();
	    $app->db->insert(
        'user',
        ['acronym', 'email', 'name', 'password', 'created', 'active']
    );
 
    $now = date(DATE_RFC2822);
 
    $app->db->execute([
        'admin',
        'admin@dbwebb.se',
        'Administrator',
        password_hash('admin', PASSWORD_DEFAULT),
        $now,
        $now
    ]);
 
    $app->db->execute([
        'doe',
        'doe@dbwebb.se',
        'John/Jane Doe',
        password_hash('doe', PASSWORD_DEFAULT),
        $now,
        $now
    ]);
	

	$app->dispatcher->forward([
	'controller' => 'users',
	'action'     => 'list',
]);
	
});


$app->router->add('id', function() use ($app) {
	$app->theme->setTitle("Search");
 	$form = $app->form; 
	$form = $form->create([], [
    'id' => [
      'type'        => 'number',
      'label'       => 'ID:',
      'required'    => true,
      'validation'  => ['not_empty'],
    ],
	'submit' => [
        'type'      => 'submit',
        'callback'  => function($form) {
            $form->saveInSession = true;
            return true;
        }
    ],
]);
$status = $form->check();
if($status === true)
{
	$id = $_SESSION['form-save']['id']['value'];
	$app->response->redirect($app->url->create('users.php/users/id/' . $id));
	unset($_SESSION['form-save']); 
}
	$html = $form->getHTML();
	$app->views->add('me/page', [ 'content' => $html, 'byline' => null,]);
	
	
});

$app->router->add('add', function() use ($app) {
	$app->theme->setTitle("Add");
 	$form = $app->form; 
	$form = $form->create([], [
    'id' => [
      'type'        => 'number',
      'label'       => 'Name:',
      'required'    => true,
      'validation'  => ['not_empty'],
    ],
	'submit' => [
        'type'      => 'submit',
        'callback'  => function($form) {
            $form->saveInSession = true;
            return true;
        }
    ],
]);
$status = $form->check();
if($status === true)
{
	$name = $_SESSION['form-save']['id']['value'];
	$app->response->redirect($app->url->create('users.php/users/add/' . $name));
	unset($_SESSION['form-save']);
}
	$html = $form->getHTML();
	$app->views->add('me/page', [ 'content' => $html, 'byline' => null,]);
	
	

});

$app->router->add('delete', function() use ($app) {
	$app->theme->setTitle("Delete");
 	$form = $app->form; 
	$form = $form->create([], [
    'id' => [
      'type'        => 'number',
      'label'       => 'ID:',
      'required'    => true,
      'validation'  => ['not_empty'],
    ],
	'submit' => [
        'type'      => 'submit',
        'callback'  => function($form) {
            $form->saveInSession = true;
            return true;
        }
    ],
]);
$status = $form->check();
if($status === true)
{
	$id = $_SESSION['form-save']['id']['value'];
	$app->response->redirect($app->url->create('users.php/users/delete/' . $id));
	unset($_SESSION['form-save']);
}
	$html = $form->getHTML();
	$app->views->add('me/page', [ 'content' => $html, 'byline' => null,]);
	
	

});

$app->router->add('soft-delete', function() use ($app) {
	$app->theme->setTitle("Soft delete");
 	$form = $app->form; 
	$form = $form->create([], [
    'id' => [
      'type'        => 'number',
      'label'       => 'ID:',
      'required'    => true,
      'validation'  => ['not_empty'],
    ],
	'submit' => [
        'type'      => 'submit',
        'callback'  => function($form) {
            $form->saveInSession = true;
            return true;
        }
    ],
]);
$status = $form->check();
if($status === true)
{
	$id = $_SESSION['form-save']['id']['value'];
	$app->response->redirect($app->url->create('users.php/users/soft-delete/' . $id));
	unset($_SESSION['form-save']);
}
	$html = $form->getHTML();
	$app->views->add('me/page', [ 'content' => $html, 'byline' => null,]);

});


$app->router->add('restore', function() use ($app) {
	$app->theme->setTitle("Restore");
 	$form = $app->form; 
	$form = $form->create([], [
    'id' => [
      'type'        => 'number',
      'label'       => 'ID:',
      'required'    => true,
      'validation'  => ['not_empty'],
    ],
	'submit' => [
        'type'      => 'submit',
        'callback'  => function($form) {
            $form->saveInSession = true;
            return true;
        }
    ],
]);
$status = $form->check();
if($status === true)
{
	$id = $_SESSION['form-save']['id']['value'];
	$app->response->redirect($app->url->create('users.php/users/restore/' . $id));
	unset($_SESSION['form-save']);
}
	$html = $form->getHTML();
	$app->views->add('me/page', [ 'content' => $html, 'byline' => null,]);

});

$app->router->add('active', function() use ($app) {

	$app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'active',
    ]);
});
$app->router->add('inactive', function() use ($app) {
	$app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'inactive',
    ]);

});

$app->router->handle();
$app->theme->render();