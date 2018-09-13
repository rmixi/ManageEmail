<?php
class Hero_ManageEmail_Model_Mysql4_Emailqueue extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("manageemail/emailqueue", "recipient_id");
    }
}