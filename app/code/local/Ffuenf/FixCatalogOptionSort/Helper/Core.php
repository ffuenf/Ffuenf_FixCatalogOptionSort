<?php

class Ffuenf_FixCatalogOptionSort_Helper_Core extends Mage_Core_Helper_Abstract
{
    /**
     * Get a store flag value and set to against the object
     *
     * @param string $sStoreFlagPath
     * @param string $sStoreFlagAttribute
     * @return bool
     */
    public function getStoreFlag($sStoreFlagPath, $sStoreFlagAttribute)
    {
        return (bool)$this->getStoreConfig($sStoreFlagPath, $sStoreFlagAttribute);
    }
    /**
     * Get a store config value and set against the object
     *
     * @param string $sStoreConfigPath
     * @param string $sStoreConfigAttribute
     * @return string
     */
    public function getStoreConfig($sStoreConfigPath, $sStoreConfigAttribute)
    {
        if ($this->$sStoreConfigAttribute === null) {
            $this->$sStoreConfigAttribute = Mage::getStoreConfig($sStoreConfigPath);
        }
        return $this->$sStoreConfigAttribute;
    }
}