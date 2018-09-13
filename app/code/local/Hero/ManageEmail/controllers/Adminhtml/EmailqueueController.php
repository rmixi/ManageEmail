<?php

class Hero_ManageEmail_Adminhtml_EmailqueueController extends Mage_Adminhtml_Controller_Action
{
		protected function _isAllowed()
		{
		//return Mage::getSingleton('admin/session')->isAllowed('manageemail/emailqueue');
			return true;
		}

		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("manageemail/emailqueue")->_addBreadcrumb(Mage::helper("adminhtml")->__("Emailqueue  Manager"),Mage::helper("adminhtml")->__("Email Queue Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Email Queue Manager"));
			    $this->_title($this->__("Email Queue Manager"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("ManageEmail"));
				$this->_title($this->__("Emailqueue"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("manageemail/emailqueue")->load($id);
				if ($model->getId()) {
					Mage::register("emailqueue_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("manageemail/emailqueue");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Email Queue Manager"), Mage::helper("adminhtml")->__("Email Queue Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Email Queue Description"), Mage::helper("adminhtml")->__("Email Queue Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("manageemail/adminhtml_emailqueue_edit"))->_addLeft($this->getLayout()->createBlock("manageemail/adminhtml_emailqueue_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("manageemail")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function wnewAction()
		{

		$this->_title($this->__("ManageEmail"));
		$this->_title($this->__("Emailqueue"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("manageemail/emailqueue")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("emailqueue_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("manageemail/emailqueue");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Emailqueue Manager"), Mage::helper("adminhtml")->__("Email Queue Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Emailqueue Description"), Mage::helper("adminhtml")->__("Email Queue Description"));


		$this->_addContent($this->getLayout()->createBlock("manageemail/adminhtml_emailqueue_edit"))->_addLeft($this->getLayout()->createBlock("manageemail/adminhtml_emailqueue_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						

						$model = Mage::getModel("manageemail/emailqueue")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Emailqueue was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setEmailqueueData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setEmailqueueData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
					    //core_email_queue
						$model = Mage::getModel("manageemail/emailqueue");
						$model->setId($this->getRequest()->getParam("id"))->delete();
                        $email_queue = Mage::getModel('core/email_queue');
                        $email_queue->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('recipient_ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("manageemail/emailqueue");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'emailqueue.csv';
			$grid       = $this->getLayout()->createBlock('manageemail/adminhtml_emailqueue_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'emailqueue.xml';
			$grid       = $this->getLayout()->createBlock('manageemail/adminhtml_emailqueue_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
