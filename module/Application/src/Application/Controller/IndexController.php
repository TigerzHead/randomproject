<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

// Zend core
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Config\Config;
use Zend\Session\Container;

// Custom classes
use Application\Model\DbHelper as DbHelper;
use Application\Model\ValidationHelper as validation;

// Custom forms
use Application\Form\addForm;

class IndexController extends AbstractActionController
{
	private $dbhelper;
	protected $form;

	public function indexAction()
	{

		$this->checkLogin();

		$this->getDbHelper();

		return new ViewModel([
			"all" =>	$this->dbhelper->getAll(),
		]);
	}

	public function addAction()
	{
		if (!$this->getEvent()->getRouteMatch()->getParam('process')) 
		{
			return new ViewModel([
				"form"	=> $this->getAddForm()
			]);
		} else 
		{
			$validator = new validation($this->getaddForm(), $this->getRequest());
			$next = $validator->validator(['firstname', 'lastname']);

			if (count($next) > 1) 
			{
				$this->getDbHelper();
				$this->dbhelper->executeQuery("INSERT INTO users SET firstname = ?, lastname = ?", [$next['firstname'], $next['lastname']]);

				return $this->redirect()->toRoute("home");
			}
			return $next;
		}
	}

	public function deleteAction()
	{

		$this->getDbHelper();
		$this->dbhelper->executeQuery("DELETE FROM users WHERE uid = ?", ['uid']);		
	}

	public function getDbHelper()
	{
		if (!$this->dbhelper) 
		{
			$this->dbhelper = new DbHelper($this->serviceLocator);
		}
		return $this->dbhelper;
	}

	/**
	* Retrieves the form.
	*
	* @return \addForm $form
	*/

	public function getAddForm()
	{
		if (!$this->form)
		{
			$form 		= new addForm();
			$this->form = $form;
		}
		return $this->form;
	}

	public function checkLogin()
	{
		$sess = new Container('login');

		if ($sess->check) 
		{
			return;
		}
		$this->redirect()->toRoute('login');
	}
}
