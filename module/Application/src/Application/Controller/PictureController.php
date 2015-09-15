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
use Zend\Http\PhpEnvironment\Request;

// Custom classes
use Application\Model\DbHelper as DbHelper;
use Application\Model\ValidationHelper as validation;

// Custom forms
use Application\Form\pictureForm;

class PictureController extends AbstractActionController
{
	private $dbhelper;
	private $form;

	public function indexAction()
	{
		$this->getDbHelper();
		$sess = new Container('login');

		return new ViewModel(array(
			'pictures' => $this->dbhelper->getPictures($sess->user)
		));
	}

	public function addAction()
	{
		if (!$this->getEvent()->getRouteMatch()->getParam('process')) 
		{
			return new ViewModel([
				"form"	=> $this->getPictureForm()
			]);
		} else 
		{
			$validator = new validation($this->getPictureForm(), $this->getRequest());
			$next = $validator->validator(['title', 'description', 'image']);


			if (count($next) > 1) 
			{

				$this->getDbHelper();
				//$this->dbhelper->checkDup($next['title'], $next['description'], $next[]);
				$request = new Request();
				$files = $request->getFiles();
				$filter = new \Zend\Filter\File\RenameUpload("public/img");
				$filter->setUseUploadName(true);
				$filter->filter($files['image']);
				$sess = new Container('login');
				$this->dbhelper->executeQuery("INSERT INTO pictures SET uid = ?, title = ?, description = ?, image = ?", [$sess->user, $next['title'], $next['description'], $files['image']['name']]);

				return $this->redirect()->toRoute("home");
			}
			return $next;
		}
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

	public function getPictureForm()
	{
		if (!$this->form)
		{
			$form = new pictureForm();
			$this->form = $form;
		}
		return $this->form;
	}
}
