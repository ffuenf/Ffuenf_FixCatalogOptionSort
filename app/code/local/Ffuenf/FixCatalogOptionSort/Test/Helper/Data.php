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

class Ffuenf_FixCatalogOptionSort_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Tests is extension active
     *
     * @test
     * @loadFixture
     */
    public function testIsExtensionActive()
    {
    $this->assertTrue(
        Mage::helper('ffuenf_fixcatalogoptionsort')->isExtensionActive(),
        'Extension is not active please check config'
    );
    }
}