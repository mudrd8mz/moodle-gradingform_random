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
 * The user can define the grading form at this page
 *
 * For this dummy plugin, there is actually nothing to define. But the page
 * illustrates the API usage.
 *
 * @package    gradingform
 * @subpackage random
 * @copyright  2011 David Mudrak <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__).'/edit_form.php');
require_once($CFG->dirroot.'/grade/grading/lib.php');

$areaid = required_param('areaid', PARAM_INT);

$gradingman = get_grading_manager($areaid);

list($context, $course, $cm) = get_context_info_array($gradingman->get_context()->id);

require_login($course, true, $cm);
require_capability('moodle/grade:managegradingforms', $context);

$controller = $gradingman->get_controller('random');

$ui = new gradingform_rubric_edit_form();

if ($ui->is_cancelled()) {
    // todo we will a way how to redirect to a more reasonable place
    redirect(new moodle_url('/course/view.php', array('id' => $course->id)));

} else if ($data = $ui->get_data()) {
    $definition = new stdClass();
    $definition->name = get_string('pluginname', 'gradingform_random');
    $definition->status = gradingform_controller::DEFINITION_STATUS_PRIVATE;
    $definition->options = json_encode(array('mean' => $data->mean));

    $controller->update_definition($definition);

    redirect(new moodle_url('/course/view.php', array('id' => $course->id)));
}

$PAGE->set_url(new moodle_url('/grade/grading/form/random/edit.php'), array('areaid' => $areaid));
$PAGE->set_heading(get_string('pluginname', 'gradingform_random'));

$ui->set_data(array(
    'areaid' => $areaid,
    'mean'   => 50));

echo $OUTPUT->header();
echo $OUTPUT->box('Random grade is a dummy plugin that demonstrates usage of the grading forms API. It simply generates a random grade for the given gradable item. You can configure the mean value for the random value generator.');
$ui->display();
echo $OUTPUT->footer();
