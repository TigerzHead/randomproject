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
			$date = explode(' ', $post->date);
			if ($post->uid == $this->user) 
			{
				echo "<div class='col s7' style=' background-color:lightblue;float:right;'>";
				echo "<p class='chat'>" . $post->firstname . " " . $post->lastname . " : <br>" . htmlspecialchars($post->post) . "<p class='chat chatBox'>" . $date[1] . "</p></p>";
				echo "</div>";			
			} else 
			{
				echo "<div class='col s7'>";
				echo "<p class='chat'>" . $post->firstname . " " . $post->lastname . " : <br>" . $post->post . "<p class='chat chatBox'>" . $date[1] . "</p></p>";
				echo "</div>";
			}
		}
		echo "<div id='bottom'></div>";
	}
}
?>