<?php
/**
 * This file is part of Kumva.
 *
 * Kumva is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kumva is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kumva.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright Rowan Seymour 2010
 * 
 * Purpose: Report service class
 */

$reports = array();

/**
 * Registers a function based report
 * @param string name the report name
 * @param string title the report title
 * @param string function the function name
 */
function kumva_registerreport($name, $title, $function) {
	global $reports;
	$reports[] = new Report($name, $title, $function); 	
}

/**
 * Report functions
 */
class ReportService extends Service {
	/**
	 * Gets all the reports
	 * @return array the reports
	 */
	public function getReports() {
		global $reports;
		return $reports;
	}
	
	/**
	 * Gets the named report
	 * @param string the report name
	 * @return Report the report
	 */
	public function getReportByName($name) {
		global $reports;
		foreach ($reports as $report) {
			if ($report->getName() == $name)
				return $report;
		}
		return NULL;
	}
	
	/**
	 * Generates a report result from the given SQL
	 * @param string sql the SQL
	 * @param Paging paging the paging object
	 */
	public function getResultFromSQL($sql, $paging) {
		$start = microtime(TRUE);
		$res = $this->database->query($sql, $paging);
		$fields = $this->database->fields($res);
		$rows = $this->database->rows($res);
		$time = microtime(TRUE) - $start;
		
		return new ReportResults($fields, $rows, $time); 
	}
}

?>
