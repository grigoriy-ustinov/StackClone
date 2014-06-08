<?php
namespace Anax\Tag;
 

class Tag extends \Anax\MVC\CDatabaseModel
{
	
	public function getSource()
	{
		return strtolower(implode('', array_slice(explode('\\', get_class($this)), -1)));
	}
	
	
	public function findAll()
	{
		$this->db->select()
				 ->from($this->getSource());
	 
		$this->db->execute();
		$this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}
	
	
	public function deleteOne($id)
	{
		$this->db->delete($id);
	}
	
	
	public function getProperties()
	{
		$properties = get_object_vars($this);
		unset($properties['di']);
		unset($properties['db']);
	 
		return $properties;
	}
	

	/**
	 * Set object properties.
	 *
	 * @param array $properties with properties to set.
	 *
	 * @return void
	 */
	public function setProperties($properties)
	{
		// Update object with incoming values, if any
		if (!empty($properties)) {
			foreach ($properties as $key => $val) {
				$this->$key = $val;
			}
		}
	}
}