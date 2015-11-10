<?php
class Jvs_FileAttribute_Model_Observer
{
    public function addFileAttributeType(Varien_Event_Observer $observer)
    {
        $response = $observer->getEvent()->getResponse();
        $types = $response->getTypes();
        $types[] = array(
            'value' => 'jvs_file',
            'label' => Mage::helper('jvs_fileattribute')->__('File Upload'),
            'hide_fields' => array(
                'is_unique',
                'is_required',
                'frontend_class',
                'is_configurable',
                '_default_value',

                'is_searchable',
                'is_visible_in_advanced_search',
                'is_filterable',
                'is_filterable_in_search',
                'is_comparable',
                'is_used_for_promo_rules',
                'position',
                'used_in_product_listing',
                'used_for_sort_by',
            )
        );

        $response->setTypes($types);

        return $this;
    }

    public function assignBackendModelToAttribute(Varien_Event_Observer $observer)
    {
        $backendModel = 'jvs_fileattribute/attribute_backend_file';
        /** @var $object Mage_Eav_Model_Entity_Attribute_Abstract */
        $object = $observer->getEvent()->getAttribute();
        if ($object->getFrontendInput() == 'jvs_file') {
            $object->setBackendModel($backendModel);
            $object->setBackendType('varchar');
        }

        return $this;
    }

    public function updateElementTypes(Varien_Event_Observer $observer)
    {
        $response = $observer->getEvent()->getResponse();
        $types = $response->getTypes();
        $types['jvs_file'] = Mage::getConfig()->getBlockClassName('jvs_fileattribute/element_file');
        $response->setTypes($types);
        return $this;
    }
}