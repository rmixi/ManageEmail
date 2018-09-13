<?php
	
class Hero_ManageEmail_Block_Adminhtml_Emailqueue_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "recipient_id";
				$this->_blockGroup = "manageemail";
				$this->_controller = "adminhtml_emailqueue";
				$this->_updateButton("save", "label", Mage::helper("manageemail")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("manageemail")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("manageemail")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("emailqueue_data") && Mage::registry("emailqueue_data")->getId() ){

				    return Mage::helper("manageemail")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("emailqueue_data")->getId()));

				} 
				else{

				     return Mage::helper("manageemail")->__("Add Item");

				}
		}
}