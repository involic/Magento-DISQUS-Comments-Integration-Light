<?php
/**
 * File Comments.php
 * Created: 14.03.2011
 *
 * Disqus integratation to magento e-commerce platform.
 * Adding comments box for all product page.
 *
 * @category    Involic
 * @package     Involic_Disqus
 * @copyright   Copyright (c) 2011 by Involic (http://www.involic.com)
 */
class Involic_Disqus_Block_Product_Comments extends Mage_Core_Block_Template {

    /**
     * Get Id of loaded product or return false when not active product
     *
     * @return int|bool id of loaded product or false
     */
    public function getProductId() {
        if ($product = Mage::registry('current_product')) {
            return $product->getId();
        }
        return false;
    }

    /**
     * Result of checking of enabled disqus (entered forum id and has loaded product)
     *
     * @return <type>
     */
    public function isDisqusEnabled() {
        if (!$this->getProductId() || !$this->getDisqusForum()) {
            return false;
        }
        return true;
    }

    /**
     * Return entered disqus forum short name
     *
     * @return string
     */
    public function getDisqusForum() {
        return Mage::getStoreConfig("disqus/general/disqus_short_name");
    }

    /**
     * Return result of enabled debug|developer mode for disqus integration
     *
     * @return boolean
     */
    public function getDisqusDeveloper() {
        return Mage::getStoreConfig("disqus/general/disqus_debug_mode");
    }

    /**
     * Get url of loaded product or false
     *
     * @return string|bool
     */
    public function getProductUrl() {
        if ($product = Mage::registry('current_product')) {
            return $product->getProductUrl();
        }
        return false;
    }

    /**
     * Get unique disqus identifier for current disqus view page (product view)
     *
     * @return string
     */
    public function getDisqusIdentifier() {
        if ($forum = $this->getDisqusForum() && $productId = $this->getProductId()) {
            return substr(md5($forum), 0, 10) . '_id' . $productId;
        }
    }

    protected function _beforeToHtml() {
        if (!$this->isDisqusEnabled()) {
            return false;
        }
        return parent::_beforeToHtml();
    }

}