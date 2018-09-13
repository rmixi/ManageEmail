<?php

class Hero_ManageEmail_Block_Adminhtml_Emailqueue_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("emailqueueGrid");
				$this->setDefaultSort("recipient_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("manageemail/emailqueue")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
			
				$this->addColumn("recipient_id", array(
				"header" => Mage::helper("manageemail")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "recipient_id",
				));

				$this->addColumn("recipient_email", array(
				"header" => Mage::helper("manageemail")->__("Email"),
				"index" => "recipient_email",
				//	'frame_callback' => array($this, 'checkDomain')
				));
				$this->addColumn("recipient_name", array(
				"header" => Mage::helper("manageemail")->__("Name"),
				"index" => "recipient_name",
				));
		//	$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
		//	$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

	public function getRowClass(Varien_Object $row)
	{
		$email = $row->getData('recipient_email');
		$isBroken = true;
		if(strlen($email)) {
				///echo filter_var($email, FILTER_VALIDATE_EMAIL); die;
			if (1) {
				list($name, $domain) = explode('@', $email);
				$isBroken = checkdnsrr($domain);
			} else {
				$isBroken = false;
			}
		} else {
			$isBroken = false;
		}

		return ($isBroken) ? '' : 'invalid';
	}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}

		function checkDomain($value, $row, $column, $isExport)
		{
			print_r(get_class($column)); die;

		}

		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('recipient_id');
			$this->getMassactionBlock()->setFormFieldName('recipient_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_emailqueue', array(
					 'label'=> Mage::helper('manageemail')->__('Remove Emailqueue'),
					 'url'  => $this->getUrl('*/adminhtml_emailqueue/massRemove'),
					 'confirm' => Mage::helper('manageemail')->__('Are you sure?')
				));
			return $this;
		}
			

}