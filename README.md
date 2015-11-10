## File Upload Attribute

This extension allows you to create file upload attributes for your products by adding a new input type to the attribute creation form.

You will be able to assign multiple file upload attributes to your products, restrict allowed file extensions and choose to display them automatically on your product pages or display it by yourself however you want to.

### Features

- Create new file upload attribute type from the backend.
- Assign multiple attributes to the same attribute set.
- Display them automatically or manually on the product page.

### How to use?

1. Go to Catalog > Attributes > Manage Attributes and Add New Attribute.
2. Create a new attribute using the "File Upload" input type, if you want to display it automatically on the "Additional Information" tab set "Visible on Product View Page on Front-end" to "Yes".
3. Assign the new attribute to an attribute set.
4. You should be able to see the new file upload attribute when you edit a products, you can upload images, documents, videos or any kind of file type you need.

#### How to change allowed file extensions?

By default the extension allows you to upload files with the following extensions:

- jpg
- jpeg
- gif
- png
- tif
- tiff
- mpg
- mpeg
- mp3
- wav
- pdf
- txt

If you need to extend or restrict the file extensions list you can bind into the `jvs_fileattribute_allowed_extensions` event, eg:

```php
public function changeAllowedFileExtensions(Varien_Event_Observer $observer)
{
  $file = $observer->getEvent()->getFile();
  
  // Add new '.mp4' file extension to the list
  $allowedExtensions = $file->getData('allowed_extensions');
  $allowedExtensions[] = 'mp4';
  $file->setData('allowed_extensions', $allowedExtensions);
  
  // Or, ignore default list and only allow '.pdf' files
  $file->setData('allowed_extensions', array('pdf'));
  
  return $this;
}
```

You can also allow different file extensions per attribute like this:

```php
public function changeAllowedFileExtensions(Varien_Event_Observer $observer)
{
  $file = $observer->getEvent()->getFile();
  
  // Assuming 'document' and 'sample_video' are your attribute codes
  if ($file->getName() == 'document') {
    $file->setData('allowed_extensions', array('pdf'));
  } else if ($file->getName() == 'sample_video') {
    $file->setData('allowed_extensions', array('mp4', 'mpeg', 'avi'));
  }
  
  return $this;
}
```
