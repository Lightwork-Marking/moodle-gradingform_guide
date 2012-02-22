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
 * @subpackage guide
 * @copyright  2012 Dan Marsden <dan@danmarsden.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['addcriterion'] = 'Add criterion';
$string['err_nodescription'] = 'Student description can not be empty';
$string['err_nodescriptionmarkers'] = 'Marker description can not be empty';
$string['err_noshortname'] = 'Criterion name can not be empty';
$string['err_nomaxscore'] = 'Criterion max score can not be empty';
$string['alwaysshowdefinition'] = 'Show rubric definition to students';
$string['criteriondelete'] = 'Delete criterion';
$string['criterionempty'] = 'Click to edit criterion';
$string['criterionmovedown'] = 'Move down';
$string['criterionmoveup'] = 'Move up';
$string['showmarkspercriterionstudents'] = 'Show marks per criterion to students';
$string['pluginname'] = 'Marking guide';
$string['definemarkingguide'] = 'Define marking guide';
$string['gradingof'] = '{$a} grading';
$string['definerubric'] = 'Define rubric';
$string['description'] = 'Description';
$string['name'] = 'Name';
$string['guideoptions'] = 'Marking guide options';
$string['guidestatus'] = 'Current marking guide status';
$string['guidemapping'] = 'Score to grade mapping rules';
$string['guidemappingexplained'] = 'The maximum score <b>{$a->maxscore} points</b> will be converted to the maximum grade.<br />
    Intermediate scores will be converted respectively and rounded to the nearest available grade.<br />
    If a scale is used instead of a grade, the score will be converted to the scale elements as if they were consecutive integers.';
$string['save'] = 'Save';
$string['saveguide'] = 'Save marking guide and make it ready';
$string['saveguidedraft'] = 'Save as draft';