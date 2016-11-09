<?php

/**
 * @package OtherCode.Joomla
 * @subpackage mod_simplecontactform
 * @copyright Copyright (C) 2016 OtherCode. All rights reserved.
 * @version 1.4.0
 * @license MIT
 */
defined('_JEXEC') or die('Restricted access');

$instance = md5($params->get('sendto', 0));

/**
 * Load the main systems
 *  - Input
 *  - Mailer
 *  - Configuration
 */
$input = JFactory::getApplication()->input;
$mailer = JFactory::getMailer();
$config = JFactory::getConfig();

JFormHelper::addFieldPath(__DIR__ . '/models');
$contactModel = JFormHelper::loadFieldType('Contact', false);

/**
 * Load the default css if needed
 */
if ($params->get('defaultcss') === '1') {
    JFactory::getDocument()->addStyleSheet(JUri::base() . 'media/mod_simplecontactform/css/contact.css');
}

/**
 * Process the email if the request has been sent.
 */
$send = $input->post->get('send', null);
if (isset($send) && $send == $instance) {

    JSession::checkToken() or die ('Invalid token');

    $commentTemplate = $params->get('commenttemplate', '{comment}', 'str');
    $subjectTemplate = $params->get('subjecttemplate', '{subject}', 'str');

    $recipient = null;
    $email = $input->post->get('email', null, $config->get('mailfrom'));
    $name = $input->post->get('name', null, 'str');
    $subject = $input->post->get('subject', null, 'str');
    $file = $input->files->get('ufile');
    $phone = $input->post->get('phone', null);
    $comment = htmlspecialchars($input->post->get('comment', null, 'str'));

    $context = array(
        '{email}' => $email,
        '{name}' => $name,
        '{phone}' => $phone,
        '{subject}' => $subject,
        '{comment}' => $comment,
    );

    if ($input->post->get('destiny', null) !== null) {

        $recipient = $contactModel->getContactEmailByID($input->post->get('destiny'));

    } else {

        /**
         * Check and load the sender name and email.
         *
         * If ID is 0 the load default configuration from
         * main site configuration (configuration.php).
         *
         * If ID is NOT 0 we load the required contact email.
         */
        if ($params->get('sendto') === '0') {
            $recipient = $config->get('mailfrom');
        } else {
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
    $mailer->setSubject(strtr($subjectTemplate,$context));
    $mailer->setBody(strtr($commentTemplate,$context));

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
        JFactory::getApplication()->enqueueMessage(JText::_('MOD_SIMPLECONTACTFORM_SEND_FAIL') . $issend->__toString(), 'error');
    } else {
        JFactory::getApplication()->enqueueMessage(JText::_('MOD_SIMPLECONTACTFORM_SEND_SUCCESS'), 'message');
    }
}

$showcontactdropdown = $params->get('showcontactdropdown');

$contactList = array();
if ($showcontactdropdown === '1') {
    $contactList = $contactModel->getContactsByCategoryID($params->get('category'));
}

$labels = $params->get('showlabels');
$showemail = $params->get('showemail');
$showphone = $params->get('showphone');
$showsubject = $params->get('showsubject');
$showcomment = $params->get('showcomment');
$reset = $params->get('showreset');
$showupload = $params->get('showupload');
$prevtext = $params->get('prevtext');
$nexttext = $params->get('nexttext');
$moduleclass_sfx = $params->get('moduleclass_sfx');

require JModuleHelper::getLayoutPath('mod_simplecontactform');
