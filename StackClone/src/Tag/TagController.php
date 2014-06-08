<?php
namespace Anax\Tag;

class TagController implements \Anax\DI\IInjectionAware
{
	use \Anax\DI\TInjectable;
	
	public function initialize()
	{
/*		$this->tag = new \Anax\Tag\Tag();
		$this->tag->setDI($this->di);*/
	}
	
	// returns all tags belongs to questions id
	public function getTagsById($questionid)
	{
		$this->initialize();
		$params = array($questionid);
		$tags = (array)$this->tag->query('name')
			->where('WHERE belongs IN (?)')
			->execute($params);
			
		return $tags;
	}
	
	// returns all tags name
	public function getBelongsByTag($name)
	{
		$this->initialize();
		$belongsByTag = $this->tag->query('belongs')
				->where('WHERE name = ?')
				->execute($params);
				
		return $belongsByTag;
	}
	
	
	// returns all tags 
	public function getAllTags()
	{
		$toReturn = $this->tag->query()
							->execute();
		return $toReturn;
		
	}
	
	public function addTag()
	{
		$username = $this->user->getName();
		$this->initialize();
		$this->tag->save([
			'name'		=> $this->request->getPost('tags'),
			'author'	=> $name,
			'belongs'	=> $id,
			]);
	}
	
	  
}