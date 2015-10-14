<?php

class MobWeb_ProductAppointment_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
    * Log a message.
    *
    * @param $msg string
    */
    public function log($msg)
    {
        Mage::log($msg, NULL, 'MobWeb_ProductAppointment.log');
    }
}