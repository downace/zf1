<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Test
 * @subpackage PHPUnit
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\Operation\Operation;

/**
 * @see Zend_Test_PHPUnit_Db_Connection
 */
/**
 * Delete All Operation that can be executed on set up or tear down of a database tester.
 *
 * @uses       Operation
 * @category   Zend
 * @package    Zend_Test
 * @subpackage PHPUnit
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Test_PHPUnit_Db_Operation_DeleteAll implements Operation
{
    /**
     * @param Connection $connection
     * @param IDataSet $dataSet
     */
    public function execute(Connection $connection, IDataSet $dataSet): void
    {
        if(!($connection instanceof Zend_Test_PHPUnit_Db_Connection)) {
            throw new Zend_Test_PHPUnit_Db_Exception("Not a valid Zend_Test_PHPUnit_Db_Connection instance, ".get_class($connection)." given!");
        }

        foreach ($dataSet as $table) {
            try {
                $tableName = $table->getTableMetaData()->getTableName();
                $connection->getConnection()->delete($tableName);
            } catch (Exception $e) {
                throw new \PHPUnit\DbUnit\Operation\Exception('DELETEALL', 'DELETE FROM '.$tableName.'', array(), $table, $e->getMessage());
            }
        }
    }
}
