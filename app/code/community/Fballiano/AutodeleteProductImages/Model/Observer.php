<?php
/**
 * FBalliano
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this Module to
 * newer versions in the future.
 *
 * @category   FBalliano
 * @package    FBalliano_AutodeleteProductImages
 * @copyright  Copyright (c) 2014 Fabrizio Balliano (http://fabrizioballiano.it)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Fballiano_AutodeleteProductImages_Model_Observer
{
    public function catalogProductSaveBefore(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        $product_id = $product->getId();
        if ($product_id) {
            $images = array();
            $media = $product->getMediaGallery();
            if ($media) {
                $media = @$media["images"];
                if ($media) {
                    $media = json_decode($media);
                    if (is_array($media)) {
                        foreach ($media as $image) {
                            $image = (string)$image->file;
                            if (substr($image, -4) != ".tmp") {
                                $images[] = $image;
                            }
                        }
                    }
                }
            }
            Mage::register("fballiano_autodeleteproductimages_{$product_id}", $images);
        }
    }

    public function catalogProductSaveCommitAfter(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        $product_id = $product->getId();
        if ($product_id) {
            $product = Mage::getModel("catalog/product")->load($product_id); //needed to get updated gallery
            $images_pre = Mage::registry("fballiano_autodeleteproductimages_{$product_id}");
            if (is_array($images_pre)) {
                $images_post = array();
                $media_post = $product->getMediaGallery();
                $media_post = @$media_post["images"];
                if (is_array($media_post)) {
                    foreach ($media_post as $image) {
                        $images_post[] = $image["file"];
                    }
                }

                foreach ($images_pre as $image) {
                    if (!in_array($image, $images_post)) {
                        $image = Mage::getBaseDir('media') . "/catalog/product{$image}";
                        unlink($image);
                    }
                }
            }

            Mage::unregister("fballiano_autodeleteproductimages_{$product->getId()}");
        }
    }

    public function catalogProductDeleteCommitAfter(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        $product_id = $product->getId();
        if ($product_id) {
            $media_post = $product->getMediaGallery();
            $media_post = @$media_post["images"];
            if (is_array($media_post)) {
                foreach ($media_post as $image) {
                    $image = $image["file"];
                    $image = Mage::getBaseDir('media') . "/catalog/product{$image}";
                    unlink($image);
                }
            }
        }
    }
}