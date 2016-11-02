<?php

/**
 * @package OtherCode.Joomla.SimpleContactForm
 * @subpackage mod_simplecontactform
 * @copyright Copyright (C) 2016 OtherCode. All rights reserved.
 * @version 1.3.0
 * @license MIT
 */
defined('_JEXEC') or die('Restricted access');



/**
 * Load the main systems
 *  - Input
 *  - Mailer
 *  - Data model
 */
$input = JFactory::getApplication()->input;
$mailer = JFactory::getMailer();

JFormHelper::addFieldPath(__DIR__ . '/models');
$contactModel = JFormHelper::loadFieldType('Contact', false);

/**
 * Load the default css if needed
 */
if ($params->get('defaultcss') === '1') {
    $document = JFactory::getDocument();
    $document->addStyleSheet(JUri::base() . 'media/mod_simplecontactform/css/contact.css');
}

/**
 * Process the email if the request has been sent.
 */
$send = $input->post->get('send', null);
if (isset($send)) {

    $recipient = null;
    $email = $input->post->get('email', null, 'raw');
    $name = $input->post->get('name', null, 'str');
    $subject = $input->post->get('subject', null, 'str');
    $file = $input->files->get('ufile');
    $comment = htmlspecialchars($input->post->get('comment', null, 'str'));


    if($input->post->get('destiny', null) ==! null) {

        $recipient = $contactModel->getContactEmailByID($input->post->get('destiny'));

    } else {

        /**
         * Check and load the sender name and email.
         */
        if ($params->get('sendto') === '0') {

            /**
             * If ID is 0 the load default configuration from
             * main site configuration (configuration.php).
             */
            try {

                $config = JFactory::getConfig();
                $recipient = $config->get('mailfrom');

            } catch (RuntimeException $e) {
                throw new Exception($e->getMessage(), 500);
            }

        } else {

            /**
             * If ID is NOT 0 we load the required contact email.
             */
            $recipient = $contactModel->getContactEmailByID($params->get('sendto'));
        }
    }

    /**
     * Configure the mailer with all the parameters
     *  - sender
     *  - recipient
     *  - subject
     *  - body
     */
    $mailer->setSender(array($email, $name));
    $mailer->addRecipient($recipient);
    $mailer->setSubject($subject);
    $mailer->setBody($comment);

    /**
     * Set the attached file if exists, by default we
     * save the uploaded file in the images/uploads but
     * we can change this folder in the module configuration
     */
    if (isset($file)) {

        $filename = JFile::makeSafe($file['name']);
        $destiny = JPATH_SITE . "/images/" . $params->get('uploadpath') . "/" . date('YmdHis') . '-' . $filename;

        if (JFile::upload($file['tmp_name'], $destiny)) {
            $mailer->addAttachment($destiny);
        }
    }

    /**
     * Send the email!
     */
    $issend = $mailer->Send();
    if ($issend !== true) {

        /**
         * Something goes wrong... handle it
         */
        JFactory::getApplication()->enqueueMessage(JText::_('MOD_SIMPLECONTACTFORM_SEND_FAIL') . $issend->__toString(), 'error');
    } else {

        /**
         * Everything is OK :D
         */
        JFactory::getApplication()->enqueueMessage(JText::_('MOD_SIMPLECONTACTFORM_SEND_SUCCESS'), 'message');
    }
}

$showcontactdropdown = $params->get('showcontactdropdown');

$contactList = array();
if($showcontactdropdown === '1') {
    $contactList = $contactModel->getContactsByCategoryID($params->get('category'));
}

$labels = $params->get('showlabels');
$reset = $params->get('showreset');
$showupload = $params->get('showupload');
$prevtext = htmlspecialchars($params->get('prevtext'));
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_simplecontactform');
