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
 * The classess required by the "Random grade" plugin are defined here
 *
 * @package    gradingform
 * @subpackage random
 * @copyright  2011 David Mudrak <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/grade/grading/form/lib.php'); // parent class

/**
 * The controller class encapsulates the logic of the plugin
 */
class gradingform_random_controller extends gradingform_controller {

    /**
     * @see parent::make_grading_widget()
     */
    public function make_grading_widget($raterid, $itemid, $bulk = false) {

        if ($this->pagefinalized) {
            throw new coding_exception('You are attempting to make a new grading widget but the target grading page has been already finalized.');
        }

        $widget = new gradingform_random_widget("I'm feeling lucky");

        if (!$bulk) {
            $this->finalize_page();
        }

        return $widget;
    }

    /**
     * Makes sure that required YUI module is loaded at the page
     *
     * @see parent::finalize_page()
     */
    public function finalize_page() {
        $this->page->requires->yui_module('moodle-gradingform_random-grading', 'M.gradingform_random.init_grading');
        parent::finalize_page();
    }

    /**
     * @see parent:extend_settings_navigation()
     */
    public function extend_settings_navigation(settings_navigation $settingsnav, navigation_node $node=null) {
        $node->add(get_string('defineform', 'gradingform_random'),
            new moodle_url('/grade/grading/form/random/edit.php', array('area' => $this->areaid)), settings_navigation::TYPE_CUSTOM,
                null, null, new pix_icon('icon', '', 'gradingform_random'));
    }

    /**
     * @see parent::get_method_name()
     */
    protected function get_method_name() {
        return 'random';
    }
}


/**
 * Represents a renderable grading widget
 *
 * The instance of this class should provide all information needed to render the grading
 * widget.
 */
class gradingform_random_widget extends gradingform_widget {

    /** @var string unique identifier */
    public $id;

    /** @var string the text on the button */
    public $buttonlabel;

    /**
     * @param string $buttonlabel the text on the button
     */
    public function __construct($buttonlabel) {
        $this->id = uniqid('gradingform_random_widgetid_');
        $this->buttonlabel = $buttonlabel;
    }
}
