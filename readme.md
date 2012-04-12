# Enrolment Key Generator for Moodle 2.x

A block which generates one or more random strings of user-definable keys from various sources.

## Introduction

Back along I needed a way of quickly generating short, random strings of data to be used as enrolment passwords. There was nothing available for Moodle and I didn't want to have to use an external website or desktop app. This block was the result.

It is probably a good idea to fully read through this readme before embarking on any installation or bug reporting.

## Licence

Enrolment Key Generator block for Moodle 2.x, copyright (C) 2009-2012  Paul Vaughan

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see <http://www.gnu.org/licenses/>.

## Purpose

Initially, the purpose of this block was 'find a reason to create a Moodle block, and in doing so, learn how to write code for Moodle'. This was for Moodle 1.9, about four or so years back.  I've since upgraded it to Moodle 2.x as I was contacted and asked to do so.

Keys are re/generated when the page loads. Each instance of the block is unique (you can have many per page with different configurations) and generated keys are not stored anywhere. Currently all users can see the block, but this can be changed within Moodle if desired.

More information is available at the [project's GitHub page](https://github.com/vaughany/moodle-block_enrolment_key_generator).

> **Warning:** In this block I have used word lists freely available on the internet which contain **every** three, four and five-letter (British) English word, and as such, may contain words that you may find offensive. I strongly suggest that you load the file `ekg/block_ekg.php` as well as the files in the `ekg/wordlists` folder into your favourite text editor and search for and remove any words you, or your users, may find offensive. (Or, leave the files alone and run the risk of your enrolment key sounding like [George Carlin's Seven Words](http://en.wikipedia.org/wiki/Seven_dirty_words)...!)

## Installation

Installation is a matter of copying files to the correct locations within your Moodle installation, but it is always wise to test new plugins in a sandbox environment first, and have the ability to roll back changes.

Download the archive and extract the files, or [clone the repository from GitHub](https://github.com/vaughany/moodle-block_enrolment_key_generator/). You should see the following files and structure:

    ekg/
    |-- block_ekg.php
    |-- edit_form.php
    |-- lang
    |   `-- en
    |       `-- block_ekg.php
    |-- lib.php
    |-- readme.md
    |-- readme.md.bak
    |-- settings.php
    |-- styles.css
    |-- version.php
    `-- wordlists
        |-- adjectives_big.txt
        |-- adjectives_common.txt
        |-- adverbs.txt
        |-- cities.txt
        |-- colours.txt
        |-- countries.txt
        |-- elements.txt
        |-- forenames.txt
        |-- nouns.txt
        |-- phobias.txt
        |-- prepositions.txt
        |-- pronouns.txt
        |-- unusual.txt
        `-- verbs.txt

Copy the 'ekg' folder into your Moodle installation's blocks folder.

Log in to your Moodle as Admin and click on Notifications on the Admin menu.

The block should successfully install. If you receive any error messages, please [raise an issue on GitHub](https://github.com/vaughany/moodle-block_enrolment_key_generator/issues).

## Global Configuration

Global config affects each block throughout the whole Moodle installation. There is only one option and it's only there for aesthetic value.

Click `Site Administration -> Plugins -> Blocks -> Enrolment Key Generator` to get to the global config page.

You have two options for what appears on the footer of the block. Yes, I know it's not very exciting but that's not the point.

Menu one contains:

* `Use 'Chosen from n words (when applicable)'`: This will display the above text, replacing 'n' with the number of words it was possible to choose from. If words are not in use (you're creating keys from randomly chosen letters, for example), this will display nothing.
* `Use a 'Refresh this page' link`: Displays a link which, when clicked, causes the page to reload. This is not an AJAX refresh: the __whole page__ will reload, so make sure you've saved all your work. AJAX refresh is on the to-do list.
* `Use both 'Chosen from' and 'Refresh' options`: Uses both of the above options.
* `No footer`: Shows no footer at all, making the block a little shorter.

Menu two relates to the custom word list you may or may not be using, and contains:

* `Show the word list\'s name`: If you use a custom word list, the name will be shown.
* `Don\'t show the word list\'s name`: The name of the custom word list will not be shown.

Click save changes when you are done.

## Instance Configuration

### General key types

The block has a number of options for generating keys, and I'd encourage you to simply experiment and see what happens.

To configure the block, first add it to a course. (You can add multiple blocks, but just add and configure one for now.)

> **Note:** At this time, the block is visible to ALL logged in users (including those logged in as 'guest').

When added, it will need an initial configuration, so click on the 'edit' icon (hand-and-pen) and then immediately click 'save changes'. This is enough to get the block working.

You should see something like this:

    ILL-CAG-REC
    ARE-LEW-SUN
    FAG-FOR-FIB
    CEL-REC-ENE
    WUS-GAT-TUT

The block has generated five keys of three 'blocks' (in this case the blocks are words, and the words are three-letter words, but they could be other things) and used a hyphen/dash/minus as a separator, and appears to have forced the words into uppercase.

> **Note:** Clicking the _Refresh enrolment keys?_ link will reload the whole page. I've yet to implement any kind of AJAX refreshing for this block.

Changing the _type of key_ configuration to `four letter words` yields:

    BADE-MOOP-PIPS

...and changing the _number of blocks of characters or words_ setting to `two` yields:

    SUNS-YULE

There's also some five-letter words (in three blocks):

    PIPED-BIPOD-WELLS

This would probably do as a source of random data, but I wanted to take it a little further. Changing the _type_ to `alphanumeric characters` yields:

    spLT-vfSW-pJXv

We can tell from this that the case of letters is not set to _uppercase_ (as I assumed earlier) but is _no change_, so it will use both capitals and lower-case letters. Changing the _case_ setting to `UPPERCASE` yields:

    B6EE-76YK-YVQC

We can get something approximating a Windows licence key by changing _number of blocks of characters or words_ setting AND the _number of characters per block_ setting to `five`:

    1PH7Q-XWJHC-8LH61-PSWG2-TTFNW

We can use numbers as our random source and change the _separator_ to something else:

    2284_9370_7338

...or use just letters:

    KFUR_KWIF_OFMT

Some options use strict formatting of letters and numbers to ensure a consistent key:

    Letter-number: L5-A4-N8
    Letter-number-letter-number: L0R2-K0R5-O5J7
    Letter-number-letter-number-letter-number: H4A1U9-J4U8Q0-J7N7M0
    Letter-letter-number-number: JO40-XP88-DC79
    Letter-letter-letter-number-number-number: FKG397-NEB349-KTO440

The internal gubbins to force this format is in place and simple enough to edit, so if you needed a format such as `llnll` it's easy to create ([raise an issue!](https://github.com/vaughany/moodle-courseawards/issues)).

We can use parts of a randomly generated [_SHA-1 hash_](http://en.wikipedia.org/wiki/SHA-1) (maximum of 40 characters), change the separator again and force lowercase too:

    19a96/873dc/95e86

There is the option to prefix and/or suffix the generated key with a string of the user's choosing, e.g. if I needed keys which started 'mon' for Monday, into the suffix box I would type `mon` and any character I like to separate it from the body of the key, giving me `mon/`:

    mon/Reh-Obe

Same applies to the suffix:

    Fax-Coo/mon

...or even:

    mon/Kab-Vac/mon

> **Note:** The separator you choose (from the drop-down menu) and any case transformation does not modify the prefix or suffix: what you type in is exactly what will be prepended or appended to the generated key.

### Keytypes using custom word lists

The block is supplied with a few custom word lists: plain text files containing words, one per line, preferably with Unix-format line endings (LF). You are encouraged to make your own if desired (it's easy, see below).

> **Note:** I read somewhere [[citation needed](http://imgs.xkcd.com/comics/wikipedian_protester.png)] that PHP has a particularly bad time with Apple Mac line endings (CR), so if you are going to create your own word lists or edit the supplied ones, best to save the file with Unix-format line endings (LF). [_Notepad 2_](http://www.flos-freeware.ch/notepad2.html) and [_Notepad++_](http://notepad-plus-plus.org/) for Windows are both good at this.

Word lists are found in the block's folder, in a sub-folder called `wordlists`. `elements.txt` contains chemical elements in Title Case, and will create keys such as:

    Krypton-Bismuth

Real words like these may benefit from changing the separator to _none_, giving the impression of CamelCase:

    IridiumProtactinium
    GreenBlueGreen
    GapCryAft

* `adjectives_big.txt` contains many adjectives: `aback, abaft, abandoned`.
* `adjectives_common.txt` contains common adjectives: `abundant, adorable, agreeable`.
* `adverbs.txt` contains many adverbs: `abnormally, absentmindedly, accidentally`.
* `cities.txt` contains names of world cities: `Abu Dhabi, Abuja, Accra`.
* `colours.txt` contains basic colour names: `aqua, black, blue`.
* `countries.txt` contains names of world countries: `Abkhazia, Afghanistan, Albania`.
* `elements.txt` contains most chemical elements: `Actinium, Aluminium, Americium`.
* `forenames.txt` contains a small selection of male and female names: `Aaliyah, Aaron, Abbie`.
* `nouns.txt` contains many nouns: `account, achiever, acoustics`.
* `prepositions.txt` contains many prepositions: `aboard, about, above`.
* `phobias.txt` contains many phobias: `ablutophobia, acarophobia, acerophobia`.
* `pronouns.txt`contains many pronouns: `all, another, any`.
* `unusual.txt` contains a selection of unusual words: `abacinate, abderian, abecedarian`. (Link in the Acknowledgements, below, for explanations!)
* `verbs.txt` contains many prepositions: `abide, accelerate, accept`.

Some of the above example files are arranged alphabetically, others are not. As a line is picked at random, it doesn't really matter how the file is structured, as long as there is just one item per line with appropriate line endings.

You can create word lists from absolutely anything you like: if it can be added one-item-per-line to a plain text file, this plugin can use it.

### Hybrid key types

Hybrid keys are keys made from a mix of other keys, the exact format of which is chosen further down the configuration screen:

* `Three Four Five` - a three-letter word, then a four-letter word, then a five-letter word.
* `Five Four Three` - the reverse of the above.
* `Three Number Five` - a three-letter word, then a single digit, then a five-letter word.
* `Five Number Three` - the reverse of the above.
* `Three NumberNumber Five` - a three-letter word, then two digits, then a five-letter word.
* `Five NumberNumber Three` - the reverse of the above.
* `Custom Number Custom` - a word chosen from your selected word list, then a single digit, then a word chosen from your selected word list.
* `Custom NumberNumber Custom` - a word chosen from your selected word list, then two digits, then a word chosen from your selected word list.

## Creating a custom word list

This part of the block is not particularly sophisticated, reading a whole file straight in and blindly using it, so for now, creating a word list should meet these criteria:

* One word per line
* Plain text only, no markup or code of any kind
* Avoid unnecessary punctuation
* No empty lines
* Unix-format line endings (LF)
* No leading or trailing spaces
* Use standard ASCII characters, no Unicode
* File names:
 * all lower case
 * no spaces
 * MUST end in .txt

## Known Issues

The block is visible to ALL logged in users (including those logged in as 'guest'). It's not a problem as such, as keys generated are very, very unlikely to be generated ever again, however I thought I'd add it in here in case you missed it above.

Should you find a bug, have an issue, feature request or new language pack, please [log an issue in the tracker](https://github.com/vaughany/moodle-courseawards/issues) or fork the repo, fix the problem and submit a pull request.

Custom file reading is very basic, lacking checks such as empty lines, white space.

## To Do

In no particular order:

* AJAX refresh, instead of reloading the whole page.
* Option to trim white space from any part of a string (except the delimiter which could be a space) and possibly other characters too, especially for custom text files.
* Add option to ensure same word/sequence of characters is not used more than once per key or set of keys.
* Blacklist of inappropriate words.
* For custom text files, have a setting for words of less then, equal to, or greater than a specified length.

## Acknowledgements

* 3 and 4 letter word lists courtesy of [Australian Scrabble&reg; Players Association (ASPA)](http://www.scrabble.org.au)
* 5-letter word list courtesy of [More Words](http://www.morewords.com)
* List of chemical elements (used in default custom.txt) taken from [Wikipedia](http://en.wikipedia.org/wiki/List_of_elements_by_name)
* English language word lists taken from [Moms Who Think](http://www.momswhothink.com)
* Unusual words taken from [here](http://users.tinyonline.co.uk/gswithenbank/unuwords.htm) (see the link for explanations of the words!)
* List of phobias taken from [phobialist.com](http://phobialist.com/) (see link for explanations again)
* Other lists taken from websites all over the Internet. Sorry for forgetting.

## History

**April 11th, 2012**

* Version 2.0.1 for Moodle 2.x
* Build 2012041100

A new feature is the ability to pick a custom word list from a drop-down menu. For each new block it defaults to the `elements` word list but any file in the block's `ekg/wordlists` folder ending in `.txt` can be chosen. You can create and add your own, too.

> **Note:** Any file in the /wordlists folder is assumed to be safe and correct, as per the guidelines (see "Creating a custom word list", above). Files not of the correct specification may fail to load or break your Moodle installation or breach your warp core. Yes, I know that's not great, it's on my to-do list.

Wrote code for a couple of new formats for randomly generated letters and numbers, e.g. ln, lnln, lnlnln and llnn, lllnnn, etc, as well as a couple of new hybrid formats too.

This block can now be placed anywhere a block can be placed. Previously it was restricted to courses, but that's not necessary, and it can now be laced anywhere.

Added extra wordlists and edited and corrected the readme.

**February 22nd, 2012**

* Version 2.0 for Moodle 2.x
* Build 2012022200
