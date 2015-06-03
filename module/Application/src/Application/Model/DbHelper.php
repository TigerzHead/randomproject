<?php

namespace Application\Model;

class DbHelper
{

	private $db;
	protected $serviceLocator;

	public function __construct($serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
		$this->db = $this->getDb();
	}

	/**
	* Create and return Db\Adapter\Adapter instance
	*
	* @return Zend\Db\Adapter\Adapter instance
	*/

	public function getDb()
	{
		if (is_null($this->db))
		{
			$this->db = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
		}
		
		return $this->db;
	}


	public function getAll()
	{
		return $this->db->query("SELECT * FROM users", []);
	}

	public function executeQuery()
	{

	}
}