<?php

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

/**
 * Class JFormFieldContact
 * @package OtherCode.Joomla.SimpleContactForm
 * @subpackage mod_simplecontactform
 * @copyright Copyright (C) 2016 OtherCode. All rights reserved.
 * @license MIT
 */
class JFormFieldContact extends JFormFieldList
{

    /**
     * Form type
     * @var string
     */
    protected $type = 'Contact';

    /**
     * Return the list of contacts.
     * @return array
     */
    public function getOptions()
    {
        $options = array();

        try {

            $db = JFactory::getDbo();
            $query = $db->getQuery(true)
                ->select('id AS value, name AS text')
                ->from('#__contact_details AS a')
                ->where('a.published = 1')
                ->order('a.name');

            $db->setQuery($query);


            $options = $db->loadObjectList();
        } catch (RuntimeException $e) {
            JError::raiseWarning(500, $e->getMessage());
        }

        array_unshift($options, JHtml::_('select.option', '0', JText::_('MOD_SIMPLECONTACTFORM_NO_CONTACT')));

        return $options;
    }

    /**
     * Return an Email searched by Contact ID
     * @param $id
     * @throws Exception
     */
    public function getContactEmailByID($id)
    {
        try {

            $db = JFactory::getDbo();
            $query = $db->getQuery(true)
                ->select('email_to')
                ->from('#__contact_details AS a')
                ->where('a.id = ' . (int)$id)
                ->where('a.published = 1');
            $db->setQuery($query);

            return $db->loadObject()->email_to;

        } catch (RuntimeException $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    /**
     * Return a lust of contacts in a category.
     * @param $id
     * @return array
     */
    public function getContactsByCategoryID($id)
    {
        $options = array();

        try {

            $db = JFactory::getDbo();
            $query = $db->getQuery(true)
                ->select('a.id AS value, a.name AS text')
                ->from('#__contact_details AS a')
                ->from('#__categories AS b')
                ->where('a.published = 1')
                ->where('a.catid = ' . (int)$id)
                ->where('a.catid = b.id')
                ->order('a.name');

            $db->setQuery($query);

            $options = $db->loadObjectList();
        } catch (RuntimeException $e) {
            JError::raiseWarning(500, $e->getMessage());
        }

        array_unshift($options, JHtml::_('select.option', '0', JText::_('MOD_SIMPLECONTACTFORM_SELECT_CONTACT')));

        return $options;
    }
}
