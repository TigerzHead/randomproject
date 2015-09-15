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
use Application\Form\contactForm;

class ContactController extends AbstractActionController
{
	private $dbhelper;
	protected $form;

	public function indexAction()
	{
		//$this->getDbHelper();

		return new ViewModel([
			'form'	=> $this->getContactForm(),
		]);
	}

	public function postAction()
	{
		$uid = $this->getEvent()->getRouteMatch()->getParam('uid');
		$post = key($_GET);
		$expl = explode("_", key($_GET));
		$post = implode(' ', $expl);

		$this->getDbHelper();

		$this->dbhelper->executeQuery("INSERT INTO chat SET uid = ?, post = ?, date = ?", [$uid, $post, date('Y-m-d G:i:s')]);
		exit;
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

	public function getContactForm()
	{
		if (!$this->form)
		{
			$form 		= new contactForm();
			$this->form = $form;
		}
		return $this->form;
	}
}
