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
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

require_once "AbstractTestCase.php";

/**
 * @category   Zend
 * @package    Zend_Test
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @group      Zend_Test
 */
class Zend_Test_PHPUnit_Db_Integration_MysqlIntegrationTest extends Zend_Test_PHPUnit_Db_Integration_AbstractTestCase
{
    public function setUp()
    {
        if (!extension_loaded('pdo')) {
            $this->markTestSkipped('PDO is required for this test.');
            return;
        }

        if (!in_array('mysql', PDO::getAvailableDrivers())) {
            $this->markTestSkipped('Mysql is not included in PDO in this PHP installation.');
            return;
        }

        $params = array(
            'host'     => 'mysql',
            'username' => 'zend',
            'password' => 'secret',
            'dbname'   => 'zend_db',
        );

        $this->dbAdapter = Zend_Db::factory('pdo_mysql', $params);
        $this->dbAdapter->query("DROP TABLE IF EXISTS foo");
        $this->dbAdapter->query("DROP TABLE IF EXISTS bar");
        $this->dbAdapter->query(
            'CREATE TABLE foo (id INT(10) AUTO_INCREMENT PRIMARY KEY, foo VARCHAR(255), bar VARCHAR(255), baz VARCHAR(255)) AUTO_INCREMENT=1'
        );
        $this->dbAdapter->query(
            'CREATE TABLE bar (id INT(10) AUTO_INCREMENT PRIMARY KEY, foo VARCHAR(255), bar VARCHAR(255), baz VARCHAR(255)) AUTO_INCREMENT=1'
        );
    }
}
