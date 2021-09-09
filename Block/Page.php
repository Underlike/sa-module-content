<?php

namespace Sa\Content\Block;

use Magento\Framework\View\Element\Template\Context;

class Page extends \Magento\Framework\View\Element\Template
{
	protected $_html;
	protected $_css;

	public function __construct(
        Context $context
    ) {
		parent::__construct($context);
	}

	public function setHtml($html)
    {
		$this->_html = $html;
		return $this;
	}

	public function getHtml()
    {
		return $this->_html; 
	}

	public function setCss($css)
    {
		$this->_css = $css;
		return $this;
	}

	public function getCss()
    {
		return $this->_css; 
	}
}