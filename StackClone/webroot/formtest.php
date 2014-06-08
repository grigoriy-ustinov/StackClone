<?php
require __DIR__.'/config_with_app.php'; 


// Create services and inject into the app.
$di  = new \Anax\DI\CDIFactoryDefault();

$di->set('form', '\Mos\HTMLForm\CForm');

$app = new \Anax\Kernel\CAnax($di);


$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

session_name('cform_example'); // Any session name works
session_start();







$app->router->add('', function() use ($app) {
	
 		$app->theme->setTitle("Formtest");
		$form = $app->form; 
		
		$form->saveInSession = true;
		$form = $form->create([], [
    'name' => [
      'type'        => 'text',
      'label'       => 'Name of contact person:',
      'required'    => true,
      'validation'  => ['not_empty'],
    ],
    'email' => [
      'type'        => 'text',
      'required'    => true,
      'validation'  => ['not_empty', 'email_adress'],
    ],
    'phone' => [
      'type'        => 'text',
      'required'    => true,
      'validation'  => ['not_empty', 'numeric'],
    ],
    'submit' => [
        'type'      => 'submit',
        'callback'  => function($form) {
            $form->AddOutput("<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>");
            $form->AddOutput("<p><b>Name: " . $form->Value('name') . "</b></p>");
            $form->AddOutput("<p><b>Email: " . $form->Value('email') . "</b></p>");
            $form->AddOutput("<p><b>Phone: " . $form->Value('phone') . "</b></p>");
            $form->saveInSession = true;
            return true;
        }
    ],
    'submit-fail' => [
        'type'      => 'submit',
        'callback'  => function($form) {
            $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
            return false;
        }
    ],
]);


// Check the status of the form
$status = $form->check();
 
if ($status === true) {
 
    // What to do if the form was submitted?
    $form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
    header("Location: " . $_SERVER['PHP_SELF']);
 
} else if ($status === false) {
 
    // What to do when form could not be processed?
    $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
    header("Location: " . $_SERVER['PHP_SELF']);
}

		$app->views->add('me/page', [
				'content'	=>$form->getHTML(),
				'byline'	=> null,
				]);
});

$app->router->handle();
$app->theme->render();