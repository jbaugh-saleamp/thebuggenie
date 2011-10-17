<?php

	use b2db\Core,
		b2db\Criteria,
		b2db\Criterion,
		b2db\Resultset;

	/**
	 * User dashboard views table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 3.1
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package thebuggenie
	 * @subpackage tables
	 */

	/**
	 * User dashboard views table
	 *
	 * @package thebuggenie
	 * @subpackage tables
	 */
	class TBGDashboardViewsTable extends ScopedTable
	{

		const B2DB_TABLE_VERSION = 1;
		const B2DBNAME = 'dashboard_views';
		const ID = 'dashboard_views.id';
		const TYPE = 'dashboard_views.type';
		const VIEW = 'dashboard_views.view';
		const TID = 'dashboard_views.tid';
		const PID = 'dashboard_views.pid';
		const TARGET_TYPE = 'dashboard_views.target_type';
		const SCOPE = 'dashboard_views.scope';

		/**
		 * Return an instance of this table
		 *
		 * @return TBGDashboardViewsTable
		 */
		public static function getTable()
		{
			return Core::getTable('TBGDashboardViewsTable');
		}

		protected function _setup()
		{
			
			parent::_addInteger(self::TYPE);
			parent::_addInteger(self::VIEW);
			parent::_addInteger(self::PID);
			parent::_addInteger(self::TARGET_TYPE);
			parent::_addInteger(self::TID);
			parent::_addForeignKeyColumn(self::SCOPE, $this->_connection->getTable('\\thebuggenie\\tables\\Scopes'), \thebuggenie\tables\Scopes::ID);
		}
		
		public function addView($target_id, $target_type, $view)
		{
			if ($view['type'])
			{
				$crit = $this->getCriteria();
				$crit->addInsert(self::TID, $target_id);
				$crit->addInsert(self::TARGET_TYPE, $target_type);
				$crit->addInsert(self::TYPE, $view['type']);
				$crit->addInsert(self::VIEW, $view['id']);
				$crit->addInsert(self::SCOPE, \thebuggenie\core\Context::getScope()->getID());
				$this->doInsert($crit);
			}
		}
		
		public function clearViews($target_id, $target_type)
		{
			$crit = $this->getCriteria();
			$crit->addWhere(self::TID, $target_id);
			$crit->addWhere(self::TARGET_TYPE, $target_type);
			$crit->addWhere(self::SCOPE, \thebuggenie\core\Context::getScope()->getID());
			$this->doDelete($crit);
		}

		public function getViews($target_id, $target_type)
		{
			$crit = $this->getCriteria();
			$crit->addWhere(self::TID, $target_id);
			$crit->addWhere(self::TARGET_TYPE, $target_type);
			$crit->addWhere(self::SCOPE, \thebuggenie\core\Context::getScope()->getID());
			$crit->addOrderBy(self::ID);
			$res = $this->doSelect($crit);
			if ($res instanceof Resultset)
			{
				return $res->getAllRows();
			}
			return array();
		}
		
		public function setDefaultViews($target_id, $target_type)
		{
			switch ($target_type)
			{
				case self::TYPE_USER:
					$this->clearViews($target_id, $target_type);
					$this->addView($target_id, $target_type, array('type' => TBGDashboardView::VIEW_PREDEFINED_SEARCH, 'id' => TBGContext::PREDEFINED_SEARCH_MY_REPORTED_ISSUES));
					$this->addView($target_id, $target_type, array('type' => TBGDashboardView::VIEW_PREDEFINED_SEARCH, 'id' => TBGContext::PREDEFINED_SEARCH_MY_ASSIGNED_OPEN_ISSUES));
					$this->addView($target_id, $target_type, array('type' => TBGDashboardView::VIEW_PREDEFINED_SEARCH, 'id' => TBGContext::PREDEFINED_SEARCH_TEAM_ASSIGNED_OPEN_ISSUES));
					$this->addView($target_id, $target_type, array('type' => TBGDashboardView::VIEW_LOGGED_ACTION, 'id' => 0));
					break;
				case self::TYPE_PROJECT:
					$this->clearViews($target_id, $target_type);
					$this->addView($target_id, $target_type, array('type' => TBGDashboardView::VIEW_PROJECT_INFO, 'id' => 0));
					$this->addView($target_id, $target_type, array('type' => TBGDashboardView::VIEW_PROJECT_TEAM, 'id' => 0));
					$this->addView($target_id, $target_type, array('type' => TBGDashboardView::VIEW_PROJECT_SUBPROJECTS, 'id' => 0));
					$this->addView($target_id, $target_type, array('type' => TBGDashboardView::VIEW_PROJECT_CLIENT, 'id' => 0));
					$this->addView($target_id, $target_type, array('type' => TBGDashboardView::VIEW_PROJECT_LAST15, 'id' => 0));
					$this->addView($target_id, $target_type, array('type' => TBGDashboardView::VIEW_PROJECT_STATISTICS_PRIORITY, 'id' => 0));
					break;
			}

		}
	}