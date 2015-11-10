<?php
/**
 * Product description block
 *
 * @category Jvs
 * @package  Jvs_FileAttribute
 * @author   Javier Villanueva <javiervd@gmail.com>
 */
class Jvs_FileAttribute_Block_Product_View_Attributes extends Mage_Catalog_Block_Product_View_Attributes
{
    /**
     * $excludeAttr is optional array of attribute codes to
     * exclude them from additional data array
     *
     * @param  array $excludeAttr
     * @return array
     */
    public function getAdditionalData(array $excludeAttr = array())
    {
        $data = array();
        $product = $this->getProduct();
        $attributes = $product->getAttributes();
        foreach ($attributes as $attribute) {
            if ($attribute->getIsVisibleOnFront() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
                $value = $attribute->getFrontend()->getValue($product);

                if (!$product->hasData($attribute->getAttributeCode())) {
                    $value = Mage::helper('catalog')->__('N/A');
                } elseif ((string)$value == '') {
                    $value = Mage::helper('catalog')->__('No');
                } elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
                    $value = Mage::app()->getStore()->convertPrice($value, true);
                }

                // If 'file upload' input type generate download link
                if ($attribute->getFrontendInput() == 'jvs_file'
                    && (string)$value != Mage::helper('catalog')->__('No')
                    && (string)$value != Mage::helper('catalog')->__('N/A')
                ) {
                    $value = '<a href="' . $this->escapeUrl(Mage::getBaseUrl('media') . 'catalog/product' . $value) . '">';
                    $value .= Mage::helper('jvs_fileattribute')->__('Download');
                    $value .= '</a>';
                }

                if (is_string($value) && strlen($value)) {
                    $data[$attribute->getAttributeCode()] = array(
                        'label' => $attribute->getStoreLabel(),
                        'value' => $value,
                        'code'  => $attribute->getAttributeCode()
                    );
                }
            }
        }
        return $data;
    }
}
