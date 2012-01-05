Enrolment Key Generator for Moodle 1.9.x - Copyright (c) 2009-2012 Paul Vaughan <paulieboo [at] gmail [dot] com>

This is a block which generates one or more random enrolment keys from various sources. Keys are generated when the page loads or is reloaded. I will not be implimenting an AJAX refresh for this block.

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details: http://www.gnu.org/copyleft/gpl.html

More information is available at the project's github page: https://github.com/vaughany/moodle_enrolment_key_generator

Note: If you're downloading this from github you'll want to put it all in a directory called blocks/ekg

Version 1.1.1, updated 2012-01-05.

Installation
~~~~~~~~~~~~

1. Move the *contents* of the 'ekg' folder (the one containing 'blocks' and 'lang' folders) to your Moodle's root folder. This will put the blocks/ekg/ and lang/en_utf8/ folders in the correct places.
2. As site administrator, go to your Moodle's front page and click on Notifications. This will install the block.
3. Go to a course, turn on editing and add the Enrolment Key Generator Block. If you see [[blocktitle]], ensure there is a file called block_ekg.php in lang/en_utf8/
4. It will start generating keys immediately.
5. Edit the configuration to better suit your needs: with editing on, click the 'edit' icon. Each with different settings.
6. Add your own custom.txt file to the ekg folder if you wish, replacing or renaming the one(s) already there.

Note: At this time, the block is visible to ALL logged in users (including those logged in as 'guest'.

Bugs
~~~~

No known bugs at this point, however the code might not be up to much! ;)

Acknowledgements
~~~~~~~~~~~~~~~~

3 and 4 letter Wordlists courtesy of Australian Scrabble® Players Association (ASPA) (www.scrabble.org.au)
5-letter wordlist courtesy of More Words (www.morewords.com)
List of chemical elements (used in default custom.txt) taken from Wikipedia (http://en.wikipedia.org/wiki/List_of_elements_by_name)
Other lists taken from websites all over the Internet. Sorry for forgetting.

Version History
~~~~~~~~~~~~~~~

2012/01/05: Dusting off this old code and tidying it up a little, in preparation to go on github and be refactored for 2.2.
2009/09/01: Have sorted out the footer issue (the issue being what to have there) with a global config option.
2009/08/16: Have fixed all errors I can find at this point, minor edits to language pack and some code logic.
            Note to all: Use the 'developer level warnings' setting in Admin>Server>Debugging!! Very useful!
2009/08/02: Discovered some new bugs possibly relating to newer versions of Moodle. Tinkering and fixing.
            Added if(function_exists()) { to custom-functions as they were being declared multiple times (error).
2008/08/01: Got a new 5-letter word list, added that in. WILL NOT BE CHECKED FOR PROFANITY. That's up to you.
            Added new 'hybrid' key code. It's a bit clunky but it seems to work well.
2008/07/31: Refactored the code to use functions and generally be more efficient, pending further development.
            Added a pure random number option for each block.
2008/07/28: As default a dash is used as a separator but after that the separator field can be empty (no separator).
            Zeros and non-numbers in config screen input fields now replaced with default values.
2008/07/25: Ability to add prefix and suffix options to keys
            Implemented the ability to use a custom 'wordlist' file.
            Add ability to UPPERCASE, lowercase or Title Case words/blocks (or leave them alone).
2008/07/19: Removed obvious profanity/racial slurs from wordlists. Please let me know if you find any more.

Possible To-Do's
~~~~~~~~~~~~~~~~

Note: all to-do's will be pushed into 2.2. I'll bug-fix this for 1.9 as required but no more development will take place.

Text input to specify name (possibly location but will assume ekg block folder) of custom text files.
Option to trim whitespace from any part of a string (except the delimiter which could be a space).
Implement a drop-down menu for separators.
Random number for blocks AND for seperators.
Add in a key number, like an ordered list (for number of keys >1?) May require some custom CSS.
Add ability to make sure same word is not used more than once per key or set of keys? Not truly random though (Enigma much?).

Comments and Ideas
~~~~~~~~~~~~~~~~~~

Go to the block homepage (above) and leave a comment there. Or, fork the repo, develop it and submit a pull request. I try to be active in the Moodle forums but comments can easily slip by unnoticed, as well as on the block's page in the  Plugins database.
