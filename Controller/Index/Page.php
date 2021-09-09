<?php

namespace Sa\Content\Controller\Index;

use Sa\Content\Helper\Api as ApiHelper;

class Page extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $_apiHelper;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
        ApiHelper $apiHelper
    ) {
        parent::__construct($context);
		$this->_pageFactory = $pageFactory;
        $this->_apiHelper = $apiHelper;
	}

	public function execute()
	{
        /** Get slug */
        $slug = $this->getRequest()->getParam('slug');

        /** Get result and redirect if don't have result */
        $result = $this->_apiHelper->getPage($slug);

        /** Verify if not result and redirect on home page */
        if (!$result || $result['success'] != true) {
            $this->_redirect('cms/index/index');
            return;
        } else {
            $data = $result['data'];
        }

        /** Create page */
		$resultPage = $this->_pageFactory->create();

        /** Set meta description and keywords of page */
        if (array_key_exists('meta', $data) && $data['meta']) {
            if (array_key_exists('description', $data['meta']) && $data['meta']['description']) {
                $resultPage->getConfig()->setDescription($data['meta']['description']);
            }

            if (array_key_exists('keywords', $data['meta']) && $data['meta']['keywords']) {
                $resultPage->getConfig()->setKeywords($data['meta']['keywords']);
            }
        }

        /** Set title of page */
        if (array_key_exists('title', $data) && $data['title']) {
            $resultPage->getConfig()->getTitle()->set($data['title']);   
        }
        
        /** Set content of page */
        if (array_key_exists('html', $data) && $data['html'] && array_key_exists('css', $data) && $data['css']) {
            $resultPage->getLayout()->getBlock('sa.content.page')
                ->setHtml($data['html'])
                ->setCss($data['css']);
        }

        return $resultPage;
	} 
}