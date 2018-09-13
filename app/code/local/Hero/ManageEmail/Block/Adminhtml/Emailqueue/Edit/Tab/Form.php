<?php
class Hero_ManageEmail_Block_Adminhtml_Emailqueue_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("manageemail_form", array("legend"=>Mage::helper("manageemail")->__("Item information")));

				
						$fieldset->addField("recipient_email", "text", array(
						"label" => Mage::helper("manageemail")->__("Email"),
						"name" => "recipient_email",
						));
					
						$fieldset->addField("recipient_name", "text", array(
						"label" => Mage::helper("manageemail")->__("Name"),
						"name" => "recipient_name",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getEmailqueueData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getEmailqueueData());
					Mage::getSingleton("adminhtml/session")->setEmailqueueData(null);
				} 
				elseif(Mage::registry("emailqueue_data")) {
				    $form->setValues(Mage::registry("emailqueue_data")->getData());
				}
				return parent::_prepareForm();
		}
}
