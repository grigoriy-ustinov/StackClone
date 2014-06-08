<?php
namespace Anax\MVC;
 
/**
 * Model for Users.
 *
 */
class CDatabaseModel implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

	public function query($columns = '*')
	{
		$this->db->select($columns)
				 ->from($this->getSource());
	 
		return $this;
	}
		/**
	 * Build the where part.
	 *
	 * @param string $condition for building the where part of the query.
	 *
	 * @return $this
	 */
	public function where($condition)
	{
		$this->db->where($condition);
	 
		return $this;
	}
	/**
	 * Build the where part.
	 *
	 * @param string $condition for building the where part of the query.
	 *
	 * @return $this
	 */
	public function andWhere($condition)
	{
		$this->db->andWhere($condition);
	 
		return $this;
	}
	
	public function join($condition)
	{
		$this->db->join($condition);
		
		return $this;
	}
	
	
	/**
	 * Execute the query built.
	 *
	 * @param string $query custom query.
	 *
	 * @return $this
	 */
	public function execute($params = [])
	{
		$this->db->execute($this->db->getSQL(), $params);
		$this->db->setFetchModeClass(__CLASS__);
	 
		return $this->db->fetchAll();
	}
			
	public function customQuery($sql, $params = [])
	{
		$this->db->setSQL($sql);
		$this->db->execute($this->db->getSQL(),$params);
		return $this->db->fetchAll();
	}
	
	
	/**
	 * Create new row.
	 *
	 * @param array $values key/values to save.
	 *
	 * @return boolean true or false if saving went okey.
	 */
	public function create($values)
	{
		$keys   = array_keys($values);
		$values = array_values($values);
	 
		$this->db->insert(
			$this->getSource(),
			$keys
		);
	 
		$res = $this->db->execute($values);
	 
		$this->id = $this->db->lastInsertId();
	 
		return $res;
	}
	
	/**
	 * Update row.
	 *
	 * @param array $values key/values to save.
	 *
	 * @return boolean true or false if saving went okey.
	 */
	public function update($values)
	{
		$keys   = array_keys($values);
		$values = array_values($values);
	 
		// Its update, remove id and use as where-clause
		unset($keys['id']);
		$values[] = $this->id;
	 
		$this->db->update(
			$this->getSource(),
			$keys,
			"id = ?"
		);
	 
		return $this->db->execute($values);
	}
	
	
	/**
	 * Delete row.
	 *
	 * @param integer $id to delete.
	 *
	 * @return boolean true or false if deleting went okey.
	 */
	public function delete($id)
	{
		$this->db->delete(
			$this->getSource(),
			'id = ?'
		);
	 
		return $this->db->execute([$id]);
	}
	
	
		
	/**
	 * Find and return specific.
	 *
	 * @return this
	 */
	public function find($id)
	{
		$this->db->select()
				 ->from($this->getSource())
				 ->where("id = ?");
	 
		$this->db->execute([$id]);
		return $this->db->fetchInto($this);
	}
	
	/**
	 * Save current object/row.
	 *
	 * @param array $values key/values to save or empty to use object properties.
	 *
	 * @return boolean true or false if saving went okey.
	 */
	public function save($values = [])
	{
		$this->setProperties($values);
		$values = $this->getProperties();
	 
		if (isset($values['id'])) {
			return $this->update($values);
		} else {
			return $this->create($values);
		}
	}
	

}