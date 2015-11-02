<?php
// This file is part of Moodle - http://moodle.org/
//
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
 * OBU Application - Forgot password routine
 *
 * @package    obu_application
 * @category   local
 * @author     Peter Welham (derived from '/login/forgot_password.php')
 * @copyright  2015, Oxford Brookes University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

require('../../config.php');
require_once('./locallib.php');
require_once('./password_lib.php');
require_once('./forgot_password_form.php');
require_once('./set_password_form.php');

$token = optional_param('token', false, PARAM_ALPHANUM);

//HTTPS is required in this page when $CFG->loginhttps enabled
$PAGE->https_required();

$PAGE->set_url('/local/obu_application/forgot_password.php');
$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);
$PAGE->set_title($CFG->pageheading . ': ' . get_string('passwordforgotten'));

// If you're logged in then you shouldn't be here!
if (isloggedin() and !isguestuser()) {
    redirect($CFG->wwwroot . '/local/obu_application/index.php', get_string('loginalready'), 5);
}

if (empty($token)) {
    // This is a new password reset request.
    // Process the request; identify the user & send confirmation email.
    password_reset_request();
} else {
    // User clicked on confirmation link in email message
    // validate the token & set new password
    password_set($token);
}
