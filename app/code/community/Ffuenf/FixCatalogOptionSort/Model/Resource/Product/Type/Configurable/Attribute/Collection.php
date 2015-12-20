<?php

/**
 * Ffuenf_FixCatalogOptionSort extension.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category   Ffuenf
 *
 * @author     Achim Rosenhagen <a.rosenhagen@ffuenf.de>
 * @copyright  Copyright (c) 2015 ffuenf (http://www.ffuenf.de)
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 */
class Ffuenf_FixCatalogOptionSort_Model_Resource_Product_Type_Configurable_Attribute_Collection extends Mage_Catalog_Model_Resource_Product_Type_Configurable_Attribute_Collection
{
    /**
     * Load attribute prices information.
     *
     * @return Mage_Catalog_Model_Resource_Product_Type_Configurable_Attribute_Collection
     */
    protected function _loadPrices()
    {
        if ($this->count()) {
            $pricings = array(0 => array());
            if ($this->getHelper()->isPriceGlobal()) {
                $websiteId = 0;
            } else {
                $websiteId = (int)Mage::app()->getStore($this->getStoreId())->getWebsiteId();
                $pricings[$websiteId] = array();
            }
            $select = $this->getConnection()->select()->from(array('price' => $this->_priceTable))->where('price.product_super_attribute_id IN (?)', array_keys($this->_items));
            if ($websiteId > 0) {
                $select->where('price.website_id IN(?)', array(0, $websiteId));
            } else {
                $select->where('price.website_id = ?', 0);
            }
            $query = $this->getConnection()->query($select);
            while ($row = $query->fetch()) {
                $pricings[(int)$row['website_id']][] = $row;
            }
            $values = array();
            foreach ($this->_items as $item) {
                $productAttribute = $item->getProductAttribute();
                if (!($productAttribute instanceof Mage_Eav_Model_Entity_Attribute_Abstract)) {
                    continue;
                }
                $options = $productAttribute->getFrontend()->getSelectOptions();
                $optionsByValue = array();
                foreach ($options as $option) {
                    $optionsByValue[$option['value']] = $option['label'];
                }
                foreach ($this->getProduct()->getTypeInstance(true)->getUsedProducts(array($productAttribute->getAttributeCode()), $this->getProduct()) as $associatedProduct) {
                    $optionValue = $associatedProduct->getData($productAttribute->getAttributeCode());
                    if (array_key_exists($optionValue, $optionsByValue)) {
                        // If option available in associated product
                        if (!isset($values[$item->getId() . ':' . $optionValue])) {
                            // If option not added, we will add it.
                            $values[$item->getId() . ':' . $optionValue] = array(
                                'product_super_attribute_id' => $item->getId(),
                                'value_index' => $optionValue,
                                'label' => $optionsByValue[$optionValue],
                                'default_label' => $optionsByValue[$optionValue],
                                'store_label' => $optionsByValue[$optionValue],
                                'is_percent' => 0,
                                'pricing_value' => null,
                                'use_default_value' => true,
                            );
                        }
                    }
                }
            }
            foreach ($pricings[0] as $pricing) {
                // Addding pricing to options
                $valueKey = $pricing['product_super_attribute_id'] . ':' . $pricing['value_index'];
                if (isset($values[$valueKey])) {
                    $values[$valueKey]['pricing_value'] = $pricing['pricing_value'];
                    $values[$valueKey]['is_percent'] = $pricing['is_percent'];
                    $values[$valueKey]['value_id'] = $pricing['value_id'];
                    $values[$valueKey]['use_default_value'] = true;
                }
            }
            if ($websiteId && isset($pricings[$websiteId])) {
                foreach ($pricings[$websiteId] as $pricing) {
                    $valueKey = $pricing['product_super_attribute_id'] . ':' . $pricing['value_index'];
                    if (isset($values[$valueKey])) {
                        $values[$valueKey]['pricing_value'] = $pricing['pricing_value'];
                        $values[$valueKey]['is_percent'] = $pricing['is_percent'];
                        $values[$valueKey]['value_id'] = $pricing['value_id'];
                        $values[$valueKey]['use_default_value'] = false;
                    }
                }
            }
            if (Mage::helper('ffuenf_fixcatalogoptionsort')->isExtensionActive()) {
                $sortOrder = 1;
                foreach ($this->_items as $item) {
                    $productAttribute = $item->getProductAttribute();
                    if (!($productAttribute instanceof Mage_Eav_Model_Entity_Attribute_Abstract)) {
                        continue;
                    }
                    $options = $productAttribute->getFrontend()->getSelectOptions();
                    foreach ($options as $option) {
                        if (!$option['value']) {
                            continue;
                        }
                        if (isset($values[$item->getId() . ':' . $option['value']])) {
                            $values[$item->getId() . ':' . $option['value']]['order'] = $sortOrder++;
                        }
                    }
                    usort($values, function($a, $b) {
                        return $a['order'] - $b['order'];
                    });
                }
            }
            foreach ($values as $data) {
                $this->getItemById($data['product_super_attribute_id'])->addPrice($data);
            }
        }

        return $this;
    }
}
