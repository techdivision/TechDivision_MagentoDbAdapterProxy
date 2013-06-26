<?php
/**
 * TechDivision_MagentoDbAdapterProxy_Model_Resource_Type_Db_Proxy
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Implements resource proxy type for db functionality
 *
 * @category   TechDivision
 * @package    TechDivision_MagentoDbAdapterProxy
 * @subpackage Model
 * @copyright  Copyright (c) 1996-2012 TechDivision GmbH (http://www.techdivision.com)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    ${release.version}
 * @since      Class available since Release 0.1.0
 * @author     Johann Zelger <j.zelger@techdivision.com>
 */

class TechDivision_MagentoDbAdapterProxy_Model_Resource_Type_Db_Proxy
    extends Mage_Core_Model_Resource_Type_Db_Pdo_Mysql
{
    /**
     * Retrieve DB adapter class name
     *
     * @return string
     */
    protected function _getDbAdapterClassName()
    {
        return 'TechDivision_Db_Adapter_Proxy';
    }



}
