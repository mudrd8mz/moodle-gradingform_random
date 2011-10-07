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
 * Defines moodleform to be used when defining the grading form
 *
 * Generally, plugins can decide to either use moodleforms or implement own
 * UI without moodleforms.
 *
 * @package    gradingform
 * @subpackage random
 * @copyright  2011 David Mudrak <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/lib/formslib.php');

/**
 * Defines the basic UI to configure this gradingform
 */
class gradingform_rubric_edit_form extends moodleform {

    /**
     * Defines UI elements
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('header', 'general', get_string('pluginname', 'gradingform_random'));
        $mform->addElement('select', 'mean', 'Mean value', array(0 => '0%', 50 => '50%', 100 => '100%'));

        $mform->addElement('hidden', 'areaid');
        $mform->setType('areaid', PARAM_INT);

        $mform->addGroup(array(
             $mform->createElement('submit', 'submit', 'Save'),
             $mform->createElement('cancel', 'cancel', 'Cancel')),
            'grpcontrols', '', ' ', false);
        $mform->closeHeaderBefore('grpcontrols');
    }
}
