<?php

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

/**
 * Class JFormFieldContact
 * @since 1.0.0
 * @package OtherCode.Joomla.SimpleContactForm
 * @subpackage mod_simplecontactform
 * @copyright Copyright (C) 2016 OtherCode. All rights reserved.
 * @license MIT
 */
class JFormFieldContact extends JFormFieldList
{

    /**
     * Form type
     * @since 1.0.0
     * @var string
     */
    protected $type = 'Contact';

    /**
     * Return the list of contacts.
     * @since 1.0.0
     * @return array
     */
    public function getOptions()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('id AS value, name AS text')
            ->from('#__contact_details AS a')
            ->where('a.published = 1')
            ->order('a.name');

        $options = $db->setQuery($query)->loadObjectList();
        array_unshift($options, JHtml::_('select.option', '0', JText::_('MOD_SIMPLECONTACTFORM_NO_CONTACT')));

        return $options;
    }

    /**
     * Return an Email searched by Contact ID
     * @param integer $id
     * @throws \Exception
     * @since 1.0.0
     * @return string
     */
    public function getContactEmailByID($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('email_to')
            ->from('#__contact_details AS a')
            ->where('a.id = ' . (int)$id)
            ->where('a.published = 1');
        $db->setQuery($query);

        return $db->loadObject()->email_to;
    }

    /**
     * Return a lust of contacts in a category.
     * @param integer $id
     * @return array
     * @since 1.0.0
     */
    public function getContactsByCategoryID($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('a.id AS value, a.name AS text')
            ->from('#__contact_details AS a')
            ->from('#__categories AS b')
            ->where('a.published = 1')
            ->where('a.catid = ' . (int)$id)
            ->where('a.catid = b.id')
            ->order('a.name');

        $options = $db->setQuery($query)->loadObjectList();
        array_unshift($options, JHtml::_('select.option', '0', JText::_('MOD_SIMPLECONTACTFORM_SELECT_CONTACT')));

        return $options;
    }
}
