<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class loginForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('Application');
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-horizontal col-sm-offset-4 col-sm-4');

		$this->add(array(
			'name' => 'firstname',
			'attributes' => array(
				'type'  => 'text',
				'maxlength' => 30,
				'size'		=> 20,
			),
			'options'	=> array(
				'label_options' => array(
					'disable_html_escape' => true,
				),
			)			
		));

		$this->add(array(
			'name' => 'lastname',
			'attributes' => array(
				'type'  => 'text',
				'maxlength' => 30,
				'size'		=> 20,
			),
			'options'	=> array(
				'label_options' => array(
					'disable_html_escape' => true,
				),
			)			
		));

		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => _('Submit'),
				'class'	=> 'btn btn-primary'
			),
		));
	}
}
