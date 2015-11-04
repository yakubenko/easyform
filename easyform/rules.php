<?php
namespace EasyForm;

class Rules {
	public function isValid($rule,$value) {
		if(!method_exists($this, $rule)) {
			return false;
		}
		return $this->$rule($value);
	}
	
	private function _reg($value,$regex) {
		return preg_match($regex, $value);
	}
			
	function alphaNum($value) {
		$regex = '/^[\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]+$/Du';
		return $this->_reg($value, $regex);
	}
	
	function phone($value) {
		$regex = '/^((8|\+7)[\- ]?)(\d{3}[\- ]?)(\d{7})$/';
		return $this->_reg($value, $regex);
	}
}