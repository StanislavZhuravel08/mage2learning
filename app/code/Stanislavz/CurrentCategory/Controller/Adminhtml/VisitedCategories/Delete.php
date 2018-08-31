<?php

namespace Stanislavz\CurrentCategory\Controller\Adminhtml\VisitedCategories;

use Stanislavz\CurrentCategory\Model\RecentCategory;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Stanislavz_CurrentCategory::current_category_delete';

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('visit_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Stanislavz\CurrentCategory\Model\RecentCategory::class);
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('The visited category has been deleted.'));
                // go to grid
                $this->_eventManager->dispatch(
                    'adminhtml_current_category_on_delete',
                    ['title' => $title, 'status' => 'success']
                );
                return $resultRedirect->setPath('current_category/index/index/');
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_current_category_on_delete',
                    ['title' => $title, 'status' => 'fail']
                );
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('current_category/index/index/', ['visit_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a visited category to delete.'));
        // go to grid
        return $resultRedirect->setPath('current_category/index/index/');
    }
}
