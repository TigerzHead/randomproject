<?php

namespace Application\Model;

// Zend core
use Zend\Session\Container;

class LoginHelper 
{
	protected $query;

	public function __construct($query)
	{
		$this->query = $query;
	}

	public function login($form, $redirect)
	{
		if($this->query->count() >= 1)
		{
			$sess = new Container('login');
			$sess->check = true;
			
			foreach ($this->query as $account) {
				$sess->user = $account->uid;
			}
			return $redirect->toRoute('home');
		}
		
		return ['form' => $form];
	}
}