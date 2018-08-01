<?php

namespace Stanislavz\CurrentCategory\Block;

use \Magento\Catalog\Model\Category;
use \Magento\Framework\Registry;
use \Magento\Catalog\Model\CategoryFactory;
use \Stanislavz\CurrentCategory\LogginedUserCheck;

class CurrentCategory extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    private $logginedUserCheck;

    /**
     * CurrentCategory constructor.
     * @param Registry $registry
     * @param CategoryFactory $categoryFactory
     * @param LogginedUserCheck $logginedUserCheck
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        Registry $registry,
        CategoryFactory $categoryFactory,
        LogginedUserCheck $logginedUserCheck,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->registry = $registry;
        $this->categoryFactory = $categoryFactory;
        $this->logginedUserCheck = $logginedUserCheck;
    }

    /**
     * @return string
     */
    public function getCategoryNames(): string
    {
        return $this->getCategoryName();
    }

    /**
     * @return string
     */
    private function getCategoryName(): string
    {
        $categoryPath = $this->getCurrentCategoryPath();
        $categoryNames = [];

        if ($categoryPath !== null) {
            foreach ($categoryPath as $index => $id) {
                if ((int)$id === 1 || (int)$id === 2) {
                    continue;
                }
                $categoryNames[$index] = $this->getCategoryNameById((int)$id);
            }
            return implode(' > ', $categoryNames);
        }
        return '';
    }

    /**
     * @param $id
     * @return string
     */
    private function getCategoryNameById($id): string
    {
        $categoryId = $id;
        $category = $this->categoryFactory->create()->load($categoryId);
        return $category->getName();
    }

    private function getCurrentCategory()
    {
        return $this->registry->registry('current_category');
    }

    /**
     * @return mixed
     */
    private function getCurrentCategoryPath()
    {
        $category = $this->getCurrentCategory();

        if ($category === null) {
            return null;
        }
        return $category->getPathIds();
    }

    /**
     * @return mixed
     */
    public function getCategoryUrl()
    {
        $category = $this->getCurrentCategory();

        if ($category === null) {
            return null;
        }
        return $category->getUrl();
    }

    /**
     * @return bool
     */
    public function testUser(): bool
    {
        return $this->logginedUserCheck->checkUser();
    }

    public function getCustomerId()
    {
        return $this->logginedUserCheck->getCustomerId();
    }
}
