<?php
namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
	
	/**
 * List all users.
 *
 * @return void
 */
	public function listAction()
	{
		$this->initialize();
	 
		$all = $this->users->findAll();
		$this->users->getProperties();
		$this->theme->setTitle("List all users");
		$this->views->add('users/list-all', [
			'users' => $all,
			'title' => "View all users",
		]);
	}
	
		public function idAction($id = null)
	{
		$this->initialize();
		$user = $this->users->find($id);
	 
		$this->theme->setTitle("View user with id");
		$this->views->add('users/view', [
			'user' => $user,
		]);
	}
	
	
	public function changemailAction()
	{
		$this->initialize();
		$sql = 'UPDATE SC_user SET email=? WHERE id = ?';
		$params = array($this->request->getPost('email'), $this->request->getPost('id'));
		$this->users->customQuery($sql,$params);
		$user = $this->session->get('users', []);
		
		$insession = array();
		$insession['login'] = $user['login'];
		$insession['email'] = $this->request->getPost('email');
		$insession['id']	= $user['id'];
		$this->session->set('users', $insession);
		$this->response->redirect($this->request->getBaseUrl());
	}
	
	public function changepassAction()
	{
		$this->initialize();
		$sql = 'UPDATE SC_user SET SC_user.password=? WHERE id = ?';
		$params = array($this->request->getPost('pass'), $this->request->getPost('id'));
		$this->users->customQuery($sql,$params);
		
		
		$this->response->redirect($this->request->getBaseUrl());
	}
		/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function initialize()
	{
		$this->users = new \Anax\Users\User();
		$this->users->setDI($this->di);
	}
	
		/**
	 * Add new user.
	 *
	 * @param string $acronym of user to add.
	 *
	 * @return void
	 */
	public function addAction()
	{
	 	$this->initialize();
				
		$this->users->save([
			'login'		=> $this->request->getPost('login'),
			'password'	=> md5($this->request->getPost('password')),
			'email'		=> $this->request->getPost('email'),
		]);
	 
		
		$this->response->redirect($this->request->getBaseUrl());
	}
	
	public function registrateAction()
	{
		$this->views->add('users/registrate');
	}
	/**
	 * Delete user.
	 *
	 * @param integer $id of user to delete.
	 *
	 * @return void
	 */
	public function deleteAction($id = null)
	{
		if (!isset($id)) {
			die("Missing id");
		}
	 	$this->initialize();
		
		$res = $this->users->delete($id);
	 
		$url = $this->url->create('users');
		$this->response->redirect($url);
	}
	
	
	public function loginAction()
	{
		if($this->request->getPost('submit'))
		{
			$this->initialize();
			$login = $this->request->getPost('login');
			$password = md5($this->request->getPost('password'));
			$params = array($login,$password);
			$user = $this->users->query()
					->where('login = ?')
					->andWhere('password = ?')
					->execute($params);
			$this->users->getProperties();
			foreach($user as $a)
			{
				$insession['login'] = $a->login;
				$insession['email'] = $a->email;
				$insession['postamount'] = $a->postamount;
				$insession['id']	= $a->id;
			}
			if(isset($insession))
			{
				$user = $insession;
			}
			if(isset($user))
			{
				$users = $this->session->get('users',[]);
				$users = $user;
				$this->session->set('users', $user);
			}
		}
		$url = $this->request->getBaseUrl();
		$this->response->redirect($url);
	}
	
	public function getProperties($array)
	{
		unset($array['di']);
		unset($array['db']);
		$arrayToReturn = array();
		foreach($array as $object)
		{
			 array_push($arrayToReturn,get_object_vars($object));
		}
		$new = array();
		foreach($arrayToReturn as $ar)
		{
			$new = $ar;
		}
		return $new;
	}
	
	public function getArray($array)
	{
		unset($array['di']);
		unset($array['db']);
		$arrayToReturn = array();
		foreach($array as $object)
		{
			 array_push($arrayToReturn,get_object_vars($object));
		}
		return $arrayToReturn;
	}
	
	public function profileAction($id)
	{
		$sql = 'SELECT * FROM SC_user WHERE id = ?';
		$this->initialize();
		$params = array($id);
		$user = $this->users->customQuery($sql, $params);
		$sql = 'SELECT * FROM SC_question WHERE author = ?';
		$user = $this->getProperties($user);
		$params = array($user['login']);
		$posts = $this->users->customQuery($sql,$params);
		$posts = $this->getArray($posts);
		$sql = 'SELECT * FROM SC_answer WHERE author = ?';
		$params = array($user['login']);
		$answers = $this->users->customQuery($sql, $params);
		$answers = $this->getArray($answers);
		$this->views->add('users/profilefull',['user' => $user, 'posts' => $posts, 'answers' => $answers]);
	}
	
	public function logoutAction()
	{
		$user = $this->session->get('users', []);
		if(isset($user))
		{
			unset($user);
			$this->session->set('users',[]);
		}
		$url = $this->request->getBaseUrl();
		$this->response->redirect($url);
	}
	
	public function mostActiveAction()
	{
		$this->initialize();
		$sql = 'SELECT * FROM SC_user order by postamount LIMIT 10';
		$users = $this->users->customQuery($sql);
		$this->users->getProperties();
		return $users;
	}
	
	
	
	public function checkLoginAction()
	{
		$variables = $this->session->get('users', []);
		//print_r($variables);
		if($variables)
		{
			return $variables;
		}
		else
		{
			return false;
		}
	}
	
}