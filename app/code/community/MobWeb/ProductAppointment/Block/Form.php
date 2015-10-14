<?php

class MobWeb_ProductAppointment_Block_Form extends Mage_Core_Block_Template
{
    public function getFormAction()
    {
        return $this->getUrl('productappointment/index/post');
    }

    // Returns an array of days to be displayed when selecting a date for the appointment
    public function getDateOptions()
    {
    	$dateOptions = array();

    	// Get the dates for the next 30 days
    	for($i = 0; $i < 31; $i++) {
    		$dateOption = array();

    		$date = strtotime(sprintf('now +%d days', $i));

    		// If the current day is Sunday, skip it
    		if(date('w', $date) == 0) {
    			continue;
    		}

    		// Format the date according to Magento's locale
    		$date = Mage::helper('core')->formatDate(date('Y-m-d', $date), 'full', false);

    		$dateOptions[] = $date;
    	}

    	return $dateOptions;
    }

    // Returns an array of time slots to be displayed when selecting a time for the appointment
    public function getTimeOptions()
    {
    	$timeOptions = array();

    	// Get the 10 hours between 8am and 5pm
    	for($i = 0; $i < 10; $i++) {
    		$timeOption = array();

    		$time = strtotime(date('Y-m-d' ) . sprintf(' 08:00 + %d hours', $i));

    		// Format the date using "H:i"
    		$time = date('H:i', $time);

    		$timeOptions[] = $time;
    	}

    	return $timeOptions;
    }

    // Returns some information about the current product that will be sent along with the form data
    public function getProductDetails()
    {
        $product = Mage::registry('current_product');

        return sprintf('%s (%s)', $product->getName(), $product->getSku());
    }
}