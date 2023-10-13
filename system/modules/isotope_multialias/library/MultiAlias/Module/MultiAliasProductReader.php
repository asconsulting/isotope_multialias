<?php

/**
 * Isotope Multi Alias
 *
 * Copyright (C) 2019-2023 Andrew Stevens Consulting
 *
 * @package    asconsulting/isotope_multialias
 * @link       https://andrewstevens.consulting
 */

 
 
namespace MultiAlias\Module;

use MultiAlias\Model\Product\MultiAlias;
use Isotope\Module\ProductReader;
use Haste\Http\Response\HtmlResponse;



/**
 * Class ProductReader
 *
 * @property bool   $iso_use_quantity
 * @property bool   $iso_display404Page
 * @property bool   $iso_addProductJumpTo
 * @property string $iso_reader_layout
 * @property int    $iso_gallery
 */
class MultiAliasProductReader extends ProductReader
{
 
    /**
     * Generate module
     * @return void
     */
    protected function compile()
    {
        global $objPage;
        global $objIsotopeListPage;

        $objProduct = MultiAlias::findAvailableByIdOrAlias(\Haste\Input\Input::getAutoItem('product'));

        if (null === $objProduct) {
            $this->generate404();
        }

        $arrConfig = array(
            'module'      => $this,
            'template'    => $this->iso_reader_layout ? : $objProduct->getType()->reader_template,
            'gallery'     => $this->iso_gallery ? : $objProduct->getType()->reader_gallery,
            'buttons'     => $this->iso_buttons,
            'useQuantity' => $this->iso_use_quantity,
            'jumpTo'      => $objIsotopeListPage ? : $objPage,
        );

        if (\Environment::get('isAjaxRequest')
            && \Input::post('AJAX_MODULE') == $this->id
            && \Input::post('AJAX_PRODUCT') == $objProduct->getProductId()
        ) {
            try {
                $objResponse = new HtmlResponse($objProduct->generate($arrConfig));
                $objResponse->send();
            } catch (\InvalidArgumentException $e) {
                return;
            }
        }

        $this->addMetaTags($objProduct);
        $this->addCanonicalProductUrls($objProduct);

        $this->Template->product       = $objProduct->generate($arrConfig);
        $this->Template->product_id    = $this->getCssId($objProduct);
        $this->Template->product_class = $this->getCssClass($objProduct);
        $this->Template->referer       = 'javascript:history.go(-1)';
        $this->Template->back          = $GLOBALS['TL_LANG']['MSC']['goBack'];
    }
	
	 /**
     * Generates a 404 page and stops page output.
     */
    private function generate404()
    {
        global $objPage;
        /** @var \PageError404 $objHandler */
        $objHandler = new $GLOBALS['TL_PTY']['error_404']();
        $objHandler->generate($objPage->id);
        exit;
    }

}
