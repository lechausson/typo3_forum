<?php
/*                                                                    - *
 *  COPYRIGHT NOTICE                                                    *
 *                                                                      *
 *  (c) 2013 Ruven Fehling <r.fehling@mittwald.de>                     *
 *           Mittwald CM Service GmbH & Co KG                           *
 *           All rights reserved                                        *
 *                                                                      *
 *  This script is part of the TYPO3 project. The TYPO3 project is      *
 *  free software; you can redistribute it and/or modify                *
 *  it under the terms of the GNU General Public License as published   *
 *  by the Free Software Foundation; either version 2 of the License,   *
 *  or (at your option) any later version.                              *
 *                                                                      *
 *  The GNU General Public License can be found at                      *
 *  http://www.gnu.org/copyleft/gpl.html.                               *
 *                                                                      *
 *  This script is distributed in the hope that it will be useful,      *
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of      *
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the       *
 *  GNU General Public License for more details.                        *
 *                                                                      *
 *  This copyright notice MUST APPEAR in all copies of the script!      *
 *                                                                      */


/**
 *
 * Repository class for forum objects.
 *
 * @author     Ruven Fehling <r.fehling@mittwald.de>
 * @package    MmForum
 * @subpackage Domain_Repository_User
 * @version    $Id$
 *
 * @copyright  2013 Ruven Fehling <r.fehling@mittwald.de>
 *             Mittwald CM Service GmbH & Co. KG
 *             http://www.mittwald.de
 * @license    GNU Public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 *
 */
class Tx_MmForum_Domain_Repository_User_PrivateMessagesRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {


	/**
	 * Find all messages this user sent and got
	 * @param Tx_MmForum_Domain_Model_User_FrontendUser $user
	 * @param int $limit
	 * @return Tx_MmForum_Domain_Model_User_PrivateMessages[]
	 */
	public function findMessagesForUser(Tx_MmForum_Domain_Model_User_FrontendUser $user, $limit=0) {
		$query = $this->createQuery();
		$query->matching($query->equals('feuser',$user));
		$query->setOrderings(array('tstamp'=> 'DESC'));
		if($limit > 0) {
			$query->setLimit($limit);
		}
		return $query->execute();
	}


	/**
	 * Find all messages this user sent and got
	 * @param Tx_MmForum_Domain_Model_User_FrontendUser $user
	 * @param int $limit
	 * @return Tx_MmForum_Domain_Model_User_PrivateMessages[]
	 */
	public function findReceivedMessagesForUser(Tx_MmForum_Domain_Model_User_FrontendUser $user, $limit=0) {
		$query = $this->createQuery();
		$constraints = array();
		$constraints[] = $query->equals('feuser',$user);
		$constraints[] = $query->equals('type',1);
		$query->matching($query->logicalAnd($constraints));
		$query->setOrderings(array('tstamp'=> 'DESC'));
		if($limit > 0) {
			$query->setLimit($limit);
		}
		return $query->execute();
	}

	/**
	 * Find all messages this user sent and got
	 * @param Tx_MmForum_Domain_Model_User_FrontendUser $user
	 * @param int $limit
	 * @return Tx_MmForum_Domain_Model_User_PrivateMessages[]
	 */
	public function findForwardedMessagesForUser(Tx_MmForum_Domain_Model_User_FrontendUser $user, $limit=0) {
		$query = $this->createQuery();
		$constraints = array($query->equals('feuser',$user));
		$constraints[] = $query->equals('type',1);
		$query->setOrderings(array('tstamp'=> 'DESC'));
		if($limit > 0) {
			$query->setLimit($limit);
		}
		return $query->execute();
	}

}