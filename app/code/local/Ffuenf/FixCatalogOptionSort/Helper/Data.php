<?php
/**
* Magento
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
*
* @category    Ffuenf
* @package     Ffuenf_FixCatalogOptionSort
* @author      Achim Rosenhagen <a.rosenhagen@ffuenf.de>
* @copyright   Copyright (c) 2015 ffuenf (http://www.ffuenf.de)
* @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/

class Ffuenf_FixCatalogOptionSort_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * Path for the config for extension active status
     */
    const CONFIG_EXTENSION_ACTIVE = 'ffuenf_fixcatalogoptionsort/general/enabled';

    /**
     * Variable for if the extension is active
     *
     * @var bool
     */
    protected $bExtensionActive;

    /**
     * Check to see if the extension is active
     *
     * @return bool
     */
    public function isExtensionActive()
    {
    if ($this->bExtensionActive === null) {
        $this->bExtensionActive = Mage::getStoreConfigFlag(self::CONFIG_EXTENSION_ACTIVE);
    }
    return $this->bExtensionActive;
    }
}