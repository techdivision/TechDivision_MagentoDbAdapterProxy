<?php
/**
 * TechDivision_Db_Adapter_Service_Dummy
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Implements dummy service for proxy_mysql adapter
 *
 * @category   TechDivision
 * @package    TechDivision_MagentoDbAdapterProxy
 * @subpackage lib
 * @copyright  Copyright (c) 1996-2012 TechDivision GmbH (http://www.techdivision.com)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    ${release.version}
 * @since      Class available since Release 0.1.0
 * @author     Johann Zelger <j.zelger@techdivision.com>
 */

class TechDivision_Db_Adapter_Service_Dummy {

    protected $adapter;

    public function __construct($config)
    {
        $this->adapter = new Magento_Db_Adapter_Pdo_Mysql($config);
    }

    public function __call($method, $args)
    {
        error_log(__CLASS__ . '::' . $method);
        return call_user_func_array(array($this->adapter, $method), $args);
    }

}