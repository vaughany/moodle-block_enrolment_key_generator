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
 * Enrolment Key Generator instance config form
 *
 * @package    block
 * @subpackage ekg
 * @copyright  2011 onwards Paul Vaughan, paulvaughan@southdevon.ac.uk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_ekg_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        global $CFG;

        include_once($CFG->dirroot . '/blocks/ekg/lib.php');

        // PHP's range() function cannot specify starting key, so a range of 1-20 is actually [0] => 1...
        // Doing it this way instead. There may be a better way, but this actually *works* so is good enough.
        $range = array();
        for ($j=1; $j<=20; $j++) {
            $range[$j] = $j;
        }

        // Section header title according to language file.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // type of key to be created
        $radioarray = array();
        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('three', 'block_ekg'), 'three');
        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('four', 'block_ekg'), 'four');
        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('five', 'block_ekg'), 'five');
        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('rand', 'block_ekg'), 'rand');
        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('rand_alpha', 'block_ekg'), 'rand_alpha');
        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('rand_numeric', 'block_ekg'), 'rand_numeric');

        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('ln', 'block_ekg'), 'ln');
        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('lnln', 'block_ekg'), 'lnln');
        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('lnlnln', 'block_ekg'), 'lnlnln');
        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('llnn', 'block_ekg'), 'llnn');
        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('lllnnn', 'block_ekg'), 'lllnnn');

        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('sha1', 'block_ekg'), 'sha1');
        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('custom', 'block_ekg'), 'custom');
        $radioarray[] = $mform->createElement('radio', 'config_key_type', '', get_string('hybrid', 'block_ekg'), 'hybrid');

        $mform->addGroup($radioarray, 'config_key_type', get_string('type_of_key', 'block_ekg'), array('<br />'), false);
        $mform->setDefault('config_key_type', 'three');
        $mform->setType('config_key_type', PARAM_ALPHANUMEXT);

        // a word about word lists
        $mform->addElement('static', 'description', null, get_string('general_wordlist', 'block_ekg'));

        // number of blocks of words
        $mform->addElement('select', 'config_number_of_blocks', get_string('number_of_blocks', 'block_ekg'), $range);
        $mform->setDefault('config_number_of_blocks', 3);
        $mform->setType('config_number_of_blocks', PARAM_INT);

        // number of characters per block
        $mform->addElement('select', 'config_chars_per_block', get_string('characters_per_block', 'block_ekg'), $range);
        $mform->setDefault('config_chars_per_block', 4);
        $mform->setType('config_chars_per_block', PARAM_INT);

        // hybrid key structure
        $radioarray=array();
        $radioarray[] = $mform->createElement('radio', 'config_hybrid_structure', '',
            get_string('hybrid_three-four-five', 'block_ekg'), 'three-four-five', null);
        $radioarray[] = $mform->createElement('radio', 'config_hybrid_structure', '',
            get_string('hybrid_five-four-three', 'block_ekg'), 'five-four-three', null);
        $radioarray[] = $mform->createElement('radio', 'config_hybrid_structure', '',
            get_string('hybrid_three-number-five', 'block_ekg'), 'three-number-five', null);
        $radioarray[] = $mform->createElement('radio', 'config_hybrid_structure', '',
            get_string('hybrid_five-number-three', 'block_ekg'), 'five-number-three', null);
        $radioarray[] = $mform->createElement('radio', 'config_hybrid_structure', '',
            get_string('hybrid_three-numbernumber-five', 'block_ekg'), 'three-numbernumber-five', null);
        $radioarray[] = $mform->createElement('radio', 'config_hybrid_structure', '',
            get_string('hybrid_five-numbernumber-three', 'block_ekg'), 'five-numbernumber-three', null);
        $radioarray[] = $mform->createElement('radio', 'config_hybrid_structure', '',
            get_string('hybrid_custom-number', 'block_ekg'), 'custom-number', null);
        $radioarray[] = $mform->createElement('radio', 'config_hybrid_structure', '',
            get_string('hybrid_custom-numbernumber', 'block_ekg'), 'custom-numbernumber', null);
        $radioarray[] = $mform->createElement('radio', 'config_hybrid_structure', '',
            get_string('hybrid_custom-numbernumbernumber', 'block_ekg'), 'custom-numbernumbernumber', null);
        $radioarray[] = $mform->createElement('radio', 'config_hybrid_structure', '',
            get_string('hybrid_custom-number-custom', 'block_ekg'), 'custom-number-custom', null);
        $radioarray[] = $mform->createElement('radio', 'config_hybrid_structure', '',
            get_string('hybrid_custom-numbernumber-custom', 'block_ekg'), 'custom-numbernumber-custom', null);
        $radioarray[] = $mform->createElement('radio', 'config_hybrid_structure', '',
            get_string('hybrid_custom-numbernumbernumber-custom', 'block_ekg'), 'custom-numbernumbernumber-custom', null);

        $mform->addGroup($radioarray, 'config_hybrid_structure', get_string('hybrid_options', 'block_ekg'), array('<br />'), false);
        $mform->setDefault('config_hybrid_structure', 'three-number-five');
        $mform->setType('config_hybrid_structure', PARAM_ALPHANUMEXT);

        // separator
        $separators = array(
            '' =>   get_string('separator_nothing', 'block_ekg'),
            '\\' => get_string('separator_bslash', 'block_ekg'),
            ':' =>  get_string('separator_colon', 'block_ekg'),
            ',' =>  get_string('separator_comma', 'block_ekg'),
            '-' =>  get_string('separator_dash', 'block_ekg'),
            '=' =>  get_string('separator_equals', 'block_ekg'),
            '/' =>  get_string('separator_fslash', 'block_ekg'),
            '.' =>  get_string('separator_fullstop', 'block_ekg'),
            '|' =>  get_string('separator_pipe', 'block_ekg'),
            '+' =>  get_string('separator_plus', 'block_ekg'),
            ' ' =>  get_string('separator_space', 'block_ekg'),
            '_' =>  get_string('separator_underscore', 'block_ekg'),
        );
        $mform->addElement('select', 'config_separator', get_string('separator', 'block_ekg'), $separators);
        $mform->setDefault('config_separator', '-');
        $mform->setType('config_hybrid_structure', PARAM_RAW_TRIMMED);

        // number of keys
        $mform->addElement('select', 'config_number_of_keys', get_string('number_of_keys', 'block_ekg'), $range);
        $mform->setDefault('config_number_of_keys', 5);
        $mform->setType('config_number_of_keys', PARAM_INT);

        // text transform
        $transforms = array(
            'none'      => get_string('none', 'block_ekg'),
            'upper'     => get_string('upper', 'block_ekg'),
            'lower'     => get_string('lower', 'block_ekg'),
            'proper'    => get_string('proper', 'block_ekg'),
        );
        $mform->addElement('select', 'config_transform', get_string('text_transform', 'block_ekg'), $transforms);
        $mform->setDefault('config_transform', 'none');

        // a word about case
        $mform->addElement('static', 'description', null, get_string('general_case', 'block_ekg'));

        // array of attributes for the input boxes
        $attributes = array('size'=>12, 'maxlength'=>10);

        // prefix
        $mform->addElement('text', 'config_prefix', get_string('prefix_desc', 'block_ekg'), $attributes);
        $mform->setDefault('config_prefix', '');
        $mform->setType('config_prefix', PARAM_RAW_TRIMMED);

        // suffix
        $mform->addElement('text', 'config_suffix', get_string('suffix_desc', 'block_ekg'), $attributes);
        $mform->setDefault('config_suffix', '');
        $mform->setType('config_suffix', PARAM_RAW_TRIMMED);

        // trial picking which file to use
        $files_avail = array();
        $dir = $CFG->dirroot.'/blocks/ekg/wordlists';
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if (strpos($file, '.txt', false)) {
                    $files_avail[] = substr($file, 0, strlen($file)-4);
                }
            }
            closedir($dh);
            asort($files_avail);
        }
        foreach ($files_avail as $cfile) {
            $filearray[$cfile] = prettyfilename($cfile);
        }
        $mform->addElement('select', 'config_customfile', get_string('custom_file', 'block_ekg'), $filearray);
        $mform->setDefault('config_customfile', 'elements');
        $mform->setType('config_customfile', PARAM_RAW_TRIMMED);
    }
}