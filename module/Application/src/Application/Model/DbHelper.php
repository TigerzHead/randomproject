<?php

namespace Application\Model;

class DbHelper
{
	private $db;
	protected $serviceLocator;
	protected $checked;

	public function __construct($serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
		$this->db = $this->getDb();
		$this->checked = true;
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

	public function getChat()
	{
		return $this->db->query("SELECT * FROM chat INNER JOIN users ON chat.uid = users.uid ORDER BY chat.date ASC", []);
	}

	public function getPictures()
	{
		return $this->db->query("SELECT * FROM pictures INNER JOIN users ON pictures.uid = users.uid", []);
	}

	public function executeQuery($query, $data)
	{
		if ($this->checked) 
		{
			return $this->db->query($query, array_values($data) );
		}
		
	}

	public function checkDup($first, $last)
	{
		$checker = $this->db->query("SELECT * FROM users WHERE firstname = ? AND lastname = ? ", [$first, $last]);

		if ($checker->count() >= 1) 
		{
			$this->checked = false;
		}
		return;
	}

	public function delete($value) 
	{
		$this->db->query("DELETE FROM users WHERE uid = ?", [$value]);
	}
}