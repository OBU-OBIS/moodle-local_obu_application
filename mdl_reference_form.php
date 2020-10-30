<?php

// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * OBU Application - Input form for application reference
 *
 * @package    obu_application
 * @category   local
 * @author     Peter Welham
 * @copyright  2020, Oxford Brookes University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

require_once("{$CFG->libdir}/formslib.php");

class mdl_reference_form extends moodleform {

    function definition() {
        $mform =& $this->_form;
		
		$mform->addElement('text', 'id', get_string('reference', 'local_obu_application') . ' HLS/' , 'size="10" maxlength="10"');

        $this->add_action_buttons(true, get_string('continue', 'local_obu_application'));
    }
	
	function validation($data, $files) {
		$errors = parent::validation($data, $files); // Ensure we don't miss errors from any higher-level validation
		
		if ($data['id'] == '') {
			$errors['id'] = get_string('value_required', 'local_obu_application');
		} else {
			$application = read_application($data['id'], false);
			if ($application == null) {
				$errors['id'] = get_string('application_not_found', 'local_obu_application');
			}
		}
		
		return $errors;
	}
}