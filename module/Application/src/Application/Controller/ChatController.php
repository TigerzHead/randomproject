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
use Application\Model\ChatHelper as Chat;

// Custom forms
use Application\Form\chatForm;

class ChatController extends AbstractActionController
{
	private $dbhelper;
	protected $form;

	public function indexAction()
	{
		$this->getDbHelper();
		$sess = new Container('login');

		return new ViewModel([
			'chat'	=> $this->dbhelper->getChat(),
			'form'	=> $this->getChatForm(),
			'user'	=> $sess->user
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

	public function chatAction()
	{
		$this->getDbHelper();
		$sess = new Container('login');

		$chathelper = new Chat($this->dbhelper->getChat(), $sess->user);

		$chathelper->createHtml();

		exit;
	}

	/**
	* Retrieves the form.
	*
	* @return \addForm $form
	*/

	public function getChatForm()
	{
		if (!$this->form)
		{
			$form 		= new chatForm();
			$this->form = $form;
		}
		return $this->form;
	}
}
