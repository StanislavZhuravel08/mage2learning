<?php

namespace Stanislavz\CurrentCategory\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Stanislavz\CurrentCategory\Helper\HelperData;
use Stanislavz\CurrentCategory\Model\ResourceModel\Category\Collection;

class CategoryCrumbs extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var \Stanislavz\CurrentCategory\Model\ResourceModel\Category\CollectionFactory
     */
    private $currentCategoryCollection;

    private $helperData;

    /**
     * CategoryCrumbs constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Stanislavz\CurrentCategory\Helper\HelperData $helperData,
        \Stanislavz\CurrentCategory\Model\ResourceModel\Category\CollectionFactory $currentCategoryCollectionFactory,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->helperData = $helperData;
        $this->currentCategoryCollection = $currentCategoryCollectionFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritdoc
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);

        /** @var $currentCategoryCollection */
        $currentCategoryCollection = $this->currentCategoryCollection->create();
        // set parent categories as an array of Categories instances
        // stored in currentCategory and get Categories array
        $categories = $this->helperData->getRecentlyVisitedCategories($currentCategoryCollection)->getItems();

        foreach ($categories as $category) {
            $namedPath = '';
            foreach ($category->getParentCategoriesList() as $parent) {
                $namedPath .= $parent->getName() . '>';
                $category->setNamedPath($namedPath);
            }
        }

        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $category = $categories[$item['category_id']];
                $item['path'] = $category->getNamedPath() . $item['value'];
            }
        }

        return $dataSource;
    }
}
