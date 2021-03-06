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
class Elite_Vaftire_Model_Vehicle
{
    /** @var VF_Vehicle */
    protected $wrappedVehicle;
    
    function __construct(VF_Vehicle $vehicle )
    {
        $this->wrappedVehicle = $vehicle;
    }
    
    /** @return Elite_Vaftire_Model_TireSize */
    function tireSize()
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_vehicle_tire', array('section_width','aspect_ratio','diameter'))
            ->where('leaf_id = ?', (int)$this->wrappedVehicle->getLeafValue() );
        
        $result = $this->query($select);
        
        $return = array();
        foreach( $result->fetchAll(Zend_Db::FETCH_OBJ) as $tireSizeStd )
        {
            array_push($return, new Elite_Vaftire_Model_TireSize($tireSizeStd->section_width, $tireSizeStd->aspect_ratio, $tireSizeStd->diameter ) );
        }
        return $return;
    }
    
    function addTireSize( Elite_Vaftire_Model_TireSize $tireSize )
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_vehicle_tire')
            ->where('leaf_id = ?', (int)$this->wrappedVehicle->getLeafValue())
            ->where('section_width = ?', (int)$tireSize->sectionWidth())
            ->where('aspect_ratio = ?', (int)$tireSize->aspectRatio())
            ->where('diameter = ?', (int)$tireSize->diameter());
        
        $result = $select->query();
        if($result->fetchColumn())
        {
            return;
        }
        
        $this->getReadAdapter()->insert('elite_vehicle_tire', array(
            'leaf_id' => (int)$this->wrappedVehicle->getLeafValue(),
            'section_width' => $tireSize->sectionWidth(),
            'aspect_ratio' => $tireSize->aspectRatio(),
            'diameter' => $tireSize->diameter(),
        ));
    }
    
    function vehicle()
    {
    	return $this->wrappedVehicle;
    }
    
    function __call($methodName,$arguments)
    {
        $method = array($this->wrappedVehicle,$methodName);
        return call_user_func_array( $method, $arguments );
    }
    
    /** @return Zend_Db_Statement_Interface */
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