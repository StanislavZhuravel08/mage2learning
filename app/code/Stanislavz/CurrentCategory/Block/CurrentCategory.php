<?php

namespace Stanislavz\CurrentCategory\Block;

use \Magento\Catalog\Model\Category;
use \Magento\Framework\Registry;
use \Magento\Catalog\Model\CategoryFactory;
use \Magento\Framework\App\Request\Http;

class CurrentCategory extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Http
     */
    private $request;
    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * CurrentCategory constructor.
     * @param Registry $registry
     * @param CategoryFactory $categoryFactory
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        Http $request,
        Registry $registry,
        CategoryFactory $categoryFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->request = $request;
        $this->registry = $registry;
        $this->categoryFactory = $categoryFactory;
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
        $categoryName = $category->getName();
        return $categoryName;
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
        $paths = $category->getPathIds();
        return $paths;
    }

    public function getCategoryUrl()
    {
        $category = $this->getCurrentCategory();

        if ($category === null) {
            return null;
        }
        $url = $category->getUrl();
        return $url;
    }
}
