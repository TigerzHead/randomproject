<?php

namespace Application\Model;

class SearchHelper 
{

	protected $q;
	protected $db;

	public function __construct($q, $db)
	{
		$this->q = $q;
		$this->db = $db;
	}

	public function search()
	{
		$this->db = $this->db->getDb();
		
		return $this->db->query("SELECT * FROM users WHERE firstname LIKE ? OR lastname LIKE ?", ['%' . $this->q . '%', '%' . $this->q . '%']);
	}
}
?>