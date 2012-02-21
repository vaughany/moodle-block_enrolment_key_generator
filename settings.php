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
 * Enrolment Key Generator global configuration
 *
 * @package    block
 * @subpackage ekg
 * @copyright  2011 onwards Paul Vaughan, paulvaughan@southdevon.ac.uk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_configselect(
        'ekg/footer',
        get_string('footer_options', 'block_ekg'),
        get_string('footer_options_desc', 'block_ekg'),
        'words',
        array (
            'words'     => get_string('footer_words', 'block_ekg'),
            'refresh'   => get_string('footer_refresh', 'block_ekg'),
            'both'      => get_string('footer_both', 'block_ekg'),
            'none'      => get_string('footer_none', 'block_ekg'),
        ))
    );

}