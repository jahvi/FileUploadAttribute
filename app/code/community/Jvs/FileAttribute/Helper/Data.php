<?php
/**
 * FileAttribute data helper
 *
 * @category Jvs
 * @package  Jvs_FileAttribute
 * @author   Javier Villanueva <javiervd@gmail.com>
 */
class Jvs_FileAttribute_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Change file input display output to a download link
     *
     * @param  Mage_Catalog_Helper_Output $outputHelper
     * @param  string                     $outputHtml
     * @param  array                      $params
     * @return string
     */
    public function productAttribute(Mage_Catalog_Helper_Output $outputHelper, $outputHtml, $params)
    {
        /** @var $product Mage_Catalog_Model_Product */
        $product = $params['product'];

        $attribute = Mage::getModel('eav/entity_attribute')->loadByCode(Mage_Catalog_Model_Product::ENTITY, $params['attribute']);

        if ($attribute && ($attribute->getFrontendInput() == 'jvs_file') && ($attributeValue = $product->getData($params['attribute']))) {
            $outputHtml = sprintf('<a href="%s" download>%s</a>', $this->escapeUrl(Mage::getBaseUrl('media') . 'catalog/product' . $attributeValue), Mage::helper('jvs_fileattribute')->__('Download'));
        }

        return $outputHtml;
    }
}