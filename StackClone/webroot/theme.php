<?php 
date_default_timezone_set("Europe/Stockholm");
require __DIR__.'/config_with_app.php'; 
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);


$di->set('ImageController', function() use ($di) {
    $controller = new \Anax\Image\ImageController();
    $controller->setDI($di);
    return $controller;
});
$app = new \Anax\Kernel\CAnax($di);


$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Tema");
	$app->views->addString('<h1>HTML Ipsum Presents</h1>
<p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>','main')
				->addString('<ul class="fa-ul">
  <li><i class="fa-li fa fa-check-square"></i>List icons (like these)</li>
  <li><i class="fa-li fa fa-check-square"></i>can be used</li>
  <li><i class="fa-li fa fa-spinner fa-spin"></i>to replace</li>
  <li><i class="fa-li fa fa-square"></i>default bullets in lists</li>
</ul>', 'sidebar')
               ->addString('<i class="fa fa-spinner fa-spin"></i>
<i class="fa fa-refresh fa-spin"></i>
<i class="fa fa-cog fa-spin"></i>
', 'triptych-1')
               ->addString('<i class="fa fa-spinner fa-spin"></i>
<i class="fa fa-refresh fa-spin"></i>
<i class="fa fa-cog fa-spin"></i>
', 'triptych-2')
               ->addString('<i class="fa fa-spinner fa-spin"></i>
<i class="fa fa-refresh fa-spin"></i>
<i class="fa fa-cog fa-spin"></i>
', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');
			   
	$link = "7eb66d0962.png";
	$width = 240;
	$height = 300;
/*	$image = $this->ImageController;
	$picture = $image->showAction($link,$width,$height);*/
	$image = $app->dispatcher->forward([
        'controller' => 'image',
        'action'     => 'show',
		'params'	 => [$link,$width,$height],
    ]);
	
	$app->views->addString($image);
	
});

$app->router->add('image/add', function() use ($app) {
    $app->theme->setTitle("Image");
			   
	$image = $app->dispatcher->forward([
        'controller' => 'image',
        'action'     => 'add',
    ]);
	
});



$app->router->add('green', function() use ($app) {
	
	$app->theme->addStylesheet('css/anax-grid/color-green.less');
	$app->theme->setTitle("Green");
	$app->views->addString('<h1>HTML Ipsum Presents</h1>
<p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>','main')
				->addString('<ul class="fa-ul">
  <li><i class="fa-li fa fa-check-square"></i>List icons (like these)</li>
  <li><i class="fa-li fa fa-check-square"></i>can be used</li>
  <li><i class="fa-li fa fa-spinner fa-spin"></i>to replace</li>
  <li><i class="fa-li fa fa-square"></i>default bullets in lists</li>
</ul>', 'sidebar')
               ->addString('<i class="fa fa-spinner fa-spin"></i>
<i class="fa fa-refresh fa-spin"></i>
<i class="fa fa-cog fa-spin"></i>
', 'triptych-1')
               ->addString('<i class="fa fa-spinner fa-spin"></i>
<i class="fa fa-refresh fa-spin"></i>
<i class="fa fa-cog fa-spin"></i>
', 'triptych-2')
               ->addString('<i class="fa fa-spinner fa-spin"></i>
<i class="fa fa-refresh fa-spin"></i>
<i class="fa fa-cog fa-spin"></i>
', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');
});

$app->router->add('red', function() use ($app) {
	
	$app->theme->addStylesheet('css/anax-grid/color-red.less');
    $app->theme->setTitle("Red");
	$app->views->addString('<h1>HTML Ipsum Presents</h1>
<p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>','main')
				->addString('<ul class="fa-ul">
  <li><i class="fa-li fa fa-check-square"></i>List icons (like these)</li>
  <li><i class="fa-li fa fa-check-square"></i>can be used</li>
  <li><i class="fa-li fa fa-spinner fa-spin"></i>to replace</li>
  <li><i class="fa-li fa fa-square"></i>default bullets in lists</li>
</ul>', 'sidebar')
               ->addString('<i class="fa fa-spinner fa-spin"></i>
<i class="fa fa-refresh fa-spin"></i>
<i class="fa fa-cog fa-spin"></i>
', 'triptych-1')
               ->addString('<i class="fa fa-spinner fa-spin"></i>
<i class="fa fa-refresh fa-spin"></i>
<i class="fa fa-cog fa-spin"></i>
', 'triptych-2')
               ->addString('<i class="fa fa-spinner fa-spin"></i>
<i class="fa fa-refresh fa-spin"></i>
<i class="fa fa-cog fa-spin"></i>
', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');
});


$app->router->handle();
$app->theme->render();