<?php
/**
 * Created by PhpStorm.
 * User: stanislavz
 * Date: 03.08.18
 * Time: 17:25
 */

namespace Stanislavz\CurrentCategory\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;

class RecentlyVisitedCategories extends \Magento\Framework\View\Element\Template
{

    const XML_PATH_CATEGORY_QUANTITY = 'customer/recent_category/recent_category_quantity';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Catalog\Model\CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var CurrentCategoryModule
     */
    private $pagePreloader;

    /**
     * @var \Stanislavz\CurrentCategory\Model\RecentCategoryFactory
     */
    private $model;

    public function __construct(
        CurrentCategoryModule $pagePreloader,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Stanislavz\CurrentCategory\Model\RecentCategoryFactory $model,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->pagePreloader = $pagePreloader;
        $this->scopeConfig = $scopeConfig;
        $this->categoryRepository= $categoryRepository;
        $this->model = $model;
    }

    /**
     * @return int
     */
    private function getCustomerId(): int
    {
        return $this->pagePreloader->getCustomerId();
    }

    /**
     * @return int
     */
    private function getLimit(): int
    {
        $limit = $this->scopeConfig->getValue(self::XML_PATH_CATEGORY_QUANTITY, ScopeInterface::SCOPE_STORES);
        return (int) $limit;
    }

    /**
     * @param $categoryId
     * @return \Magento\Catalog\Api\Data\CategoryInterface|mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCategory($categoryId)
    {
        return $this->categoryRepository->get($categoryId);
    }

    public function getRecentlyVisitedCategories()
    {
        $model = $this->model->create();
        $connection = $model->getResource()->getConnection();
        $tableName = $model->getResource()->getTable($model::MAIN_TABLE);
        $select = $connection->select()->from($tableName, 'category_id')
                                        ->where('customer_id = :customer_id')
                                        ->limit($this->getLimit());
        $result = $connection->fetchAll($select, [':customer_id' => $this->getCustomerId()]);
        return $result;
    }
}
