<?php
namespace EasyForm;

class Form {
	public $rules;
	public $triggers;
	public $formConfig;
	public $errors = array();
	public $formData;
	public $formSent = false;
	public $formValid = false;


	public function __construct($formConfig) {
		$this->rules = new Rules();
		$this->triggers = new $formConfig['triggerClass'];
		$this->formConfig = $formConfig;
	}
	
	
	function validate($fields) {
		foreach($fields as $key=>$field) {
			if(!$this->rules->isValid($field['rule'], $_POST[$this->formConfig['id'].'-'.$key])) {
				$this->errors[$this->formConfig['id'].'-'.$key] = $field['message'];
			}
			
			$this->formData[$this->formConfig['id'].'-'.$key] = $_POST[$this->formConfig['id'].'-'.$key];
		}
	}
	
	
	function listen() {
		if(isset($_POST[$this->formConfig['id']])) {
			$this->validate($this->formConfig['fields']);
			if(empty($this->errors)) {
				$this->formValid = true;
				
				if(!empty($this->formConfig['triggers'])) {
					$this->execTriggers($this->formConfig['triggers']);
				}
			}
		}
	}
	
	
	function execTriggers($triggers) {
		foreach ($triggers as $key=>$params) {
			$this->triggers->$key($params,  $this->formConfig['id'],  $this->formData);
		}
 	}
	
	function showErrors() {
		if(!empty($this->errors)) {
			echo '<ul class="easyForm-errors">';
			foreach($this->errors as $error) {
				echo '<li>'.$error.'</li>';
			}
			echo '</ul>';
		}
	}
}