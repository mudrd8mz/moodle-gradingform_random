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
 * @package    gradingform
 * @subpackage random
 * @copyright  2011 David Mudrak <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Grading method plugin renderer
 */
class gradingform_random_renderer extends gradingform_renderer {

    /**
     * Renders grading widget
     *
     * @param gradingform_random_grading_widget $widget
     * @return string HTML
     */
    protected function render_gradingform_random_grading_widget(gradingform_random_grading_widget $widget) {

        $button  = html_writer::tag('button', 'Loading ...', array('type' => 'button', 'value' => $widget->buttonlabel));
        $hidden  = html_writer::empty_tag('input', array('type' => 'hidden', 'name' => $widget->id.'_instanceid', 'value' => $widget->instance->id));
        $span    = html_writer::tag('span', '');

        return $this->output->container($button.$hidden.$span, 'gradingform_random-widget-wrapper', $widget->id);
    }

    /**
     * Renders editor widget
     *
     * @param gradingform_random_editor_widget $widget
     * @return string HTML
     */
    protected function render_gradingform_random_editor_widget(gradingform_random_editor_widget $widget) {
        return var_export($widget, true);
    }
}
