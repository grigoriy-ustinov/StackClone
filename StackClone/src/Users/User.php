<?php
namespace Anax\Users;
 
/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{
	
		/**
	 * Get the table name.
	 *
	 * @return string with the table name.
	 */
	public function getSource()
	{
		return strtolower(implode('', array_slice(explode('\\', get_class($this)), -1)));
	}
	
		/**
	 * Find and return all.
	 *
	 * @return array
	 */
	public function findAll()
	{
		$this->db->select()
				 ->from($this->getSource());
	 
		$this->db->execute();
		$this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}
	
		/**
	 * Get object properties.
	 *
	 * @return array with object properties.
	 */
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