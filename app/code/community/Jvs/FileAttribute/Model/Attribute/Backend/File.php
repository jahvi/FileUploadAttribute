<?php
/**
 * Backend model for file upload input type
 *
 * @category Jvs
 * @package  Jvs_FileAttribute
 * @author   Javier Villanueva <javiervd@gmail.com>
 */
class Jvs_FileAttribute_Model_Attribute_Backend_File
    extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
    /**
     * After attribute is saved upload file to media
     * folder and save it to its associated product.
     *
     * @param  Mage_Catalog_Model_Product $object
     * @return Jvs_FileAttribute_Model_Attribute_Backend_File
     */
    public function afterSave($object)
    {
        $value = $object->getData($this->getAttribute()->getName());

        if (is_array($value) && !empty($value['delete'])) {
            $object->setData($this->getAttribute()->getName(), '');
            $this->getAttribute()->getEntity()
                ->saveAttribute($object, $this->getAttribute()->getName());
            return;
        }

        try {
            $uploadedFile = new Varien_Object();
            $uploadedFile->setData('name', $this->getAttribute()->getName());
            $uploadedFile->setData(
                'allowed_extensions',
                array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png',
                    'tif',
                    'tiff',
                    'mpg',
                    'mpeg',
                    'mp3',
                    'wav',
                    'pdf',
                    'txt',
                )
            );

            Mage::dispatchEvent(
                'jvs_fileattribute_allowed_extensions',
                array('file' => $uploadedFile)
            );

            $uploader = new Mage_Core_Model_File_Uploader($this->getAttribute()->getName());
            $uploader->setAllowedExtensions($uploadedFile->getData('allowed_extensions'));
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);

            $uploader->save(Mage::getBaseDir('media') . '/catalog/product');
        } catch (Exception $e) {
            return $this;
        }

        $fileName = $uploader->getUploadedFileName();

        if ($fileName) {
            $object->setData($this->getAttribute()->getName(), $fileName);
            $this->getAttribute()->getEntity()
                ->saveAttribute($object, $this->getAttribute()->getName());
        }

        return $this;
    }
}
