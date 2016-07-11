<?php

/**
 * @package OtherCode.Joomla.SimpleContactForm
 * @subpackage mod_simplecontactform
 * @copyright Copyright (C) 2016 OtherCode. All rights reserved.
 * @license MIT
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Load the main systems
 *  - Input
 *  - Mailer
 */
$input = JFactory::getApplication()->input;
$mailer = JFactory::getMailer();

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
    $comment = htmlspecialchars($input->post->get('comment', null, 'str'));

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
         * If not load the configuration from the selected
         * contact element.
         */
        try {

            $db = JFactory::getDbo();
            $query = $db->getQuery(true)
                ->select('email_to')
                ->from('#__contact_details AS a')
                ->where('a.id = ' . (int)$params->get('sendto'))
                ->where('a.published = 1');
            $db->setQuery($query);

            $contact = $db->loadObject();
            $recipient = $contact->email_to;

        } catch (RuntimeException $e) {
            throw new Exception($e->getMessage(), 500);
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
     * Send the email!
     */
    $issend = $mailer->Send();
    if ($issend !== true) {

        /**
         * @TODO Something goes wrong... handle it
         */
    } else {

        /**
         * Everything is OK :D
         */
        JFactory::getApplication()->enqueueMessage(JText::_('MOD_SIMPLECONTACTFORM_SEND_SUCCESS'), 'message');
    }
}

$labels = $params->get('showlabels');
$reset = $params->get('showreset');
$prevtext = htmlspecialchars($params->get('prevtext'));
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_simplecontactform');
