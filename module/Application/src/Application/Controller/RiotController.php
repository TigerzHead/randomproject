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

class RiotController extends AbstractActionController
{

	public function indexAction()
	{

		return new ViewModel();
	}

	public function apiAction()
	{
		$url = $this->getEvent()->getRouteMatch()->getParam('api');

		$session = curl_init();
		curl_setopt($session, CURLOPT_URL, "https://euw.api.pvp.net/api/lol/euw/v2.2/matchhistory/" . $url);
		curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($session, CURLOPT_HTTPGET, 1);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false); 

		$response = curl_exec($session);
		$json = json_decode($response);
		curl_close($session);
		var_dump($response);
		exit;
		return $json;
	}
}
