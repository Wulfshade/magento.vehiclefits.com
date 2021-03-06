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
/** Converts a comma delimeted list of level names into a suitable DDL for the schema */
class Elite_Vafnote_Model_Schema_Generator
{   
    function execute( $showProgress = false )
    {
        $sql = $this->generator();
        foreach( explode( ';', $sql ) as $sql )
        {
            $sql = trim( $sql );
            if( !empty( $sql ) )
            {
                if( $showProgress )
                {
                    echo '.';
                }
                $this->query( $sql );
            }
        }
    }
    
    function generator($levels)
    {
        return 'CREATE TABLE IF NOT EXISTS `elite_note` (
		  `id` int(50) NOT NULL AUTO_INCREMENT,
		  `code` varchar(50) NOT NULL,
		  `message` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `code` (`code`)
		) ENGINE = InnoDB CHARSET=utf8;

        CREATE TABLE IF NOT EXISTS `elite_mapping_notes` (
          `fit_id` int(50) NOT NULL,
          `note_id` varchar(50) NOT NULL,
          PRIMARY KEY (`fit_id`,`note_id`)
        ) ENGINE = InnoDB CHARSET=utf8;';
    }

    protected function query( $sql )
    {
        return $this->getReadAdapter()->query( $sql );
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}