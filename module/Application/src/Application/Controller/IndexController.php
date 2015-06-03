<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

// Core of Zend
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Config\Config;

// Custom classes

use Application\Model\DbHelper as DbHelper;

class IndexController extends AbstractActionController
{
	private $dbhelper;

	public function indexAction()
	{
		$this->getDbHelper();

		return new ViewModel(array(
			"all" =>	$this->dbhelper->getAll()
		));
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
	* Create and return Db\Adapter\Adapter instance
	*
	* @return Zend\Db\Adapter\Adapter instance
	*/

	public function getConfig()
	{
		return $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
	}
}
