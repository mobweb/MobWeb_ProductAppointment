<?php
class MobWeb_ProductAppointment_IndexController extends Mage_Core_Controller_Front_Action
{
    public function postAction() {

        // Get the parameters from the request sent
        $parameters = $this->getRequest()->getParams();

        // Get the email recipient from the settings
        $emailRecipient = Mage::getStoreConfig('productappointment/email/recipient');

        // Validate the email
        if(!filter_var($emailRecipient, FILTER_VALIDATE_EMAIL)) {
            Mage::helper('productappointment')->log(sprintf('Invalid email recipient: %s', $emailRecipient));
            Mage::getSingleton('core/session')->addError($this->__('There has been a problem submitting your request.'));
        } else {

            // Prepare the email body
            $emailBody = '';
            foreach($parameters AS $key => $value) {
                if($value) {
                    $key = strtoupper(str_replace('_', ' ', $key));
                    $emailBody .= "$key:\n$value\n\n";
                }
            }

            // Send the email
            $mail = Mage::getModel('core/email');
            $mail->setToName($emailRecipient);
            $mail->setToEmail($emailRecipient);
            $mail->setBody($emailBody);
            $mail->setSubject(sprintf('%s: %s', Mage::app()->getStore()->getFrontendName(), $this->__('Product Appointment Request')));
            $mail->setFromEmail($emailRecipient);
            $mail->setFromName($emailRecipient);
            $mail->setType('text');
            $mail->send();

            // Set the success message
            Mage::getSingleton('core/session')->addSuccess($this->__('Your request has been received.'));
        }

        // Redirect the user to the previous page
        $this->_redirectReferer();
    }
}
?>