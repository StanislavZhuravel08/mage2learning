<?php

namespace Stanislavz\CurrentCategory\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Catalog\Model\Category;
use Magento\Framework\Url\Helper\Data as UrlHelper;

class Helper  extends \Magento\Framework\App\Helper\AbstractHelper
{
    private $urlHelper;

    /**
     * @var \Magento\Framework\Registry
     */
    private $layerResolver;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * Helper constructor.
     * @param Context $context
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Customer\Model\Session $customerSession,
        UrlHelper $urlHelper
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->layerResolver = $layerResolver;
        $this->urlHelper = $urlHelper;
    }

    /**
     * @return Category
     */
    public function getCurrentCategory(): Category
    {
        return $this->layerResolver->get()->getCurrentCategory();
    }

    /**
     * @return bool
     */
    public function isCustomerLoggedIn(): bool
    {
        return $this->customerSession->isLoggedIn();
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        $session = $this->customerSession;
        return $this->isCustomerLoggedIn() ? (int) $session->getCustomer()->getId() : 0;
    }

    /**
     * Retrieve url for adding category to visited-categories section
     *
     * @return string
     */
    public function getAddUrl()
    {
        return $this->_getUrl('current_categories/visited_categories/add');
    }

    /**
     * get data for post by javascript in format acceptable to $.mage.dataPost widget
     *
     * @param string $url
     * @param array $data
     * @return string
     */
    public function getPostData($url, array $data = [])
    {
        if (!isset($data[\Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED])) {
            $data[\Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED] = $this->urlHelper->getEncodedUrl();
        }
        return json_encode(['action' => $url, 'data' => $data]);
    }

    public function getPostDataParams($category)
    {
        return $this->getPostData($this->getAddUrl(), ['category_id' => $category->getId()]);
    }
}
