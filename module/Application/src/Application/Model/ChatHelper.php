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
				echo "<div class='col-sm-12' style=' background-color:lightblue;'>";
				echo "<p style='float:right;'>" . $post->firstname . " " . $post->lastname . " : " . $post->post . "</p>";
				echo "</div>";			
			} else 
			{
				echo "<div class='col-sm-12'>";
				echo "<p style='float:left;'>" . $post->firstname . " " . $post->lastname . " : " . $post->post . "</p>";
				echo "</div>";
			}
		}
		echo "<div id='bottom'></div>";
	}
}
?>