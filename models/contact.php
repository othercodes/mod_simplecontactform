<?php

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

/**
 * Class JFormFieldBannerClient
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

        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('id AS value, name AS text')
            ->from('#__contact_details AS a')
            ->where('a.published = 1')
            ->order('a.name');

        $db->setQuery($query);

        try {
            $options = $db->loadObjectList();
        } catch (RuntimeException $e) {
            JError::raiseWarning(500, $e->getMessage());
        }

        array_unshift($options, JHtml::_('select.option', '0', JText::_('MOD_SIMPLECONTACTFORM_NO_CONTACT')));

        return $options;
    }
}
