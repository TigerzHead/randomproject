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

// Custom forms
use Application\Form\loginForm;

// Custom classes
use Application\Model\DbHelper as DbHelper;
use Application\Model\ValidationHelper as validation;
use Application\Model\LoginHelper as login;

class LoginController extends AbstractActionController
{

	protected $form;
	private $dbhelper;
	private $loginhelper;

	public function indexAction()
	{
		 // Get the "layout" view model and set an alternate template
		$layout = $this->layout();
		$layout->setTemplate('login/layout');

		if (!$this->getEvent()->getRouteMatch()->getParam('process')) 
		{
			$view = new ViewModel(array(
				'form'	=> $this->getLoginForm()
			));
	
			return $view;
		} else
		{
			$validator = new validation($this->getLoginForm(), $this->getRequest());
			$next = $validator->validator(['firstname', 'lastname']);
			
			if (count($next) > 1) 
			{

				$this->getDbHelper();
				$loginCheck = $this->dbhelper->executeQuery("SELECT DISTINCT * FROM users WHERE firstname = ? AND lastname = ? ", [$next['firstname'], $next['lastname']]);

				$checker = $this->getLoginHelper($loginCheck);
				$path = $checker->login($this->getLoginForm(), $this->redirect());

				return $path;
			}
			return $next;
		}
	}

	public function logoutAction()
	{
		$sess = new Container('login');

		if ($sess->check) 
		{
			$sess->getManager()->getStorage()->clear('login');
		}

		$this->redirect()->toRoute('login');
	}

	/**
	* Retrieves the form.
	*
	* @return \loginForm $form
	*/

	public function getLoginForm()
	{
		if (!$this->form)
		{
			$form 		= new loginForm();
			$this->form = $form;
		}
		return $this->form;
	}

	public function getDbHelper()
	{
		if (!$this->dbhelper) 
		{
			$this->dbhelper = new DbHelper($this->serviceLocator);
		}
		return $this->dbhelper;
	}

	public function getLoginHelper($query)
	{
		if (!$this->loginhelper) 
		{
			$this->loginhelper = new login($query);
		}
		return $this->loginhelper;
	}
}