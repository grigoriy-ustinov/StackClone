<?php
namespace Anax\Question;

class QuestionController implements \Anax\DI\IInjectionAware
{
	use \Anax\DI\TInjectable;
	
	public function initialize()
	{
		$this->question = new \Anax\Question\Question();
		$this->question->setDI($this->di);
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
		return $arrayToReturn;
	}
	
	//get Latest Questions for Home
	public function getLatestAction()
	{
		$this->initialize();
		$sql = 'SELECT * FROM SC_question ORDER BY created LIMIT 10';
		$questions = $this->question->customQuery($sql);
		$tagSQL = 'SELECT SC_tag.name, SC_tag.belongs, SC_question.created FROM SC_tag 
					INNER JOIN SC_question ON SC_question.id = SC_tag.belongs
					ORDER BY SC_question.created LIMIT 10';
		$tags = $this->question->customQuery($tagSQL);
		$tags = $this->getProperties($tags);
		$questions = $this->getProperties($questions);
		$this->views->add('questions/latest', [
				'questions' => $questions,
				'tags'		=> $tags]
				);
	}
	
	
	
	
	
	
	public function getAllAction()
	{
		$this->initialize();
		$questions = $this->question->query()
				->execute();
		$tagSQL = 'SELECT SC_tag.name, SC_tag.belongs, SC_question.created FROM SC_tag 
					INNER JOIN SC_question ON SC_question.id = SC_tag.belongs';
					
		$tags = $this->question->customQuery($tagSQL);
		$tags = $this->getProperties($tags);
		$questions = $this->getProperties($questions);
		$this->views->add('questions/all', ['questions' => $questions,'tags'	=> $tags]);
		$this->views->add('questions/form');
	}
	
	
	
	
	
	
	
	public function getOneAction($id)
	{
		if(!isset($id))
		{
			$this->response->redirect('');
		}
		$this->initialize();
		$params = array($id);
		$question = array($this->question->find($id));

		$params = array($id);
		
		$question = $this->question->getProperties();
		$answersSQL = 'SELECT * FROM SC_answer
								WHERE belongs = ?';
		$params = array($question['id']);
		$answer = $this->question->customQuery($answersSQL, $params);
		
		$answer = $this->getProperties($answer);
		
		$commentsSQL = 'SELECT SC_answer.id FROM SC_answer
						INNER JOIN SC_comment ON SC_comment.belongs = SC_answer.id
						INNER JOIN SC_question ON SC_question.id = SC_answer.belongs
						WHERE SC_question.id = ?';
		$commentsIDS = $this->question->customQuery($commentsSQL, $params);
		$commentsIDS = $this->getProperties($commentsIDS);
		$ids = null;
		foreach($commentsIDS as $id)
		{
			$ids .= $id['id']. ',';
		}
		$ids = substr($ids, '0','-1');
		if($ids != null)
		{
			$commentSQL = 'SELECT * FROM SC_comment
								WHERE belongs in ('.$ids.')';
			$comment = $this->question->customQuery($commentSQL);
			$comment = $this->getProperties($comment);
		}
		else
		{
			$comment = array();
		}
				
		$temp = '"'.$question['author']. '"' . ',';
		$params = array();
		if($answer == null && $comment != null)
		{
			foreach($comment as $com)
			{
				$temp .= '"'.$com['author']. '"'. ',';
			}
		}
		else if($answer != null && $comment == null)
		{
			foreach($answer as $an)
			{
				$temp .= '"'.$an['author']. '"'. ',';
			}
		}
		else if ($answer != null && $comment != null)
		{
			foreach($answer as $an)
			{
				$temp .= '"'.$an['author']. '"'. ',';
			}
			foreach($comment as $com)
			{
				$temp .= '"'.$com['author']. '"'. ',';
			}
		}
		$temp = substr($temp, 0, -1);
		$params = array($temp);
		$authorSQL = 'SELECT DISTINCT * FROM SC_user WHERE login in ('.$temp.')';
		$author = $this->question->customQuery($authorSQL);
		$author = $this->getProperties($author);
		$user = $this->session->get('users', []);
		$params = array($question['id']);
		$sql = 'SELECT * FROM SC_tag 
					WHERE belongs in (?)';
		$tags = $this->question->customQuery($sql, $params);
		$tags = $this->getProperties($tags);
		$this->views->add('questions/alone',['questions' =>	$question,
											 'tags'		=>	$tags,
											 'answers'	=>	$answer,
											 'comments'	=>	$comment,
											 'authors'	=>	$author,
											 'user'		=>	$user]);
	}
	
	
	public function getByTagAction($tag)
	{
		if(!isset($tag))
		{
			$this->response->redirect('');
		}
		$params = array($tag);
		
		$sql = 'SELECT SC_question.id, SC_question.text, SC_question.title, SC_question.author FROM SC_question 
				INNER JOIN SC_tag ON SC_question.id = SC_tag.belongs
				WHERE SC_tag.name = ?';
		$this->initialize();
		$questionsByTag = $this->question->customQuery($sql, $params);
		$paramsNew = array();
		foreach($questionsByTag  as $qt)
		{
			array_push($paramsNew, $qt->id);
		}
		$sqlTag = 'SELECT * FROM SC_tag WHERE belongs = ?';
		$tags = $this->question->customQuery($sqlTag, $paramsNew);
		$tags = $this->getProperties($tags);
		$questionsByTag = $this->getProperties($questionsByTag);
		$this->views->add('questions/all', ['questions' => $questionsByTag, 'tags' => $tags]);
	}
	
	
	public function commentformAction($id,$type)
	{
		$this->views->add('questions/commentform', ['id'	=> $id, 'type' => $type]);
	}
	
