<?php
namespace Anax\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


	public function initialize()
	{
		$this->comment = new \Anax\Comment\Comment();
		$this->comment->setDI($this->di);
	}

    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction($page = null)
    {
        $this->initialize();

		$all = $this->comment->query()
			->where('page = ? ')
			->execute([$page]);
		$this->comment->getProperties();
        $this->views->add('comment/comments', [
            'comments' => $all,
			'title'    => 'Redovisning med kommentarier',
        ]);
    }



    /**
     * Add a comment.
     *
     * @return void
     */
    public function addAction()
    {
        $isPosted = $this->request->getPost('doCreate');
        
        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }
		
		$this->initialize();
        $this->comment->save([
            'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'timestamp' => time(),
			'page'		=> $this->request->getPost('page'),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
        ]);

        $this->response->redirect($this->request->getPost('redirect'));
    }

	
	
	public function removeOneAction()
    {
        $isPosted = $this->request->getPost('id');
        
        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $this->initialize();
		$id = $this->request->getPost('id');
        $this->comment->delete($id);
		
        $this->response->redirect($this->request->getPost('redirect'));
    }
	
	public function editOneAction()
	{
		$isPosted = $this->request->getPost('edit');
		if (!$isPosted)
		{
			$this->response->redirect($this->request->getPost('redirect'));
		}
		$this->initialize();
		$id = $this->request->getPost('id');
		$this->comment->find($id);
		$toEdit = (array)$this->comment->getProperties();
		$this->views->add('comment/edit', ['toEdit' => $toEdit, 'title' => 'Editera komment']);
	}
	
	
	public function saveOneAction()
	{
		$isPosted = $this->request->getPost('save');
		if (!$isPosted)
		{
			$this->response->redirect($this->request->getPost('redirect'));
		}
		$this->initialize();
		$this->comment->id	= $this->request->getPost('id');
		$this->comment->content = $this->request->getPost('content');
		$this->comment->name = $this->request->getPost('name');
		$this->comment->web = $this->request->getPost('web');
		$this->comment->mail = $this->request->getPost('mail');
		$this->comment->timestamp = time();
		$this->comment->ip = $this->request->getServer('REMOTE_ADDR');
		$this->comment->page = $this->request->getPost('page');
		$this->comment->save();
		$this->response->redirect($this->request->getPost('redirect'));
	}
}
