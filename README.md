Magento Autodelete Product Images
=================================

When you remove an image from a product the file itself it's not deleted from the filesystem.
Also when you delete a product using Magento backend all the images are not deleted from the filesystem.

This module checks every modification to a product (upon saving and delete), understands what media files have been removed and deletes them from the filesystem.

Note: Not tested (and not made for that case) against "media" saved on database.

Backup!!!
---------
Backup everything while using this module!!!
This module is provided "as is" and I'll not be responsible for any data damage.

Installation
------------

Simply download the whole repository and copy everything to your Magento document root.
Otherwise with modman:
```shell
modman clone https://github.com/fballiano/magento-autodelete-product-images
```

Compatibility
-------------
This module was developed on Magento 1.9.
If you have a different version of Magento and the module is working please drop me a line so I can update this compatibility list.

Support
-------
If you have any issues with this extension, open an issue on GitHub (see URL above).

Contribution
------------
Any contributions are highly appreciated. The best way to contribute code is to open a
[pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
Fabrizio Balliano
[http://fabrizioballiano.it](http://fabrizioballiano.it)  
[@fballiano](https://twitter.com/fballiano)

Licence
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2014 Fabrizio Balliano
