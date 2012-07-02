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
 * Enrolment Key Generator block en_uk language file
 *
 * @package    block_ekg
 * @copyright  2011 onwards Paul Vaughan, paulvaughan@southdevon.ac.uk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$string['pluginname'] = 'Enrolment Key Generator';
$string['pluginshortname'] = 'EKG';
$string['type_of_key'] = 'Type of key to be generated:';
$string['three'] = 'Three letter words (e.g. NOT-PEA-CAN)';
$string['four'] = 'Four letter words (e.g. LAYS-LOWE-WOOL)';
$string['five'] = 'Five letter words (e.g. SYNCH-PINGO-BUMPS)';
$string['rand_alpha'] = 'Alphabet characters only (e.g. SRB-PVM-RSU)';
$string['rand'] = 'Alphanumeric characters (e.g. RW9-P4Z-73M)';
$string['rand_numeric'] = 'Numbers only (e.g. 221-947-374)';
$string['ln'] = 'Letter-Number (e.g. A1-B2-C3)';
$string['lnln'] = 'Letter-Number-Letter-Number (e.g. A1B2-C3D4-E5F6)';
$string['lnlnln'] = 'Letter-Number-Letter-Number-Letter-Number (e.g. A1B2C3-D4E5F6)';
$string['llnn'] = 'Letter-Letter-Number-Number (e.g. AB12-CD34-EF56)';
$string['lllnnn'] = 'Letter-Letter-Letter-Number-Number-Number (e.g. ABC123-DEF456)';
$string['sha1'] = 'Random SHA-1 hash (e.g. DB3D6103BA081B5)';
$string['custom'] = 'Custom word list (place <em>\'.txt\'</em> files in \'wordlists/\' folder)';
$string['custom_file'] = 'Choose a custom word list:';
$string['hybrid'] = 'Hybrid of multiple key types (see below)';
$string['number_of_blocks'] = 'Number of blocks of characters, or words:';
$string['characters_per_block'] = 'Number of characters per block (not used if you are using words):';
$string['blocks_or_words_value'] = 'Suggested value: 2 to 5';
$string['chars_per_block_value'] = 'Suggested value: 3 to 6';

$string['hybrid_options']                       = 'Hybrid structure:';
$string['hybrid_three-four-five']               = 'Three Four Five';
$string['hybrid_five-four-three']               = 'Five Four Three';
$string['hybrid_three-number-five']             = 'Three Number Five';
$string['hybrid_five-number-three']             = 'Five Number Three';
$string['hybrid_three-numbernumber-five']       = 'Three NumberNumber Five';
$string['hybrid_five-numbernumber-three']       = 'Five NumberNumber Three';
$string['hybrid_custom-number']                 = 'Custom Number';
$string['hybrid_custom-numbernumber']           = 'Custom NumberNumber';
$string['hybrid_custom-numbernumbernumber']     = 'Custom NumberNumberNumber';
$string['hybrid_custom-number-custom']          = 'Custom Number Custom';
$string['hybrid_custom-numbernumber-custom']    = 'Custom NumberNumber Custom';
$string['hybrid_custom-numbernumbernumber-custom']  = 'Custom NumberNumberNumber Custom';
$string['separator']                            = 'Separator:';

$string['separator_dash'] = 'Dash/Minus (-)';
$string['separator_underscore'] = 'Underscore (_)';
$string['separator_equals'] = 'Equals (=)';
$string['separator_plus'] = 'Plus (+)';
$string['separator_pipe'] = 'Pipe (|)';
$string['separator_fslash'] = 'Forward Slash (/)';
$string['separator_bslash'] = 'Back Slash (\)';
$string['separator_colon'] = 'Colon (:)';
$string['separator_fullstop'] = 'Full Stop (.)';
$string['separator_comma'] = 'Comma (,)';
$string['separator_space'] = 'Space ( )';
$string['separator_nothing'] = 'Nothing';

$string['number_of_keys'] = 'Number of keys to be generated with the above specification:';
$string['number_of_keys_note'] = 'You may only need one but create as many as you like.';
$string['general_wordlist'] = '<strong>Note:</strong> Word lists are internal but contain almost every three, four and five letter word in the English language, British dialect.';
$string['general_case'] = '<strong>Note:</strong> Using Title/Proper Case with random letters/numbers may produce odd results.';
$string['footer-s'] = 'Refresh enrolment key?';
$string['footer-p'] = 'Refresh enrolment keys?';

$string['text_transform'] = 'Modify the case of the text?';
$string['none'] = 'No change (use for random letters of both cases)';
$string['upper'] = 'CHANGE TO UPPERCASE';
$string['lower'] = 'change to lowercase';
$string['proper'] = 'Change To Title Case';

$string['prefix_desc'] = 'Prefix (will appear exactly as typed without any case changes or separators):';
$string['suffix_desc'] = 'Suffix:';
$string['prefix'] = 'Prefix';
$string['suffix'] = 'Suffix';

$string['pre-result']       = 'Chosen from ';
$string['post-result']      = ' words.';
$string['footer_wordlist']  = ' word list used.';

$string['footer_options']       = 'Footer options:';
$string['footer_options_desc']  = 'Choose how you want the footer of the block to appear, if at all.';
$string['footer_words']         = 'Use \'Chosen from n words\' (when applicable)';
$string['footer_refresh']       = 'Use a \'Refresh this page\' link';
$string['footer_both']          = 'Use both \'Chosen from\' and \'Refresh\' options';
$string['footer_none']          = 'No footer';
$string['footer_error']         = 'Error building the footer, sorry.';

$string['footer_wordlist_options']      = 'Custom word list options:';
$string['footer_wordlist_options_desc'] = 'Regardless of the above setting, also choose if you want the name of the custom word list to appear (when applicable).';
$string['footer_wordlist_show']         = 'Show the word list\'s name';
$string['footer_wordlist_hide']         = 'Don\'t show the word list\'s name';
