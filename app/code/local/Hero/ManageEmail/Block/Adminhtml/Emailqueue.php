<?php


class Hero_ManageEmail_Block_Adminhtml_Emailqueue extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_emailqueue";
	$this->_blockGroup = "manageemail";
	$this->_headerText = Mage::helper("manageemail")->__("Email Queue Manager");

		parent::__construct();

		$this->removeButton('add');
	}

}