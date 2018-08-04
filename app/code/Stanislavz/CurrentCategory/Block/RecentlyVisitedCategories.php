<?php
/**
 * Created by PhpStorm.
 * User: stanislavz
 * Date: 03.08.18
 * Time: 17:25
 */

namespace Stanislavz\CurrentCategory\Block;

use Magento\Framework\View\Element\Template;

class RecentlyVisitedCategories extends \Magento\Framework\View\Element\Template
{

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
        \Stanislavz\CurrentCategory\Model\RecentCategoryFactory $model,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->pagePreloader = $pagePreloader;
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
                                        ->limit(25)->order('created_at')->group('created_at');
        $result = $connection->fetchAll($select, [':customer_id' => $this->getCustomerId()]);
        return $result;
    }
}
