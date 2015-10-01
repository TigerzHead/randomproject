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

class RiotController extends AbstractActionController
{

	private $dbhelper;
	private $apiKey;

	public function indexAction()
	{
		// Get the "layout" view model and set an alternate template
		$layout = $this->layout();
		$layout->setTemplate('riot/layout');
		return new ViewModel();
	}

	public function apiAction()
	{
		$this->apiKey = "api_key=57832397-1919-4173-9028-e673a6f1b31d";
		$search = $this->getEvent()->getRouteMatch()->getParam('search');
		$username = $this->getEvent()->getRouteMatch()->getParam('username');
		
		$this->getDbHelper();
		$id = $this->checkUsername($username);

		$this->apiCall("v2.2/matchlist/by-summoner/" . $id . "?beginIndex=0&endIndex=5&" . $this->apiKey);
		exit;
		//$url = "matchhistory/23181685?api_key=57832397-1919-4173-9028-e673a6f1b31d";
	}

	public function getDbHelper()
	{
		if (!$this->dbhelper) 
		{
			$this->dbhelper = new DbHelper($this->serviceLocator);
		}
		return $this->dbhelper;
	}

	public function checkUsername($username) 
	{
		$query = $this->dbhelper->executeQuery("SELECT * FROM r_user_id WHERE username = ?", [$username]);

		if ($query->count()) 
		{
			$data = $this->getId($username);
		} else 
		{
			$data = $this->apiCall("v1.4/summoner/by-name/" . $username . "?" . $this->apiKey);
		
			$data = reset($data)['id'];

			$this->addUsername($username, $data);
		}

		return $data;
	}

	public function apiCall($url)
	{

		$session = curl_init();
		curl_setopt($session, CURLOPT_URL, "https://euw.api.pvp.net/api/lol/euw/" . $url);
		curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($session, CURLOPT_HTTPGET, 1);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false); 

		$response = curl_exec($session);
		//$json = json_encode($response);

		$notJson = json_decode($response);
		curl_close($session);
		echo $response;

		return $notJson;
	}

	public function addUsername($username, $data)
	{		
		$this->dbhelper->executeQuery("INSERT INTO r_user_id SET username = ?, riot_id = ?", [$username, $data]);
	}

	public function getId($username)
	{
		$query = $this->dbhelper->executeQuery("SELECT * FROM r_user_id WHERE username = ?", [$username]);

		foreach ($query as $key) 
		{
			return $key->riot_id;
		}
	}

	public function MatchHistoryAction()
	{
		$this->apiKey = "api_key=57832397-1919-4173-9028-e673a6f1b31d";
		$id = $this->getEvent()->getRouteMatch()->getParam('id');

		$this->apiCall("v2.2/match/" . $id . "?" . $this->apiKey);
		exit;
	}

	public function getIdAction()
	{
		$this->getDbHelper();
		$username = $this->getEvent()->getRouteMatch()->getParam('username');

		echo $this->checkUsername($username);
		exit;		
	}

}
