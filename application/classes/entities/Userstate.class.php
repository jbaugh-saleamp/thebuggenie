<?php

	namespace thebuggenie\entities;

	/**
	 * User state class
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 3.1
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package thebuggenie
	 * @subpackage core
	 */

	/**
	 * User state class
	 *
	 * @package thebuggenie
	 * @subpackage core
	 */
	class Userstate extends Datatype 
	{
		static protected $_b2dbtablename = '\\thebuggenie\\tables\\Userstates';
		
		protected $_is_online = false;
		protected $_is_unavailable = false;
		protected $_is_busy = false;
		protected $_is_in_meeting = false;
		protected $_is_absent = false;
		
		static $_userstates = null;
		
		protected $_itemtype = \thebuggenie\entities\Datatype::USERSTATE;
		
		public static function getAll()
		{
			if (self::$_userstates === null)
			{
				if (!($states = TBGCache::get(TBGCache::KEY_USERSTATES_CACHE)))
				{
					$res = \thebuggenie\tables\UserState::getTable()->doSelectAll();
					$states = array();
					while ($row = $res->getNextRow())
					{
						$states[$row->get(\thebuggenie\tables\UserState::ID)] = \caspar\core\Caspar::factory()->manufacture('\\thebuggenie\\core\\UserState', $row->get(\thebuggenie\tables\UserState::ID), $row);
					}
					TBGCache::add(TBGCache::KEY_USERSTATES_CACHE, $states);
				}
				self::$_userstates = $states;
			}
			return self::$_userstates;
		}
		
		public static function loadFixtures(TBGScope $scope)
		{
			$available = new TBGUserstate();
			$available->setIsOnline();
			$available->setName('Available');
			$available->save();

			$offline = new TBGUserstate();
			$offline->setIsUnavailable();
			$offline->setName('Offline');
			$offline->save();

			$busy = new TBGUserstate();
			$busy->setIsUnavailable();
			$busy->setIsOnline();
			$busy->setName('Busy');
			$busy->save();

			$unavailable = new TBGUserstate();
			$unavailable->setIsUnavailable();
			$unavailable->setIsOnline();
			$unavailable->setName('Unavailable');
			$unavailable->save();

			$in_a_meeting = new TBGUserstate();
			$in_a_meeting->setIsUnavailable();
			$in_a_meeting->setIsInMeeting();
			$in_a_meeting->setName('In a meeting');
			$in_a_meeting->save();

			$coding = new TBGUserstate();
			$coding->setIsUnavailable();
			$coding->setIsBusy();
			$coding->setIsOnline();
			$coding->setName('Coding');
			$coding->save();

			$coffee = new TBGUserstate();
			$coffee->setIsUnavailable();
			$coffee->setIsBusy();
			$coffee->setIsOnline();
			$coffee->setName('On coffee break');

			$away = new TBGUserstate();
			$away->setIsUnavailable();
			$away->setIsOnline();
			$away->setIsBusy();
			$away->setIsAbsent();
			$away->setName('Away');
			$away->save();

			$vacation = new TBGUserstate();
			$vacation->setIsUnavailable();
			$vacation->setIsBusy();
			$vacation->setIsAbsent();
			$vacation->setName('On vacation');
			$vacation->save();
			
			TBGSettings::saveSetting(TBGSettings::SETTING_ONLINESTATE, $available->getID(), 'core', $scope->getID());
			TBGSettings::saveSetting(TBGSettings::SETTING_OFFLINESTATE, $offline->getID(), 'core', $scope->getID());
			TBGSettings::saveSetting(TBGSettings::SETTING_AWAYSTATE, $away->getID(), 'core', $scope->getID());
		}
		
		public function setIsOnline($val = true)
		{
			$this->_is_online = $val;
		}
		
		public function isOnline()
		{
			return $this->_is_online;
		}
		
		public function setIsUnavailable($val = true)
		{
			$this->_is_unavailable = $val;
		}
		
		public function isUnavailable()
		{
			return $this->_is_unavailable;
		}
		
		public function setIsBusy($val = true)
		{
			$this->_is_busy = $val;
		}
		
		public function isBusy()
		{
			return $this->_is_busy;
		}
		
		public function setIsInMeeting($val = true)
		{
			$this->_is_in_meeting = $val;
		}
		
		public function isInMeeting()
		{
			return $this->_is_in_meeting;
		}
		
		public function setIsAbsent($val = true)
		{
			$this->_is_absent = $val;
		}
		
		public function isAbsent()
		{
			return $this->_is_absent;
		}
		
	}
