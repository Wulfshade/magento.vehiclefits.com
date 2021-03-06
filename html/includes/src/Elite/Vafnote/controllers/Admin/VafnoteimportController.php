<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Elite_Vafnote_Admin_VafnoteimportController extends Mage_Adminhtml_Controller_Action
{
    
    protected $block;
    
    function indexAction()
    {
        // magento boiler plate
        $this->loadLayout();
        $this->_setActiveMenu('vaf');
        $this->block = $this->getLayout()->createBlock('core/template' );
       	$this->block->setTemplate( 'vf/vafnote/import.phtml');
       	
       	$this->guts();
       	
       	// magento boiler plate
        $this->_addContent( $this->block );
        $this->renderLayout();
    }
    
    function guts()
    {
		if( isset( $_FILES['file']['error'] ) && $_FILES['file']['error'] === 0 )
        {
			$importer = new Elite_Vafnote_Model_Import($_FILES['file']['tmp_name']);
            $importer->import();
            
            $this->block->messages = 'Done';
        }
    }
    
}