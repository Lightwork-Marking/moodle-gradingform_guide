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
$string['addcomment'] = 'Add Frequently used comment';
$string['backtoediting'] = 'Back to editing';
$string['clicktocopy'] = 'Click to copy this text into the criteria feedback';
$string['confirmdeletecriterion'] = 'Are you sure you want to delete this item?';
$string['confirmdeletelevel'] = 'Are you sure you want to delete this level?';
$string['err_nocomment'] = 'Comment can not be empty';
$string['err_nodescription'] = 'Student description can not be empty';
$string['err_nodescriptionmarkers'] = 'Marker description can not be empty';
$string['err_noshortname'] = 'Criterion name can not be empty';
$string['err_nomaxscore'] = 'Criterion max score can not be empty';
$string['err_maxscorenotnumeric'] = 'Criterion max score must be numeric';
$string['err_scoreinvalid'] = 'The score given to {$a->criterianame} is higher than the max score: {$a->maxscore}';
$string['alwaysshowdefinition'] = 'Show guide definition to students';
$string['clicktoedit'] = 'Click to edit';
$string['clicktoeditname'] = 'Click to edit criterion name';
$string['comments'] = 'Frequently used comments';
$string['commentsdelete'] = 'Delete comment';
$string['commentsempty'] = 'Click to edit comment';
$string['commentsmovedown'] = 'Move down';
$string['commentsmoveup'] = 'Move up';
$string['criterion'] = 'Criterion';
$string['criteriondelete'] = 'Delete criterion';
$string['criterionempty'] = 'Click to edit criterion';
$string['criterionmovedown'] = 'Move down';
$string['criterionmoveup'] = 'Move up';
$string['showmarkspercriterionstudents'] = 'Show marks per criterion to students';
$string['pluginname'] = 'Marking guide';
$string['definemarkingguide'] = 'Define marking guide';
$string['gradingof'] = '{$a} grading';
$string['description'] = 'Description';
$string['descriptionstudents'] = 'Description for Students';
$string['descriptionmarkers'] = 'Description for Markers';
$string['name'] = 'Name';
$string['guideoptions'] = 'Marking guide options';
$string['guidestatus'] = 'Current marking guide status';
$string['guidemappingexplained'] = 'WARNING: Your marking guide has a maximum grade of <b>{$a->maxscore} points</b> but the maximum grade set in your assignment is {$a->modulegrade}  The maximum score set in your marking guide will be scaled up to the maximum grade in the module.<br />
    Intermediate scores will be converted respectively and rounded to the nearest available grade.';
$string['guidenotcompleted'] = 'Please provide a valid grade for each criterion';
$string['hidemarkerdesc'] = 'Hide marker criterion descriptions';
$string['hidestudentdesc'] = 'Hide student criterion descriptions';
$string['maxscore'] = 'Maximum mark';
$string['needregrademessage'] = 'The marking guide definition was changed after this student had been graded. The student can not see this marking guide until you check the marking guide and update the grade.';
$string['regrademessage1'] = 'You are about to save changes to a marking guide that has already been used for grading. Please indicate if existing grades need to be reviewed. If you set this then the marking guide will be hidden from students until their item is regraded.';
$string['regrademessage5'] = 'You are about to save significant changes to a marking guide that has already been used for grading. The gradebook value will be unchanged, but the marking guide will be hidden from students until their item is regraded.';
$string['regradeoption0'] = 'Do not mark for regrade';
$string['regradeoption1'] = 'Mark for regrade';
$string['restoredfromdraft'] = 'NOTE: The last attempt to grade this person was not saved properly so draft grades have been restored. If you want to cancel these changes use the \'Cancel\' button below.';
$string['save'] = 'Save';
$string['saveguide'] = 'Save marking guide and make it ready';
$string['showstudentdesc'] = 'Show student criterion descriptions';
$string['showmarkerdesc'] = 'Show marker criterion descriptions';
$string['saveguidedraft'] = 'Save as draft';
$string['showdescriptionstudent'] = 'Display description to those being graded';
$string['score'] = 'score';
