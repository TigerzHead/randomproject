<?php

namespace Application\Model;

// Zend core
use Zend\Session\Container;

class ChatHelper 
{
	protected $chat;
	protected $user;

	public function __construct($chat, $user)
	{
		$this->chat = $chat;
		$this->user = $user;
	}

	public function createHtml()
	{
		foreach ($this->chat as $post) 
		{
			if ($post->uid == $this->user) 
			{
				echo "<div class='col s7' style=' background-color:lightblue;float:right;'>";
				echo "<p >" . $post->firstname . " " . $post->lastname . " : " . $post->post . "</p>";
				echo "</div>";			
			} else 
			{
				echo "<div class='col s7'>";
				echo "<p>" . $post->firstname . " " . $post->lastname . " : " . $post->post . "</p>";
				echo "</div>";
			}
		}
		echo "<div id='bottom'></div>";
	}
}
?>