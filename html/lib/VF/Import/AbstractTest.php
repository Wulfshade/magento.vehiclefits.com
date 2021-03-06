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
class VF_Import_AbstractTest extends Elite_Vaf_TestCase
{
	protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
    }
    
    function testShouldGetProductId()
	{
		$import = new VF_Import_AbstractTestSubClass;
		$expectedProductId = $this->insertProduct('sku');
		$this->assertEquals( $expectedProductId, $import->productId('sku') );
	}
	
    function testRegression()
	{
		$import = new VF_Import_AbstractTestSubClass;
		$this->getReadAdapter()->query('update test_catalog_product_entity set sku=\'\' where 0');
		$expectedProductId = $this->insertProduct('sku');
		$this->assertEquals( $expectedProductId, $import->productId('sku') );
	}
}

class VF_Import_AbstractTestSubClass extends VF_Import_Abstract
{
	function __construct()
	{
		
	}
	
	function getProductTable()
	{
		return 'test_catalog_product_entity';
	}
}