<?php

namespace Application\Model;

class ValidationHelper 
{
	protected $form;
	protected $request;
	protected $inputFilter;

	public function __construct($form, $request)
	{
		$this->form = $form;
		$this->request = $request;
	}

	public function validator($group)
	{
		if ($this->request->isPost()) 
		{	
			$this->form->setValidationGroup($group);
			$this->form->setInputFilter($this->setInputFilter());
			$img = $this->request->getFiles()->toArray();
			$data = $this->request->getPost();
			if (!empty($img)) 
			{
				$data = array_merge_recursive(
				$this->request->getPost()->toArray(),
				$img['image']
				);
			}
			

			$this->form->setData($data);

			if ($this->form->isValid()) 
			{
				$data = $this->form->getData();

				return $data;
			} else 
			{
				return ['form' => $this->form];
			}
		}
	}
	
	public function setInputFilter()
	{
		if (!$this->inputFilter)
		{
			$inputFilter = new \Zend\InputFilter\InputFilter();
			$factory = new \Zend\InputFilter\Factory();

			$inputFilter->add($factory->createInput(array(
				'name'			=> 'firstname',
				'required'	 	=> true,
				'filters'		=> array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'	=> 'NotEmpty',
						'options'	=> array(
							'messages'	=> array(
								'isEmpty' => 'Dit veld moet ingevuld worden!'
							),
						),
						'break_chain_on_failure'	=> true,
					),
					array(
						'name'		=> 'StringLength',
						'options' => array(
							'encoding' 	=> 'UTF-8',
							'max'		=> 20,
						),
					),
					array(
						'name'	=> 'Regex',
						'options'	=> array(
							'pattern'	=> "^[a-zA-ZÖàáâãäåæçèéêëìíîïðñòóôõö÷øùúûü\-\. ]$^",
							'message' 	=> 'Alleen letters, een punt (.) of verbindingsstreepje (-) gebruiken.'
						),
					),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'			 => 'lastname',
				'required'	 	=> true,
				'filters'		=> array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'	=> 'NotEmpty',
						'options'	=> array(
							'messages'	=> array(
								'isEmpty' => 'Dit veld moet ingevuld worden!'
							),
						),
						'break_chain_on_failure'	=> true,
					),
					array(
						'name'	=> 'Regex',
						'options'	=> array(
							'pattern'	=> "^[a-zA-ZÖàáâãäåæçèéêëìíîïðñòóôõö÷øùúûü\-\. ]$^",
							'message' 	=> 'Alleen letters, een punt (.) of verbindingsstreepje (-) gebruiken.'
						),
					),
					array(
						'name'		=> 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'max'			=> 20,
						),
					),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'			=> 'title',
				'required'	 	=> true,
				'filters'		=> array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'	=> 'NotEmpty',
						'options'	=> array(
							'messages'	=> array(
								'isEmpty' => 'Dit veld moet ingevuld worden!'
							),
						),
						'break_chain_on_failure'	=> true,
					),
					array(
						'name'		=> 'StringLength',
						'options' => array(
							'encoding' 	=> 'UTF-8',
							'max'		=> 20,
						),
					),
					array(
						'name'	=> 'Regex',
						'options'	=> array(
							'pattern'	=> "^[a-zA-ZÖàáâãäåæçèéêëìíîïðñòóôõö÷øùúûü\-\. ]$^",
							'message' 	=> 'Alleen letters, een punt (.) of verbindingsstreepje (-) gebruiken.'
						),
					),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'			=> 'description',
				'required'	 	=> true,
				'filters'		=> array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'	=> 'NotEmpty',
						'options'	=> array(
							'messages'	=> array(
								'isEmpty' => 'Dit veld moet ingevuld worden!'
							),
						),
						'break_chain_on_failure'	=> true,
					),
					array(
						'name'		=> 'StringLength',
						'options' => array(
							'encoding' 	=> 'UTF-8',
							'max'		=> 255,
						),
					),
					array(
						'name'	=> 'Regex',
						'options'	=> array(
							'pattern'	=> "^[a-zA-ZÖàáâãäåæçèéêëìíîïðñòóôõö÷øùúûü\-\. ]$^",
							'message' 	=> 'Alleen letters, een punt (.) of verbindingsstreepje (-) gebruiken.'
						),
					),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'			=> 'image',
				'required'	 	=> false,
				'validators' => array(
					array(
						'name'	=> 'file/ImageSize',	
						'options'	=> array(					
							'messages'	=> array(
								'fileImageSizeWidthTooBig' => 'Dit veld moet ingevuld worden!'
							),
						),
						'break_chain_on_failure'	=> true,
					),
					array(
						'name'		=> 'file/Size',
						'options' => array(
							'min'		=> 20,
							'max'		=> 20,
							'messages'	=> array(
								'fileSizeNotFound' => 'Dit veld moet ingevuld worden!'
							),
						),
					),
				),
			)));

			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}