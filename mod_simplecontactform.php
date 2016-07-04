<?php

defined('_JEXEC') or die('Restricted access');


$document = JFactory::getDocument();
$document->addStyleSheet(JUri::base() . 'media/mod_simplecontactform/css/contact.css');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require(JModuleHelper::getLayoutPath('mod_simplecontactform'));