	public function answerformAction($id)
	{
		$this->views->add('questions/answerform',['id'	=> $id]);
	}
	
	public function addAnswerAction()
	{
		$user = $this->session->get('users', []);
		$username = $user['login'];
		$this->initialize();
		$sql = 'INSERT INTO SC_answer (text,author,belongs,created) VALUES(?,?,?,?)';
		$belongs = $this->request->getPost('belongs');
		$text = $this->request->getPost('text');
		$time = time();
		$params = array($text,$username,$belongs,$time);
		$this->question->customQuery($sql,$params);
		$this->response->redirect($this->request->getPost('redirect'));
	}
	
	
		public function addCommentAction()
	{
		$user = $this->session->get('users', []);
		$username = $user['login'];
		$this->initialize();
		$sql = 'INSERT INTO SC_comment (text,author,belongs,created,type) VALUES(?,?,?,?,?)';
		$belongs = $this->request->getPost('belongs');
		$text = $this->request->getPost('text');
		$type = $this->request->getPost('type');
		$time = time();
		$params = array($text,$username,$belongs,$time,$type);
		$this->question->customQuery($sql,$params);
		$this->response->redirect($this->request->getPost('redirect'));
	}
	
	// Add question 
	public function addAction()
	{
		$user = $this->session->get('users', []);
		$username = $user['login'];
		$this->initialize();
		$this->question->save([
			'text'		=> $this->request->getPost('text'),
			'title'		=> $this->request->getPost('title'),
			'created'	=>time(),
			'author'	=> $username,
			]);
		$params = array($this->request->getPost('title'));
		$id = $this->question->customQuery('SELECT * FROM SC_question WHERE title = ?', $params);
		$id = $this->getProperties($id);
		$id = $id[0]['id'];
		$sql = 'INSERT INTO SC_tag (name, belongs) VALUES (?,?)';
		
		$getpost = $this->request->getPost('tags');
		$tags = (explode("#",$getpost));
		foreach($tags as $tag)
		{
			if($tag != null)
			{
				$params = array($tag, $id);
				$this->question->customQuery($sql,$params);
			}
		}
		
		$this->response->redirect($this->request->getPost('redirect'));
	}
	
	
	
	
	
	//save question 
	public function saveAction()
	{
		$isPosted = $this->request->getPost('save');
		if (!$isPosted)
		{
			$this->response->redirect($this->request->getPost('redirect'));
		}
		$username = $this->user->getName();
		
		$this->initialize();
		$this->question->id = $this->request->getPost('id');
		$this->question->text = $this->request->getPost('text');
		$this->question->title = $this->request->getPost('title');
		$this->question->author = $username;
		$this->question->created = time();
		$this->question->save();
		$this->response->redirect($this->request->getPost('redirect'));
	}
	
	
	
	
	
	//edit question
	public function editAction()
	{
		$isPosted = $this->request->getPost('edit');
		if (!$isPosted)
		{
			$this->response->redirect($this->request->getPost('redirect'));
		}
		
		$this->initialize();
		$id = $this->request->getPost('id');
		$this->question->find($id);
		$toEdit = (array)$this->question->getProperties();
		$this->views->add('question/edit', ['toEdit' => $toEdit, 'title' => 'Edit question']);
	}
	
	
	public function gettagsAction()
	{
		$this->initialize();
		$sql = 'SELECT name FROM SC_tag';
		$tags = $this->question->customQuery($sql);
		$tags = $this->getProperties($tags);
		return $tags;
	}
	
	//remove question 
	public function removeAction()
	{
		$isPosted = $this->request->getPost('id');
        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }
		
		$this->initialize();
		$id = $this->request->getPost('id');
		$slq = 'DELETE * FROM SC_tag WHERE belongs = "?"';
		$params = array($id);
		$this->question->customQuery($sql,$params);
		$this->question->delete($id);
		$this->response->redirect($this->request->getPost('redirect'));
	}
	  
}