<?php

class block_ekg extends block_base {

    function init() {
        $this->title = get_string('title', 'block_ekg');
        $this->version = 2009090100;
    }

    function applicable_formats() {
        return array('all' => true);
    }

    function has_config() { return true; }
    function instance_allow_multiple() { return true; }

    function specialization() {
        global $CFG;
        $this->title = isset($this->config->title) ? format_string($this->config->title) : format_string(get_string('title', 'block_ekg'));

        /**
         * This adds a default instance configuration to each block.
         * This section now handles rudimentary input errors: 0 and not-integers changed to default values.
         */
        // This next line adds in the default dash only if the key type field is empty (first use) otherwise the separator cannot be nothing! 
        if (empty($this->config->block_ekg_key_type)) { $this->config->block_ekg_separator = '-'; }
        // Set some more defaults
        if (empty($this->config->block_ekg_key_type)) { $this->config->block_ekg_key_type = 'four'; }
        if (empty($this->config->block_ekg_blocks_or_words)  || $this->config->block_ekg_blocks_or_words == 0 || !is_numeric($this->config->block_ekg_blocks_or_words) ) { $this->config->block_ekg_blocks_or_words = 3; }
        if (empty($this->config->block_ekg_chars_per_block) || $this->config->block_ekg_chars_per_block == 0 || !is_numeric($this->config->block_ekg_chars_per_block) ) { $this->config->block_ekg_chars_per_block = 4; }
        if (empty($this->config->block_ekg_number_of_keys) || $this->config->block_ekg_number_of_keys == 0 || !is_numeric($this->config->block_ekg_number_of_keys) ) { $this->config->block_ekg_number_of_keys = 2; }
        if (empty($this->config->block_ekg_text_transform)) { $this->config->block_ekg_text_transform = 'none'; }
        if (empty($this->config->block_ekg_hybrid_structure)) { $this->config->block_ekg_hybrid_structure = 'three-number-five'; }
        // hmm, screw-ups under 1.9.5+...
        if (empty($this->config->block_ekg_prefix)) { $this->config->block_ekg_prefix = ''; }
        if (empty($this->config->block_ekg_suffix)) { $this->config->block_ekg_suffix = ''; }
        
        // I think this is the best way of initialising a 'default' global config variable:
        if(!isset($CFG->block_ekg_footer) || empty($CFG->block_ekg_footer)) {
            // Not worried about the config_save() function, just save it direct.
            set_config('block_ekg_footer', 'words');
        }

    } // END function specialization()

    function config_save($data) {
        // Default behavior: save all variables as $CFG properties
        foreach ($data as $name => $value) {
            set_config($name, $value);
        }
        return true;
    }

    /**
     * All content is generated below.
     */
    function get_content() {

        // "if the user is logged in" includes guest login too. :)
        // this 'if' wraps the whole of this function!
        if (isloggedin()) {
            
            global $CFG;

            if ($this->content !== NULL) {
                return $this->content;
            }
            
            /* BEGIN Custom functions to **DO STUFF**! */

            if(!function_exists('makenumber')) {
                function makenumber ($upper, $lower) {
                    return rand($upper, $lower);
                }
            }

            if(!function_exists('transform_text')) {
                function transform_text($text, $method) {
                    switch ($method) {
                        case 'upper':
                            return mb_convert_case($text, MB_CASE_UPPER, "UTF-8");
                        break;
                        case 'lower':
                            return mb_convert_case($text, MB_CASE_LOWER, "UTF-8");
                        break;
                        case 'proper':
                            return mb_convert_case($text, MB_CASE_TITLE, "UTF-8");
                        break;
                        default:
                            return $text; 
                        break;
                    }
                }
            }

            if(!function_exists('getitem')) {
                function getitem($list, $len) {
                    // Using trim() to remove whitespace. Necessary for items from a text file, and useful for others?
                    return trim($list[rand(1,$len)-1]);
                }
            }

            if(!function_exists('getmd5')) {
                function getmd5() {
                    return md5(microtime());
                }
            }

            /* END Custom functions */

            /**
             * All wordlists.
             */
            $threeletterwordlist = array (
            'AAH', 'AAL', 'AAS', 'ABA', 'ABB', 'ABO', 'ABS', 'ABY', 'ACE', 'ACH', 'ACT', 'ADD', 'ADO', 'ADS', 'ADZ', 'AFF', 'AFT', 'AGA', 'AGE', 'AGO', 'AGS', 'AHA', 'AHI',
            'AHS', 'AIA', 'AID', 'AIL', 'AIM', 'AIN', 'AIR', 'AIS', 'AIT', 'AKA', 'AKE', 'ALA', 'ALB', 'ALE', 'ALF', 'ALL', 'ALP', 'ALS', 'ALT', 'AMA', 'AMI', 'AMP', 'AMU',
            'ANA', 'AND', 'ANE', 'ANI', 'ANN', 'ANT', 'ANY', 'APE', 'APO', 'APP', 'APT', 'ARB', 'ARC', 'ARD', 'ARE', 'ARF', 'ARK', 'ARM', 'ARS', 'ART', 'ARY', 'ASH', 'ASK',
            'ASP', 'ASS', 'ATE', 'ATT', 'AUA', 'AUE', 'AUF', 'AUK', 'AVA', 'AVE', 'AVO', 'AWA', 'AWE', 'AWL', 'AWN', 'AXE', 'AYE', 'AYS', 'AYU', 'AZO', 'BAA', 'BAC', 'BAD',
            'BAG', 'BAH', 'BAL', 'BAM', 'BAN', 'BAP', 'BAR', 'BAS', 'BAT', 'BAY', 'BED', 'BEE', 'BEG', 'BEL', 'BEN', 'BES', 'BET', 'BEY', 'BEZ', 'BIB', 'BID', 'BIG', 'BIN',
            'BIO', 'BIS', 'BIT', 'BIZ', 'BOA', 'BOB', 'BOD', 'BOG', 'BOH', 'BOI', 'BOK', 'BON', 'BOO', 'BOP', 'BOR', 'BOS', 'BOT', 'BOW', 'BOX', 'BOY', 'BRA', 'BRO', 'BRR',
            'BRU', 'BUB', 'BUD', 'BUG', 'BUM', 'BUN', 'BUR', 'BUS', 'BUT', 'BUY', 'BYE', 'BYS', 'CAA', 'CAB', 'CAD', 'CAG', 'CAM', 'CAN', 'CAP', 'CAR', 'CAT', 'CAW', 'CAY',
            'CAZ', 'CEE', 'CEL', 'CEP', 'CHA', 'CHE', 'CHI', 'CID', 'CIG', 'CIS', 'CIT', 'CLY', 'COB', 'COD', 'COG', 'COL', 'CON', 'COO', 'COP', 'COR', 'COS', 'COT', 'COW',
            'COX', 'COY', 'COZ', 'CRU', 'CRY', 'CUB', 'CUD', 'CUE', 'CUM', 'CUP', 'CUR', 'CUT', 'CUZ', 'CWM', 'DAB', 'DAD', 'DAE', 'DAG', 'DAH', 'DAK', 'DAL', 'DAM', 'DAN',
            'DAP', 'DAS', 'DAW', 'DAY', 'DEB', 'DEE', 'DEF', 'DEG', 'DEI', 'DEL', 'DEN', 'DEV', 'DEW', 'DEX', 'DEY', 'DIB', 'DID', 'DIE', 'DIF', 'DIG', 'DIM', 'DIN', 'DIP',
            'DIS', 'DIT', 'DIV', 'DOB', 'DOC', 'DOD', 'DOE', 'DOF', 'DOG', 'DOH', 'DOL', 'DOM', 'DON', 'DOO', 'DOP', 'DOR', 'DOS', 'DOT', 'DOW', 'DOY', 'DRY', 'DSO', 'DUB',
            'DUD', 'DUE', 'DUG', 'DUH', 'DUI', 'DUN', 'DUO', 'DUP', 'DUX', 'DYE', 'DZO', 'EAN', 'EAR', 'EAS', 'EAT', 'EAU', 'EBB', 'ECH', 'ECO', 'ECU', 'EDH', 'EDS', 'EEK',
            'EEL', 'EEN', 'EFF', 'EFS', 'EFT', 'EGG', 'EGO', 'EHS', 'EIK', 'EKE', 'ELD', 'ELF', 'ELK', 'ELL', 'ELM', 'ELS', 'ELT', 'EME', 'EMO', 'EMS', 'EMU', 'END', 'ENE',
            'ENG', 'ENS', 'EON', 'ERA', 'ERE', 'ERF', 'ERG', 'ERK', 'ERN', 'ERR', 'ERS', 'ESS', 'EST', 'ETA', 'ETH', 'EUK', 'EVE', 'EVO', 'EWE', 'EWK', 'EWT', 'EXO', 'EYE',
            'FAA', 'FAB', 'FAD', 'FAE', 'FAG', 'FAH', 'FAN', 'FAP', 'FAR', 'FAS', 'FAT', 'FAW', 'FAX', 'FAY', 'FED', 'FEE', 'FEG', 'FEH', 'FEM', 'FEN', 'FER', 'FES', 'FET',
            'FEU', 'FEW', 'FEY', 'FEZ', 'FIB', 'FID', 'FIE', 'FIG', 'FIL', 'FIN', 'FIR', 'FIT', 'FIX', 'FIZ', 'FLU', 'FLY', 'FOB', 'FOE', 'FOG', 'FOH', 'FON', 'FOP', 'FOR',
            'FOU', 'FOX', 'FOY', 'FRA', 'FRO', 'FRY', 'FUB', 'FUD', 'FUG', 'FUM', 'FUN', 'FUR', 'GAB', 'GAD', 'GAE', 'GAG', 'GAL', 'GAM', 'GAN', 'GAP', 'GAR', 'GAS', 'GAT',
            'GAU', 'GAY', 'GED', 'GEE', 'GEL', 'GEM', 'GEN', 'GEO', 'GET', 'GEY', 'GHI', 'GIB', 'GID', 'GIE', 'GIF', 'GIG', 'GIN', 'GIO', 'GIP', 'GIS', 'GIT', 'GJU', 'GNU',
            'GOA', 'GOB', 'GOD', 'GOE', 'GON', 'GOO', 'GOR', 'GOS', 'GOT', 'GOV', 'GOX', 'GOY', 'GUB', 'GUE', 'GUL', 'GUM', 'GUN', 'GUP', 'GUR', 'GUS', 'GUT', 'GUV', 'GUY',
            'GYM', 'GYP', 'HAD', 'HAE', 'HAG', 'HAH', 'HAJ', 'HAM', 'HAN', 'HAO', 'HAP', 'HAS', 'HAT', 'HAW', 'HAY', 'HEH', 'HEM', 'HEN', 'HEP', 'HER', 'HES', 'HET', 'HEW',
            'HEX', 'HEY', 'HIC', 'HID', 'HIE', 'HIM', 'HIN', 'HIP', 'HIS', 'HIT', 'HMM', 'HOA', 'HOB', 'HOC', 'HOD', 'HOE', 'HOG', 'HOH', 'HOI', 'HOM', 'HON', 'HOO', 'HOP',
            'HOS', 'HOT', 'HOW', 'HOX', 'HOY', 'HUB', 'HUE', 'HUG', 'HUH', 'HUI', 'HUM', 'HUN', 'HUP', 'HUT', 'HYE', 'HYP', 'ICE', 'ICH', 'ICK', 'ICY', 'IDE', 'IDS', 'IFF',
            'IFS', 'IGG', 'ILK', 'ILL', 'IMP', 'INK', 'INN', 'INS', 'ION', 'IOS', 'IRE', 'IRK', 'ISH', 'ISM', 'ISO', 'ITA', 'ITS', 'IVY', 'IWI', 'JAB', 'JAG', 'JAI', 'JAK',
            'JAM', 'JAP', 'JAR', 'JAW', 'JAY', 'JEE', 'JET', 'JEU', 'JEW', 'JIB', 'JIG', 'JIN', 'JIZ', 'JOB', 'JOE', 'JOG', 'JOL', 'JOR', 'JOT', 'JOW', 'JOY', 'JUD', 'JUG',
            'JUN', 'JUS', 'JUT', 'KAB', 'KAE', 'KAF', 'KAI', 'KAK', 'KAM', 'KAS', 'KAT', 'KAW', 'KAY', 'KEA', 'KEB', 'KED', 'KEF', 'KEG', 'KEN', 'KEP', 'KET', 'KEX', 'KEY',
            'KHI', 'KID', 'KIF', 'KIN', 'KIP', 'KIR', 'KIS', 'KIT', 'KOA', 'KOB', 'KOI', 'KON', 'KOP', 'KOR', 'KOS', 'KOW', 'KUE', 'KYE', 'KYU', 'LAB', 'LAC', 'LAD', 'LAG',
            'LAH', 'LAM', 'LAP', 'LAR', 'LAS', 'LAT', 'LAV', 'LAW', 'LAX', 'LAY', 'LEA', 'LED', 'LEE', 'LEG', 'LEI', 'LEK', 'LEP', 'LES', 'LET', 'LEU', 'LEV', 'LEW', 'LEX',
            'LEY', 'LEZ', 'LIB', 'LID', 'LIE', 'LIG', 'LIN', 'LIP', 'LIS', 'LIT', 'LOB', 'LOD', 'LOG', 'LOO', 'LOP', 'LOR', 'LOS', 'LOT', 'LOU', 'LOW', 'LOX', 'LOY', 'LUD',
            'LUG', 'LUM', 'LUR', 'LUV', 'LUX', 'LUZ', 'LYE', 'LYM', 'MAA', 'MAC', 'MAD', 'MAE', 'MAG', 'MAK', 'MAL', 'MAM', 'MAN', 'MAP', 'MAR', 'MAS', 'MAT', 'MAW', 'MAX',
            'MAY', 'MED', 'MEE', 'MEG', 'MEL', 'MEM', 'MEN', 'MES', 'MET', 'MEU', 'MEW', 'MHO', 'MIB', 'MIC', 'MID', 'MIG', 'MIL', 'MIM', 'MIR', 'MIS', 'MIX', 'MIZ', 'MNA',
            'MOA', 'MOB', 'MOC', 'MOD', 'MOE', 'MOG', 'MOI', 'MOL', 'MOM', 'MON', 'MOO', 'MOP', 'MOR', 'MOS', 'MOT', 'MOU', 'MOW', 'MOY', 'MOZ', 'MUD', 'MUG', 'MUM', 'MUN',
            'MUS', 'MUT', 'MUX', 'MYC', 'NAB', 'NAE', 'NAG', 'NAH', 'NAM', 'NAN', 'NAP', 'NAS', 'NAT', 'NAW', 'NAY', 'NEB', 'NED', 'NEE', 'NEF', 'NEG', 'NEK', 'NEP', 'NET',
            'NEW', 'NIB', 'NID', 'NIE', 'NIL', 'NIM', 'NIP', 'NIS', 'NIT', 'NIX', 'NOB', 'NOD', 'NOG', 'NOH', 'NOM', 'NON', 'NOO', 'NOR', 'NOS', 'NOT', 'NOW', 'NOX', 'NOY',
            'NTH', 'NUB', 'NUN', 'NUR', 'NUS', 'NUT', 'NYE', 'NYS', 'OAF', 'OAK', 'OAR', 'OAT', 'OBA', 'OBE', 'OBI', 'OBO', 'OBS', 'OCA', 'OCH', 'ODA', 'ODD', 'ODE', 'ODS',
            'OES', 'OFF', 'OFT', 'OHM', 'OHO', 'OHS', 'OIK', 'OIL', 'OKA', 'OKE', 'OLD', 'OLE', 'OLM', 'OMS', 'ONE', 'ONO', 'ONS', 'ONY', 'OOF', 'OOH', 'OOM', 'OON', 'OOP',
            'OOR', 'OOS', 'OOT', 'OPE', 'OPS', 'OPT', 'ORA', 'ORB', 'ORC', 'ORD', 'ORE', 'ORF', 'ORS', 'ORT', 'OSE', 'OUD', 'OUK', 'OUP', 'OUR', 'OUS', 'OUT', 'OVA', 'OWE',
            'OWL', 'OWN', 'OWT', 'OXO', 'OXY', 'OYE', 'OYS', 'PAC', 'PAD', 'PAH', 'PAL', 'PAM', 'PAN', 'PAP', 'PAR', 'PAS', 'PAT', 'PAV', 'PAW', 'PAX', 'PAY', 'PEA', 'PEC',
            'PED', 'PEE', 'PEG', 'PEH', 'PEN', 'PEP', 'PER', 'PES', 'PET', 'PEW', 'PHI', 'PHO', 'PHT', 'PIA', 'PIC', 'PIE', 'PIG', 'PIN', 'PIP', 'PIR', 'PIS', 'PIT', 'PIU',
            'PIX', 'PLU', 'PLY', 'POA', 'POD', 'POH', 'POI', 'POL', 'POM', 'POO', 'POP', 'POS', 'POT', 'POW', 'POX', 'POZ', 'PRE', 'PRO', 'PRY', 'PSI', 'PST', 'PUB', 'PUD',
            'PUG', 'PUH', 'PUL', 'PUN', 'PUP', 'PUR', 'PUS', 'PUT', 'PUY', 'PYA', 'PYE', 'PYX', 'QAT', 'QIS', 'QUA', 'RAD', 'RAG', 'RAH', 'RAI', 'RAJ', 'RAM', 'RAN', 'RAP',
            'RAS', 'RAT', 'RAW', 'RAX', 'RAY', 'REB', 'REC', 'RED', 'REE', 'REF', 'REG', 'REH', 'REI', 'REM', 'REN', 'REO', 'REP', 'RES', 'RET', 'REV', 'REW', 'REX', 'REZ',
            'RHO', 'RHY', 'RIA', 'RIB', 'RID', 'RIF', 'RIG', 'RIM', 'RIN', 'RIP', 'RIT', 'RIZ', 'ROB', 'ROC', 'ROD', 'ROE', 'ROK', 'ROM', 'ROO', 'ROT', 'ROW', 'RUB', 'RUC',
            'RUD', 'RUE', 'RUG', 'RUM', 'RUN', 'RUT', 'RYA', 'RYE', 'SAB', 'SAC', 'SAD', 'SAE', 'SAG', 'SAI', 'SAL', 'SAM', 'SAN', 'SAP', 'SAR', 'SAT', 'SAU', 'SAV', 'SAW',
            'SAX', 'SAY', 'SAZ', 'SEA', 'SEC', 'SED', 'SEE', 'SEG', 'SEI', 'SEL', 'SEN', 'SER', 'SET', 'SEW', 'SEX', 'SEY', 'SEZ', 'SHA', 'SHE', 'SHH', 'SHY', 'SIB', 'SIC',
            'SIF', 'SIK', 'SIM', 'SIN', 'SIP', 'SIR', 'SIS', 'SIT', 'SIX', 'SKA', 'SKI', 'SKY', 'SLY', 'SMA', 'SNY', 'SOB', 'SOC', 'SOD', 'SOG', 'SOH', 'SOL', 'SOM', 'SON',
            'SOP', 'SOS', 'SOT', 'SOU', 'SOV', 'SOW', 'SOX', 'SOY', 'SPA', 'SPY', 'SRI', 'STY', 'SUB', 'SUD', 'SUE', 'SUI', 'SUK', 'SUM', 'SUN', 'SUP', 'SUQ', 'SUR', 'SUS',
            'SWY', 'SYE', 'SYN', 'TAB', 'TAD', 'TAE', 'TAG', 'TAI', 'TAJ', 'TAK', 'TAM', 'TAN', 'TAO', 'TAP', 'TAR', 'TAS', 'TAT', 'TAU', 'TAV', 'TAW', 'TAX', 'TAY', 'TEA',
            'TEC', 'TED', 'TEE', 'TEF', 'TEG', 'TEL', 'TEN', 'TES', 'TET', 'TEW', 'TEX', 'THE', 'THO', 'THY', 'TIC', 'TID', 'TIE', 'TIG', 'TIL', 'TIN', 'TIP', 'TIS', 'TIT',
            'TIX', 'TOC', 'TOD', 'TOE', 'TOG', 'TOM', 'TON', 'TOO', 'TOP', 'TOR', 'TOT', 'TOW', 'TOY', 'TRY', 'TSK', 'TUB', 'TUG', 'TUI', 'TUM', 'TUN', 'TUP', 'TUT', 'TUX',
            'TWA', 'TWO', 'TWP', 'TYE', 'TYG', 'UDO', 'UDS', 'UEY', 'UFO', 'UGH', 'UGS', 'UKE', 'ULE', 'ULU', 'UMM', 'UMP', 'UMU', 'UNI', 'UNS', 'UPO', 'UPS', 'URB', 'URD',
            'URE', 'URN', 'URP', 'USE', 'UTA', 'UTE', 'UTS', 'UTU', 'UVA', 'VAC', 'VAE', 'VAG', 'VAN', 'VAR', 'VAS', 'VAT', 'VAU', 'VAV', 'VAW', 'VEE', 'VEG', 'VET', 'VEX',
            'VIA', 'VID', 'VIE', 'VIG', 'VIM', 'VIN', 'VIS', 'VLY', 'VOE', 'VOL', 'VOR', 'VOW', 'VOX', 'VUG', 'VUM', 'WAB', 'WAD', 'WAE', 'WAG', 'WAI', 'WAN', 'WAP', 'WAR',
            'WAS', 'WAT', 'WAW', 'WAX', 'WAY', 'WEB', 'WED', 'WEE', 'WEM', 'WEN', 'WET', 'WEX', 'WEY', 'WHA', 'WHO', 'WHY', 'WIG', 'WIN', 'WIS', 'WIT', 'WIZ', 'WOE', 'WOF',
            'WOG', 'WOK', 'WON', 'WOO', 'WOP', 'WOS', 'WOT', 'WOW', 'WOX', 'WRY', 'WUD', 'WUS', 'WYE', 'WYN', 'XIS', 'YAD', 'YAE', 'YAG', 'YAH', 'YAK', 'YAM', 'YAP', 'YAR',
            'YAW', 'YAY', 'YEA', 'YEH', 'YEN', 'YEP', 'YES', 'YET', 'YEW', 'YEX', 'YGO', 'YIN', 'YIP', 'YOB', 'YOD', 'YOK', 'YOM', 'YON', 'YOS', 'YOU', 'YOW', 'YUG', 'YUK',
            'YUM', 'YUP', 'YUS', 'ZAG', 'ZAP', 'ZAS', 'ZAX', 'ZEA', 'ZED', 'ZEE', 'ZEK', 'ZEL', 'ZEP', 'ZEX', 'ZHO', 'ZIG', 'ZIN', 'ZIP', 'ZIT', 'ZIZ', 'ZOA', 'ZOL', 'ZOO',
            'ZOS', 'ZUZ', 'ZZZ');
            $threeletterwordlistlen = count($threeletterwordlist);

            $fourletterwordlist = array (
            'AAHS', 'AALS', 'ABAC', 'ABAS', 'ABBA', 'ABBE', 'ABBS', 'ABED', 'ABET', 'ABID', 'ABLE', 'ABLY', 'ABOS', 'ABRI', 'ABUT', 'ABYE', 'ABYS', 'ACAI', 'ACCA', 'ACED',
            'ACER', 'ACES', 'ACHE', 'ACHY', 'ACID', 'ACME', 'ACNE', 'ACRE', 'ACTA', 'ACTS', 'ACYL', 'ADAW', 'ADDS', 'ADDY', 'ADIT', 'ADOS', 'ADRY', 'ADZE', 'AEON', 'AERO',
            'AERY', 'AESC', 'AFAR', 'AFFY', 'AFRO', 'AGAR', 'AGAS', 'AGED', 'AGEE', 'AGEN', 'AGER', 'AGES', 'AGHA', 'AGIN', 'AGIO', 'AGLU', 'AGLY', 'AGMA', 'AGOG', 'AGON',
            'AGUE', 'AHED', 'AHEM', 'AHIS', 'AHOY', 'AIAS', 'AIDE', 'AIDS', 'AIGA', 'AILS', 'AIMS', 'AINE', 'AINS', 'AIRN', 'AIRS', 'AIRT', 'AIRY', 'AITS', 'AITU', 'AJAR',
            'AJEE', 'AKED', 'AKEE', 'AKES', 'AKIN', 'ALAE', 'ALAN', 'ALAP', 'ALAR', 'ALAS', 'ALAY', 'ALBA', 'ALBE', 'ALBS', 'ALCO', 'ALEC', 'ALEE', 'ALEF', 'ALES', 'ALEW',
            'ALFA', 'ALFS', 'ALGA', 'ALIF', 'ALIT', 'ALKO', 'ALKY', 'ALLS', 'ALLY', 'ALMA', 'ALME', 'ALMS', 'ALOD', 'ALOE', 'ALOW', 'ALPS', 'ALSO', 'ALTO', 'ALTS', 'ALUM',
            'AMAH', 'AMAS', 'AMBO', 'AMEN', 'AMIA', 'AMID', 'AMIE', 'AMIN', 'AMIR', 'AMIS', 'AMLA', 'AMMO', 'AMOK', 'AMPS', 'AMUS', 'AMYL', 'ANAL', 'ANAN', 'ANAS', 'ANCE',
            'ANDS', 'ANES', 'ANEW', 'ANGA', 'ANIL', 'ANIS', 'ANKH', 'ANNA', 'ANNO', 'ANNS', 'ANOA', 'ANON', 'ANOW', 'ANSA', 'ANTA', 'ANTE', 'ANTI', 'ANTS', 'APAY', 'APED',
            'APER', 'APES', 'APEX', 'APOD', 'APOS', 'APPS', 'APSE', 'APSO', 'APTS', 'AQUA', 'ARAK', 'ARAR', 'ARBA', 'ARBS', 'ARCH', 'ARCO', 'ARCS', 'ARDS', 'AREA', 'ARED',
            'AREG', 'ARES', 'ARET', 'AREW', 'ARFS', 'ARIA', 'ARID', 'ARIL', 'ARIS', 'ARKS', 'ARLE', 'ARMS', 'ARMY', 'ARNA', 'AROW', 'ARPA', 'ARSY', 'ARTI', 'ARTS', 'ARTY',
            'ARUM', 'ARVO', 'ARYL', 'ASAR', 'ASCI', 'ASEA', 'ASHY', 'ASKS', 'ASPS', 'ATAP', 'ATES', 'ATMA', 'ATOC', 'ATOK', 'ATOM', 'ATOP', 'ATUA', 'AUFS', 'AUKS', 'AULA',
            'AULD', 'AUNE', 'AUNT', 'AURA', 'AUTO', 'AVAL', 'AVAS', 'AVEL', 'AVER', 'AVES', 'AVID', 'AVOS', 'AVOW', 'AWAY', 'AWDL', 'AWED', 'AWEE', 'AWES', 'AWLS', 'AWNS',
            'AWNY', 'AWOL', 'AWRY', 'AXAL', 'AXED', 'AXEL', 'AXES', 'AXIL', 'AXIS', 'AXLE', 'AXON', 'AYAH', 'AYES', 'AYIN', 'AYRE', 'AYUS', 'AZAN', 'AZON', 'AZYM', 'BAAL',
            'BAAS', 'BABA', 'BABE', 'BABU', 'BABY', 'BACH', 'BACK', 'BACS', 'BADE', 'BADS', 'BAEL', 'BAFF', 'BAFT', 'BAGH', 'BAGS', 'BAHT', 'BAIL', 'BAIT', 'BAJU', 'BAKE',
            'BALD', 'BALE', 'BALK', 'BALL', 'BALM', 'BALS', 'BALU', 'BAMS', 'BANC', 'BAND', 'BANE', 'BANG', 'BANI', 'BANK', 'BANS', 'BANT', 'BAPS', 'BAPU', 'BARB', 'BARD',
            'BARE', 'BARF', 'BARK', 'BARM', 'BARN', 'BARP', 'BARS', 'BASE', 'BASH', 'BASK', 'BASS', 'BAST', 'BATE', 'BATH', 'BATS', 'BATT', 'BAUD', 'BAUK', 'BAUR', 'BAWD',
            'BAWL', 'BAWN', 'BAWR', 'BAYE', 'BAYS', 'BAYT', 'BEAD', 'BEAK', 'BEAM', 'BEAN', 'BEAR', 'BEAT', 'BEAU', 'BECK', 'BEDE', 'BEDS', 'BEDU', 'BEEF', 'BEEN', 'BEEP',
            'BEER', 'BEES', 'BEET', 'BEGO', 'BEGS', 'BEIN', 'BELL', 'BELS', 'BELT', 'BEMA', 'BEND', 'BENE', 'BENI', 'BENJ', 'BENS', 'BENT', 'BERE', 'BERG', 'BERK', 'BERM',
            'BEST', 'BETA', 'BETE', 'BETH', 'BETS', 'BEVY', 'BEYS', 'BHAT', 'BHEL', 'BHUT', 'BIAS', 'BIBB', 'BIBS', 'BICE', 'BIDE', 'BIDI', 'BIDS', 'BIEN', 'BIER', 'BIFF',
            'BIGA', 'BIGG', 'BIGS', 'BIKE', 'BILE', 'BILK', 'BILL', 'BIMA', 'BIND', 'BINE', 'BING', 'BINK', 'BINS', 'BINT', 'BIOG', 'BIOS', 'BIRD', 'BIRK', 'BIRL', 'BIRO',
            'BIRR', 'BISE', 'BISH', 'BISK', 'BIST', 'BITE', 'BITO', 'BITS', 'BITT', 'BIZE', 'BLAB', 'BLAD', 'BLAE', 'BLAG', 'BLAH', 'BLAM', 'BLAT', 'BLAW', 'BLAY', 'BLEB',
            'BLED', 'BLEE', 'BLET', 'BLEW', 'BLEY', 'BLIN', 'BLIP', 'BLOB', 'BLOC', 'BLOG', 'BLOT', 'BLOW', 'BLUB', 'BLUE', 'BLUR', 'BOAB', 'BOAK', 'BOAR', 'BOAS', 'BOAT',
            'BOBA', 'BOBS', 'BOCK', 'BODE', 'BODS', 'BODY', 'BOEP', 'BOET', 'BOFF', 'BOGS', 'BOGY', 'BOHO', 'BOHS', 'BOIL', 'BOIS', 'BOKE', 'BOKO', 'BOKS', 'BOLA', 'BOLD',
            'BOLE', 'BOLL', 'BOLO', 'BOLT', 'BOMA', 'BOMB', 'BONA', 'BOND', 'BONE', 'BONG', 'BONK', 'BONY', 'BOOB', 'BOOH', 'BOOK', 'BOOL', 'BOOM', 'BOON', 'BOOR', 'BOOS',
            'BOOT', 'BOPS', 'BORA', 'BORD', 'BORE', 'BORK', 'BORM', 'BORN', 'BORS', 'BORT', 'BOSH', 'BOSK', 'BOSS', 'BOTA', 'BOTH', 'BOTS', 'BOTT', 'BOUK', 'BOUN', 'BOUT',
            'BOWL', 'BOWR', 'BOWS', 'BOXY', 'BOYF', 'BOYG', 'BOYO', 'BOYS', 'BOZO', 'BRAD', 'BRAE', 'BRAG', 'BRAK', 'BRAN', 'BRAS', 'BRAT', 'BRAW', 'BRAY', 'BRED', 'BREE',
            'BREI', 'BREN', 'BRER', 'BREW', 'BREY', 'BRIE', 'BRIG', 'BRIK', 'BRIM', 'BRIN', 'BRIO', 'BRIS', 'BRIT', 'BROD', 'BROG', 'BROO', 'BROS', 'BROW', 'BRRR', 'BRUS',
            'BRUT', 'BRUX', 'BUAT', 'BUBA', 'BUBO', 'BUBS', 'BUBU', 'BUCK', 'BUDA', 'BUDI', 'BUDO', 'BUDS', 'BUFF', 'BUFO', 'BUGS', 'BUHL', 'BUHR', 'BUIK', 'BUKE', 'BULB',
            'BULK', 'BULL', 'BUMF', 'BUMP', 'BUMS', 'BUNA', 'BUND', 'BUNG', 'BUNK', 'BUNN', 'BUNS', 'BUNT', 'BUOY', 'BURA', 'BURB', 'BURD', 'BURG', 'BURK', 'BURL', 'BURN',
            'BURP', 'BURR', 'BURS', 'BURY', 'BUSH', 'BUSK', 'BUSS', 'BUST', 'BUSY', 'BUTE', 'BUTS', 'BUTT', 'BUYS', 'BUZZ', 'BYDE', 'BYES', 'BYKE', 'BYRE', 'BYRL', 'BYTE',
            'CAAS', 'CABA', 'CABS', 'CACA', 'CADE', 'CADI', 'CADS', 'CAFE', 'CAFF', 'CAGE', 'CAGS', 'CAGY', 'CAID', 'CAIN', 'CAKE', 'CAKY', 'CALF', 'CALK', 'CALL', 'CALM',
            'CALO', 'CALP', 'CALX', 'CAMA', 'CAME', 'CAMO', 'CAMP', 'CAMS', 'CANE', 'CANG', 'CANN', 'CANS', 'CANT', 'CANY', 'CAPA', 'CAPE', 'CAPH', 'CAPI', 'CAPO', 'CAPS',
            'CARB', 'CARD', 'CARE', 'CARK', 'CARL', 'CARN', 'CARP', 'CARR', 'CARS', 'CART', 'CASA', 'CASE', 'CASH', 'CASK', 'CAST', 'CATE', 'CATS', 'CAUF', 'CAUK', 'CAUL',
            'CAUM', 'CAUP', 'CAVA', 'CAVE', 'CAVY', 'CAWK', 'CAWS', 'CAYS', 'CEAS', 'CECA', 'CEDE', 'CEDI', 'CEES', 'CEIL', 'CELL', 'CELS', 'CELT', 'CENS', 'CENT', 'CEPE',
            'CEPS', 'CERE', 'CERO', 'CERT', 'CESS', 'CETE', 'CHAD', 'CHAI', 'CHAL', 'CHAM', 'CHAO', 'CHAP', 'CHAR', 'CHAS', 'CHAT', 'CHAV', 'CHAW', 'CHAY', 'CHEF', 'CHER',
            'CHEW', 'CHEZ', 'CHIA', 'CHIB', 'CHIC', 'CHID', 'CHIK', 'CHIN', 'CHIP', 'CHIS', 'CHIT', 'CHIV', 'CHIZ', 'CHOC', 'CHOG', 'CHON', 'CHOP', 'CHOU', 'CHOW', 'CHUB',
            'CHUG', 'CHUM', 'CHUT', 'CIAO', 'CIDE', 'CIDS', 'CIEL', 'CIGS', 'CILL', 'CINE', 'CION', 'CIRE', 'CIRL', 'CIST', 'CITE', 'CITO', 'CITS', 'CITY', 'CIVE', 'CLAD',
            'CLAG', 'CLAM', 'CLAN', 'CLAP', 'CLAT', 'CLAW', 'CLAY', 'CLEF', 'CLEG', 'CLEM', 'CLEW', 'CLIP', 'CLOD', 'CLOG', 'CLON', 'CLOP', 'CLOT', 'CLOU', 'CLOW', 'CLOY',
            'CLUB', 'CLUE', 'COAL', 'COAT', 'COAX', 'COBB', 'COBS', 'COCA', 'COCH', 'COCO', 'CODA', 'CODE', 'CODS', 'COED', 'COFF', 'COFT', 'COGS', 'COHO', 'COIF', 'COIL',
            'COIN', 'COIR', 'COIT', 'COKE', 'COKY', 'COLA', 'COLD', 'COLE', 'COLL', 'COLS', 'COLT', 'COLY', 'COMA', 'COMB', 'COME', 'COMM', 'COMP', 'COMS', 'COND', 'CONE',
            'CONF', 'CONI', 'CONK', 'CONN', 'CONS', 'CONY', 'COOF', 'COOK', 'COOL', 'COOM', 'COON', 'COOP', 'COOS', 'COOT', 'COPE', 'COPS', 'COPY', 'CORD', 'CORE', 'CORF',
            'CORK', 'CORM', 'CORN', 'CORS', 'CORY', 'COSE', 'COSH', 'COSS', 'COST', 'COSY', 'COTE', 'COTH', 'COTS', 'COTT', 'COUP', 'COUR', 'COVE', 'COWK', 'COWL', 'COWP',
            'COWS', 'COWY', 'COXA', 'COXY', 'COYS', 'COZE', 'COZY', 'CRAB', 'CRAG', 'CRAM', 'CRAN', 'CRAP', 'CRAW', 'CRAY', 'CRED', 'CREE', 'CREM', 'CREW', 'CRIB', 'CRIM',
            'CRIS', 'CRIT', 'CROC', 'CROG', 'CROP', 'CROW', 'CRUD', 'CRUE', 'CRUS', 'CRUX', 'CUBE', 'CUBS', 'CUDS', 'CUED', 'CUES', 'CUFF', 'CUIF', 'CUIT', 'CUKE', 'CULL',
            'CULM', 'CULT', 'CUNT', 'CUPS', 'CURB', 'CURD', 'CURE', 'CURF', 'CURL', 'CURN', 'CURR', 'CURS', 'CURT', 'CUSH', 'CUSK', 'CUSP', 'CUSS', 'CUTE', 'CUTS', 'CWMS',
            'CYAN', 'CYMA', 'CYME', 'CYST', 'CYTE', 'CZAR', 'DABS', 'DACE', 'DACK', 'DADA', 'DADO', 'DADS', 'DAES', 'DAFF', 'DAFT', 'DAGO', 'DAGS', 'DAHL', 'DAHS', 'DAIS',
            'DAKS', 'DALE', 'DALI', 'DALS', 'DALT', 'DAME', 'DAMN', 'DAMP', 'DAMS', 'DANG', 'DANK', 'DANS', 'DANT', 'DAPS', 'DARB', 'DARE', 'DARG', 'DARI', 'DARK', 'DARN',
            'DART', 'DASH', 'DATA', 'DATE', 'DATO', 'DAUB', 'DAUD', 'DAUR', 'DAUT', 'DAVY', 'DAWD', 'DAWK', 'DAWN', 'DAWS', 'DAWT', 'DAYS', 'DAZE', 'DEAD', 'DEAF', 'DEAL',
            'DEAN', 'DEAR', 'DEAW', 'DEBE', 'DEBS', 'DEBT', 'DECK', 'DECO', 'DEED', 'DEEK', 'DEEM', 'DEEN', 'DEEP', 'DEER', 'DEES', 'DEET', 'DEEV', 'DEFI', 'DEFT', 'DEFY',
            'DEGS', 'DEID', 'DEIF', 'DEIL', 'DEKE', 'DELE', 'DELF', 'DELI', 'DELL', 'DELO', 'DELS', 'DELT', 'DEME', 'DEMO', 'DEMY', 'DENE', 'DENI', 'DENS', 'DENT', 'DENY',
            'DERE', 'DERM', 'DERN', 'DERO', 'DERV', 'DESI', 'DESK', 'DEUS', 'DEVA', 'DEVS', 'DEWS', 'DEWY', 'DEXY', 'DEYS', 'DHAK', 'DHAL', 'DHOL', 'DHOW', 'DIAL', 'DIBS',
            'DICE', 'DICH', 'DICT', 'DIDO', 'DIDY', 'DIEB', 'DIED', 'DIEL', 'DIES', 'DIET', 'DIFF', 'DIFS', 'DIGS', 'DIKA', 'DIKE', 'DILL', 'DIME', 'DIMP', 'DIMS', 'DINE',
            'DING', 'DINK', 'DINO', 'DINS', 'DINT', 'DIOL', 'DIPS', 'DIPT', 'DIRE', 'DIRK', 'DIRL', 'DIRT', 'DISA', 'DISC', 'DISH', 'DISK', 'DISS', 'DITA', 'DITE', 'DITS',
            'DITT', 'DITZ', 'DIVA', 'DIVE', 'DIVI', 'DIVS', 'DIXI', 'DIXY', 'DJIN', 'DOAB', 'DOAT', 'DOBS', 'DOBY', 'DOCK', 'DOCO', 'DOCS', 'DODO', 'DODS', 'DOEK', 'DOEN',
            'DOER', 'DOES', 'DOFF', 'DOGE', 'DOGS', 'DOGY', 'DOHS', 'DOIT', 'DOJO', 'DOLE', 'DOLL', 'DOLS', 'DOLT', 'DOME', 'DOMS', 'DOMY', 'DONA', 'DONE', 'DONG', 'DONS',
            'DOOB', 'DOOK', 'DOOL', 'DOOM', 'DOON', 'DOOR', 'DOOS', 'DOPA', 'DOPE', 'DOPS', 'DOPY', 'DORB', 'DORE', 'DORK', 'DORM', 'DORP', 'DORR', 'DORS', 'DORT', 'DORY',
            'DOSE', 'DOSH', 'DOSS', 'DOST', 'DOTE', 'DOTH', 'DOTS', 'DOTY', 'DOUC', 'DOUK', 'DOUM', 'DOUN', 'DOUP', 'DOUR', 'DOUT', 'DOUX', 'DOVE', 'DOWD', 'DOWF', 'DOWL',
            'DOWN', 'DOWP', 'DOWS', 'DOWT', 'DOXY', 'DOYS', 'DOZE', 'DOZY', 'DRAB', 'DRAC', 'DRAD', 'DRAG', 'DRAM', 'DRAP', 'DRAT', 'DRAW', 'DRAY', 'DREE', 'DREG', 'DREK',
            'DREW', 'DREY', 'DRIB', 'DRIP', 'DROP', 'DROW', 'DRUB', 'DRUG', 'DRUM', 'DRYS', 'DSOS', 'DUAD', 'DUAL', 'DUAN', 'DUAR', 'DUBS', 'DUCE', 'DUCI', 'DUCK', 'DUCT',
            'DUDE', 'DUDS', 'DUED', 'DUEL', 'DUES', 'DUET', 'DUFF', 'DUGS', 'DUIT', 'DUKA', 'DUKE', 'DULE', 'DULL', 'DULY', 'DUMA', 'DUMB', 'DUMP', 'DUNE', 'DUNG', 'DUNK',
            'DUNS', 'DUNT', 'DUOS', 'DUPE', 'DUPS', 'DURA', 'DURE', 'DURN', 'DURO', 'DURR', 'DUSH', 'DUSK', 'DUST', 'DUTY', 'DWAM', 'DYAD', 'DYED', 'DYER', 'DYES', 'DYKE',
            'DYNE', 'DZHO', 'DZOS', 'EACH', 'EALE', 'EANS', 'EARD', 'EARL', 'EARN', 'EARS', 'EASE', 'EAST', 'EASY', 'EATH', 'EATS', 'EAUS', 'EAUX', 'EAVE', 'EBBS', 'EBON',
            'ECAD', 'ECCE', 'ECCO', 'ECHE', 'ECHO', 'ECHT', 'ECOD', 'ECOS', 'ECRU', 'ECUS', 'EDDO', 'EDDY', 'EDGE', 'EDGY', 'EDHS', 'EDIT', 'EECH', 'EELS', 'EELY', 'EERY',
            'EEVN', 'EFFS', 'EFTS', 'EGAD', 'EGAL', 'EGER', 'EGGS', 'EGGY', 'EGIS', 'EGMA', 'EGOS', 'EHED', 'EIDE', 'EIKS', 'EILD', 'EINA', 'EINE', 'EISH', 'EKED', 'EKES',
            'EKKA', 'ELAN', 'ELDS', 'ELFS', 'ELHI', 'ELKS', 'ELLS', 'ELMS', 'ELMY', 'ELSE', 'ELTS', 'EMES', 'EMEU', 'EMIC', 'EMIR', 'EMIT', 'EMMA', 'EMMY', 'EMOS', 'EMPT',
            'EMUS', 'EMYD', 'EMYS', 'ENDS', 'ENES', 'ENEW', 'ENGS', 'ENOL', 'ENOW', 'ENUF', 'ENVY', 'EOAN', 'EONS', 'EORL', 'EPEE', 'EPHA', 'EPIC', 'EPOS', 'ERAS', 'ERED',
            'ERES', 'EREV', 'ERGO', 'ERGS', 'ERIC', 'ERKS', 'ERNE', 'ERNS', 'EROS', 'ERRS', 'ERST', 'ERUV', 'ESES', 'ESKY', 'ESNE', 'ESPY', 'ESSE', 'ESTS', 'ETAS', 'ETAT',
            'ETCH', 'ETEN', 'ETHE', 'ETHS', 'ETIC', 'ETNA', 'ETUI', 'EUGE', 'EUGH', 'EUKS', 'EUOI', 'EURO', 'EVEN', 'EVER', 'EVES', 'EVET', 'EVIL', 'EVOE', 'EVOS', 'EWER',
            'EWES', 'EWKS', 'EWTS', 'EXAM', 'EXEC', 'EXED', 'EXES', 'EXIT', 'EXON', 'EXPO', 'EXUL', 'EYAS', 'EYED', 'EYEN', 'EYER', 'EYES', 'EYNE', 'EYOT', 'EYRA', 'EYRE',
            'EYRY', 'FAAN', 'FAAS', 'FABS', 'FACE', 'FACT', 'FADE', 'FADO', 'FADS', 'FADY', 'FAFF', 'FAGS', 'FAHS', 'FAIK', 'FAIL', 'FAIN', 'FAIR', 'FAIX', 'FAKE', 'FALL',
            'FALX', 'FAME', 'FAND', 'FANE', 'FANG', 'FANK', 'FANO', 'FANS', 'FARD', 'FARE', 'FARL', 'FARM', 'FARO', 'FARS', 'FART', 'FASH', 'FAST', 'FATE', 'FATS', 'FAUN',
            'FAUR', 'FAUT', 'FAUX', 'FAVA', 'FAVE', 'FAWN', 'FAWS', 'FAYS', 'FAZE', 'FEAL', 'FEAR', 'FEAT', 'FECK', 'FEDS', 'FEEB', 'FEED', 'FEEL', 'FEEN', 'FEER', 'FEES',
            'FEET', 'FEGS', 'FEHM', 'FEHS', 'FEIS', 'FELL', 'FELT', 'FEME', 'FEMS', 'FEND', 'FENI', 'FENS', 'FENT', 'FEOD', 'FERE', 'FERM', 'FERN', 'FESS', 'FEST', 'FETA',
            'FETE', 'FETS', 'FETT', 'FEUD', 'FEUS', 'FEYS', 'FIAR', 'FIAT', 'FIBS', 'FICE', 'FICO', 'FIDO', 'FIDS', 'FIEF', 'FIER', 'FIFE', 'FIFI', 'FIGO', 'FIGS', 'FIKE',
            'FIKY', 'FILA', 'FILE', 'FILL', 'FILM', 'FILO', 'FILS', 'FIND', 'FINE', 'FINI', 'FINK', 'FINO', 'FINS', 'FIRE', 'FIRK', 'FIRM', 'FIRN', 'FIRS', 'FISC', 'FISH',
            'FISK', 'FIST', 'FITS', 'FITT', 'FIVE', 'FIXT', 'FIZZ', 'FLAB', 'FLAG', 'FLAK', 'FLAM', 'FLAN', 'FLAP', 'FLAT', 'FLAW', 'FLAX', 'FLAY', 'FLEA', 'FLED', 'FLEE',
            'FLEG', 'FLEW', 'FLEX', 'FLEY', 'FLIC', 'FLIM', 'FLIP', 'FLIR', 'FLIT', 'FLIX', 'FLOC', 'FLOE', 'FLOG', 'FLOP', 'FLOR', 'FLOW', 'FLUB', 'FLUE', 'FLUS', 'FLUX',
            'FOAL', 'FOAM', 'FOBS', 'FOCI', 'FOEN', 'FOES', 'FOGS', 'FOGY', 'FOHN', 'FOHS', 'FOID', 'FOIL', 'FOIN', 'FOLD', 'FOLK', 'FOND', 'FONE', 'FONS', 'FONT', 'FOOD',
            'FOOL', 'FOOT', 'FOPS', 'FORA', 'FORB', 'FORD', 'FORE', 'FORK', 'FORM', 'FORT', 'FOSS', 'FOUD', 'FOUL', 'FOUR', 'FOUS', 'FOWL', 'FOXY', 'FOYS', 'FOZY', 'FRAB',
            'FRAE', 'FRAG', 'FRAP', 'FRAS', 'FRAT', 'FRAU', 'FRAY', 'FREE', 'FRET', 'FRIB', 'FRIG', 'FRIS', 'FRIT', 'FRIZ', 'FROE', 'FROG', 'FROM', 'FROS', 'FROW', 'FRUG',
            'FUBS', 'FUCI', 'FUDS', 'FUEL', 'FUFF', 'FUGS', 'FUGU', 'FUJI', 'FULL', 'FUME', 'FUMS', 'FUMY', 'FUND', 'FUNG', 'FUNK', 'FUNS', 'FURL', 'FURR', 'FURS', 'FURY',
            'FUSC', 'FUSE', 'FUSS', 'FUST', 'FUTZ', 'FUZE', 'FUZZ', 'FYCE', 'FYKE', 'FYLE', 'FYRD', 'GABS', 'GABY', 'GADE', 'GADI', 'GADS', 'GAED', 'GAEN', 'GAES', 'GAFF',
            'GAGA', 'GAGE', 'GAGS', 'GAID', 'GAIN', 'GAIR', 'GAIT', 'GAJO', 'GALA', 'GALE', 'GALL', 'GALS', 'GAMA', 'GAMB', 'GAME', 'GAMP', 'GAMS', 'GAMY', 'GANE', 'GANG',
            'GANS', 'GANT', 'GAOL', 'GAPE', 'GAPO', 'GAPS', 'GAPY', 'GARB', 'GARE', 'GARI', 'GARS', 'GART', 'GASH', 'GASP', 'GAST', 'GATE', 'GATH', 'GATS', 'GAUD', 'GAUM',
            'GAUN', 'GAUP', 'GAUR', 'GAUS', 'GAVE', 'GAWD', 'GAWK', 'GAWP', 'GAYS', 'GAZE', 'GAZY', 'GEAL', 'GEAN', 'GEAR', 'GEAT', 'GECK', 'GEDS', 'GEED', 'GEEK', 'GEEP',
            'GEES', 'GEEZ', 'GEIT', 'GELD', 'GELS', 'GELT', 'GEMS', 'GENA', 'GENE', 'GENS', 'GENT', 'GENU', 'GEOS', 'GERE', 'GERM', 'GERT', 'GEST', 'GETA', 'GETS', 'GEUM',
            'GHAT', 'GHEE', 'GHIS', 'GIBE', 'GIBS', 'GIDS', 'GIED', 'GIEN', 'GIES', 'GIFT', 'GIGA', 'GIGS', 'GILA', 'GILD', 'GILL', 'GILT', 'GIMP', 'GING', 'GINK', 'GINN',
            'GINS', 'GIOS', 'GIPS', 'GIRD', 'GIRL', 'GIRN', 'GIRO', 'GIRR', 'GIRT', 'GISM', 'GIST', 'GITE', 'GITS', 'GIVE', 'GIZZ', 'GJUS', 'GLAD', 'GLAM', 'GLED', 'GLEE',
            'GLEG', 'GLEI', 'GLEN', 'GLEY', 'GLIA', 'GLIB', 'GLID', 'GLIM', 'GLIT', 'GLOB', 'GLOM', 'GLOP', 'GLOW', 'GLUE', 'GLUG', 'GLUM', 'GLUT', 'GNAR', 'GNAT', 'GNAW',
            'GNOW', 'GNUS', 'GOAD', 'GOAF', 'GOAL', 'GOAS', 'GOAT', 'GOBO', 'GOBS', 'GOBY', 'GODS', 'GOEL', 'GOER', 'GOES', 'GOEY', 'GOFF', 'GOGO', 'GOLD', 'GOLE', 'GOLF',
            'GOLP', 'GONE', 'GONG', 'GONK', 'GONS', 'GOOD', 'GOOF', 'GOOG', 'GOOK', 'GOOL', 'GOON', 'GOOP', 'GOOR', 'GOOS', 'GORA', 'GORE', 'GORI', 'GORM', 'GORP', 'GORY',
            'GOSH', 'GOSS', 'GOTH', 'GOUK', 'GOUT', 'GOVS', 'GOWD', 'GOWF', 'GOWK', 'GOWL', 'GOWN', 'GOYS', 'GRAB', 'GRAD', 'GRAM', 'GRAN', 'GRAT', 'GRAV', 'GRAY', 'GREE',
            'GREN', 'GREW', 'GREX', 'GREY', 'GRID', 'GRIG', 'GRIM', 'GRIN', 'GRIP', 'GRIS', 'GRIT', 'GROG', 'GROK', 'GROT', 'GROW', 'GRUB', 'GRUE', 'GRUM', 'GUAN', 'GUAR',
            'GUBS', 'GUCK', 'GUDE', 'GUES', 'GUFF', 'GUGA', 'GUID', 'GULA', 'GULE', 'GULF', 'GULL', 'GULP', 'GULS', 'GULY', 'GUMP', 'GUMS', 'GUNG', 'GUNK', 'GUNS', 'GUPS',
            'GURL', 'GURN', 'GURS', 'GURU', 'GUSH', 'GUST', 'GUTS', 'GUVS', 'GUYS', 'GYAL', 'GYBE', 'GYMP', 'GYMS', 'GYNY', 'GYPS', 'GYRE', 'GYRI', 'GYRO', 'GYTE', 'GYVE',
            'HAAF', 'HAAR', 'HABU', 'HACK', 'HADE', 'HADJ', 'HADS', 'HAED', 'HAEM', 'HAEN', 'HAES', 'HAET', 'HAFF', 'HAFT', 'HAGG', 'HAGS', 'HAHA', 'HAHS', 'HAIK', 'HAIL',
            'HAIN', 'HAIR', 'HAJI', 'HAJJ', 'HAKA', 'HAKE', 'HAKU', 'HALE', 'HALF', 'HALL', 'HALM', 'HALO', 'HALT', 'HAME', 'HAMS', 'HAND', 'HANG', 'HANK', 'HANT', 'HAPS',
            'HAPU', 'HARD', 'HARE', 'HARK', 'HARL', 'HARM', 'HARN', 'HARO', 'HARP', 'HART', 'HASH', 'HASK', 'HASP', 'HAST', 'HATE', 'HATH', 'HATS', 'HAUD', 'HAUF', 'HAUL',
            'HAUT', 'HAVE', 'HAWK', 'HAWM', 'HAWS', 'HAYS', 'HAZE', 'HAZY', 'HEAD', 'HEAL', 'HEAP', 'HEAR', 'HEAT', 'HEBE', 'HECH', 'HECK', 'HEED', 'HEEL', 'HEFT', 'HEHS',
            'HEID', 'HEIL', 'HEIR', 'HELD', 'HELE', 'HELL', 'HELM', 'HELO', 'HELP', 'HEME', 'HEMP', 'HEMS', 'HEND', 'HENS', 'HENT', 'HEPS', 'HEPT', 'HERB', 'HERD', 'HERE',
            'HERL', 'HERM', 'HERN', 'HERO', 'HERS', 'HERY', 'HESP', 'HEST', 'HETE', 'HETH', 'HETS', 'HEWN', 'HEWS', 'HEYS', 'HICK', 'HIDE', 'HIED', 'HIES', 'HIGH', 'HIKE',
            'HILA', 'HILD', 'HILI', 'HILL', 'HILT', 'HIMS', 'HIND', 'HING', 'HINS', 'HINT', 'HIOI', 'HIPS', 'HIPT', 'HIRE', 'HISH', 'HISN', 'HISS', 'HIST', 'HITS', 'HIVE',
            'HIYA', 'HIZZ', 'HOAR', 'HOAS', 'HOAX', 'HOBO', 'HOBS', 'HOCK', 'HODS', 'HOED', 'HOER', 'HOES', 'HOGG', 'HOGH', 'HOGS', 'HOHA', 'HOHS', 'HOIK', 'HOKA', 'HOKE',
            'HOKI', 'HOLD', 'HOLE', 'HOLK', 'HOLM', 'HOLP', 'HOLS', 'HOLT', 'HOLY', 'HOMA', 'HOME', 'HOMO', 'HOMS', 'HOMY', 'HOND', 'HONE', 'HONG', 'HONK', 'HONS', 'HOOD',
            'HOOF', 'HOOK', 'HOON', 'HOOP', 'HOOT', 'HOPE', 'HOPS', 'HORA', 'HORE', 'HORI', 'HORN', 'HORS', 'HOSE', 'HOSS', 'HOST', 'HOTE', 'HOTS', 'HOUF', 'HOUR', 'HOUT',
            'HOVE', 'HOWE', 'HOWF', 'HOWK', 'HOWL', 'HOWS', 'HOYA', 'HOYS', 'HUBS', 'HUCK', 'HUED', 'HUER', 'HUES', 'HUFF', 'HUGE', 'HUGS', 'HUGY', 'HUHU', 'HUIA', 'HUIC',
            'HUIS', 'HULA', 'HULE', 'HULK', 'HULL', 'HUMA', 'HUMF', 'HUMP', 'HUMS', 'HUNG', 'HUNH', 'HUNK', 'HUNS', 'HUNT', 'HUPS', 'HURL', 'HURT', 'HUSH', 'HUSK', 'HUSO',
            'HUSS', 'HUTS', 'HWAN', 'HWYL', 'HYED', 'HYEN', 'HYES', 'HYKE', 'HYLA', 'HYLE', 'HYMN', 'HYPE', 'HYPO', 'HYPS', 'HYTE', 'IAMB', 'IBEX', 'IBIS', 'ICED', 'ICER',
            'ICES', 'ICHS', 'ICKY', 'ICON', 'IDEA', 'IDEE', 'IDEM', 'IDES', 'IDLE', 'IDLY', 'IDOL', 'IDYL', 'IFFY', 'IGAD', 'IGGS', 'IGLU', 'IKAN', 'IKAT', 'IKON', 'ILEA',
            'ILEX', 'ILIA', 'ILKA', 'ILKS', 'ILLS', 'ILLY', 'IMAM', 'IMID', 'IMMY', 'IMPI', 'IMPS', 'INBY', 'INCH', 'INFO', 'INGO', 'INIA', 'INKS', 'INKY', 'INLY', 'INNS',
            'INRO', 'INTI', 'INTO', 'IONS', 'IOTA', 'IRED', 'IRES', 'IRID', 'IRIS', 'IRKS', 'IRON', 'ISBA', 'ISIT', 'ISLE', 'ISMS', 'ISNA', 'ISOS', 'ITAS', 'ITCH', 'ITEM',
            'IURE', 'IWIS', 'IXIA', 'IZAR', 'JAAP', 'JABS', 'JACK', 'JADE', 'JAFA', 'JAGA', 'JAGG', 'JAGS', 'JAIL', 'JAKE', 'JAKS', 'JAMB', 'JAMS', 'JANE', 'JANN', 'JAPE',
            'JAPS', 'JARK', 'JARL', 'JARP', 'JARS', 'JASP', 'JASS', 'JASY', 'JATO', 'JAUK', 'JAUP', 'JAVA', 'JAWS', 'JAXY', 'JAYS', 'JAZY', 'JAZZ', 'JEAN', 'JEAT', 'JEDI',
            'JEED', 'JEEL', 'JEEP', 'JEER', 'JEES', 'JEEZ', 'JEFE', 'JEFF', 'JEHU', 'JELL', 'JEON', 'JERK', 'JESS', 'JEST', 'JETE', 'JETS', 'JEUX', 'JEWS', 'JIAO', 'JIBB',
            'JIBE', 'JIBS', 'JIFF', 'JIGS', 'JILL', 'JILT', 'JIMP', 'JINK', 'JINN', 'JINS', 'JINX', 'JIRD', 'JIVE', 'JIVY', 'JIZZ', 'JOBE', 'JOBS', 'JOCK', 'JOCO', 'JOES',
            'JOEY', 'JOGS', 'JOHN', 'JOIN', 'JOKE', 'JOKY', 'JOLE', 'JOLL', 'JOLS', 'JOLT', 'JOMO', 'JONG', 'JOOK', 'JORS', 'JOSH', 'JOSS', 'JOTA', 'JOTS', 'JOUK', 'JOUR',
            'JOWL', 'JOWS', 'JOYS', 'JUBA', 'JUBE', 'JUCO', 'JUDO', 'JUDS', 'JUDY', 'JUGA', 'JUGS', 'JUJU', 'JUKE', 'JUKU', 'JUMP', 'JUNK', 'JUPE', 'JURA', 'JURE', 'JURY',
            'JUST', 'JUTE', 'JUTS', 'JUVE', 'JYNX', 'KAAL', 'KAAS', 'KABS', 'KADE', 'KADI', 'KAED', 'KAES', 'KAFS', 'KAGO', 'KAGU', 'KAID', 'KAIE', 'KAIF', 'KAIK', 'KAIL',
            'KAIM', 'KAIN', 'KAIS', 'KAKA', 'KAKI', 'KAKS', 'KALE', 'KALI', 'KAMA', 'KAME', 'KAMI', 'KANA', 'KANE', 'KANG', 'KANS', 'KANT', 'KAON', 'KAPA', 'KAPH', 'KARA',
            'KARK', 'KARN', 'KARO', 'KART', 'KATA', 'KATI', 'KATS', 'KAVA', 'KAWA', 'KAWS', 'KAYO', 'KAYS', 'KAZI', 'KBAR', 'KEAS', 'KEBS', 'KECK', 'KEDS', 'KEEF', 'KEEK',
            'KEEL', 'KEEN', 'KEEP', 'KEET', 'KEFS', 'KEGS', 'KEIR', 'KEKS', 'KELL', 'KELP', 'KELT', 'KEMB', 'KEMP', 'KENO', 'KENS', 'KENT', 'KEPI', 'KEPS', 'KEPT', 'KERB',
            'KERF', 'KERN', 'KERO', 'KESH', 'KEST', 'KETA', 'KETE', 'KETO', 'KETS', 'KEWL', 'KEYS', 'KHAF', 'KHAN', 'KHAT', 'KHET', 'KHIS', 'KHOR', 'KHUD', 'KIBE', 'KICK',
            'KIDS', 'KIEF', 'KIER', 'KIFF', 'KIFS', 'KIKE', 'KILD', 'KILL', 'KILN', 'KILO', 'KILP', 'KILT', 'KINA', 'KIND', 'KINE', 'KING', 'KINK', 'KINO', 'KINS', 'KIPE',
            'KIPP', 'KIPS', 'KIRK', 'KIRN', 'KIRS', 'KISH', 'KISS', 'KIST', 'KITE', 'KITH', 'KITS', 'KIVA', 'KIWI', 'KLAP', 'KLIK', 'KNAG', 'KNAP', 'KNAR', 'KNEE', 'KNEW',
            'KNIT', 'KNOB', 'KNOP', 'KNOT', 'KNOW', 'KNUB', 'KNUR', 'KNUT', 'KOAN', 'KOAP', 'KOAS', 'KOBO', 'KOBS', 'KOEL', 'KOFF', 'KOHA', 'KOHL', 'KOIS', 'KOJI', 'KOLA',
            'KOLO', 'KOND', 'KONK', 'KONS', 'KOOK', 'KOPH', 'KOPS', 'KORA', 'KORE', 'KORO', 'KORS', 'KORU', 'KOSS', 'KOTO', 'KOWS', 'KRAB', 'KRIS', 'KSAR', 'KUDO', 'KUDU',
            'KUEH', 'KUES', 'KUFI', 'KUIA', 'KUKU', 'KULA', 'KUNA', 'KUNE', 'KURI', 'KURU', 'KUTA', 'KUTI', 'KUTU', 'KUZU', 'KVAS', 'KYAK', 'KYAR', 'KYAT', 'KYBO', 'KYES',
            'KYLE', 'KYND', 'KYNE', 'KYPE', 'KYTE', 'KYUS', 'LABS', 'LACE', 'LACK', 'LACS', 'LACY', 'LADE', 'LADS', 'LADY', 'LAER', 'LAGS', 'LAHS', 'LAIC', 'LAID', 'LAIK',
            'LAIN', 'LAIR', 'LAKE', 'LAKH', 'LAKY', 'LALL', 'LAMA', 'LAMB', 'LAME', 'LAMP', 'LAMS', 'LANA', 'LAND', 'LANE', 'LANG', 'LANK', 'LANT', 'LANX', 'LAPS', 'LARD',
            'LARE', 'LARI', 'LARK', 'LARN', 'LARS', 'LASE', 'LASH', 'LASS', 'LAST', 'LATE', 'LATH', 'LATI', 'LATS', 'LATU', 'LAUD', 'LAUF', 'LAVA', 'LAVE', 'LAVS', 'LAWK',
            'LAWN', 'LAWS', 'LAYS', 'LAZE', 'LAZO', 'LAZY', 'LEAD', 'LEAF', 'LEAK', 'LEAL', 'LEAM', 'LEAN', 'LEAP', 'LEAR', 'LEAS', 'LEAT', 'LECH', 'LEED', 'LEEK', 'LEEP',
            'LEER', 'LEES', 'LEET', 'LEFT', 'LEGS', 'LEHR', 'LEIR', 'LEIS', 'LEKE', 'LEKS', 'LEKU', 'LEME', 'LEND', 'LENG', 'LENO', 'LENS', 'LENT', 'LEPS', 'LEPT', 'LERE',
            'LERP', 'LESS', 'LEST', 'LETS', 'LEUD', 'LEVA', 'LEVE', 'LEVO', 'LEVY', 'LEWD', 'LEYS', 'LEZZ', 'LIAR', 'LIAS', 'LIBS', 'LICE', 'LICH', 'LICK', 'LIDO', 'LIDS',
            'LIED', 'LIEF', 'LIEN', 'LIER', 'LIES', 'LIEU', 'LIFE', 'LIFT', 'LIGS', 'LIKE', 'LILL', 'LILO', 'LILT', 'LILY', 'LIMA', 'LIMB', 'LIME', 'LIMN', 'LIMO', 'LIMP',
            'LIMY', 'LIND', 'LINE', 'LING', 'LINK', 'LINN', 'LINO', 'LINS', 'LINT', 'LINY', 'LION', 'LIPA', 'LIPE', 'LIPO', 'LIPS', 'LIRA', 'LIRE', 'LIRI', 'LIRK', 'LISK',
            'LISP', 'LIST', 'LITE', 'LITH', 'LITS', 'LITU', 'LIVE', 'LOAD', 'LOAF', 'LOAM', 'LOAN', 'LOBE', 'LOBI', 'LOBO', 'LOBS', 'LOCA', 'LOCH', 'LOCI', 'LOCK', 'LOCO',
            'LODE', 'LODS', 'LOFT', 'LOGE', 'LOGO', 'LOGS', 'LOGY', 'LOID', 'LOIN', 'LOIR', 'LOKE', 'LOLL', 'LOMA', 'LOME', 'LONE', 'LONG', 'LOOF', 'LOOK', 'LOOM', 'LOON',
            'LOOP', 'LOOR', 'LOOS', 'LOOT', 'LOPE', 'LOPS', 'LORD', 'LORE', 'LORN', 'LORY', 'LOSE', 'LOSH', 'LOSS', 'LOST', 'LOTA', 'LOTE', 'LOTH', 'LOTI', 'LOTO', 'LOTS',
            'LOUD', 'LOUN', 'LOUP', 'LOUR', 'LOUS', 'LOUT', 'LOVE', 'LOWE', 'LOWN', 'LOWP', 'LOWS', 'LOWT', 'LOYS', 'LUAU', 'LUBE', 'LUCE', 'LUCK', 'LUDE', 'LUDO', 'LUDS',
            'LUES', 'LUFF', 'LUGE', 'LUGS', 'LUIT', 'LUKE', 'LULL', 'LULU', 'LUMA', 'LUMP', 'LUMS', 'LUNA', 'LUNE', 'LUNG', 'LUNK', 'LUNT', 'LUNY', 'LURE', 'LURK', 'LURS',
            'LUSH', 'LUSK', 'LUST', 'LUTE', 'LUTZ', 'LUVS', 'LUXE', 'LWEI', 'LYAM', 'LYCH', 'LYES', 'LYME', 'LYMS', 'LYNE', 'LYNX', 'LYRA', 'LYRE', 'LYSE', 'LYTE', 'MAAR',
            'MAAS', 'MABE', 'MACE', 'MACH', 'MACK', 'MACS', 'MADE', 'MADS', 'MAES', 'MAGE', 'MAGG', 'MAGI', 'MAGS', 'MAID', 'MAIK', 'MAIL', 'MAIM', 'MAIN', 'MAIR', 'MAKE',
            'MAKI', 'MAKO', 'MAKS', 'MALA', 'MALE', 'MALI', 'MALL', 'MALM', 'MALS', 'MALT', 'MAMA', 'MAMS', 'MANA', 'MAND', 'MANE', 'MANG', 'MANI', 'MANO', 'MANS', 'MANY',
            'MAPS', 'MARA', 'MARC', 'MARD', 'MARE', 'MARG', 'MARK', 'MARL', 'MARM', 'MARS', 'MART', 'MARY', 'MASA', 'MASE', 'MASH', 'MASK', 'MASS', 'MAST', 'MASU', 'MATE',
            'MATH', 'MATS', 'MATT', 'MATY', 'MAUD', 'MAUL', 'MAUN', 'MAUT', 'MAWK', 'MAWN', 'MAWR', 'MAWS', 'MAXI', 'MAYA', 'MAYO', 'MAYS', 'MAZE', 'MAZY', 'MEAD', 'MEAL',
            'MEAN', 'MEAT', 'MECK', 'MEDS', 'MEED', 'MEEK', 'MEER', 'MEES', 'MEET', 'MEFF', 'MEGA', 'MEGS', 'MEIN', 'MELA', 'MELD', 'MELL', 'MELS', 'MELT', 'MEME', 'MEMO',
            'MEMS', 'MEND', 'MENE', 'MENG', 'MENO', 'MENT', 'MENU', 'MEOU', 'MEOW', 'MERC', 'MERE', 'MERI', 'MERK', 'MERL', 'MESA', 'MESE', 'MESH', 'MESS', 'META', 'METE',
            'METH', 'METS', 'MEUS', 'MEVE', 'MEWL', 'MEWS', 'MEZE', 'MEZZ', 'MHOS', 'MIBS', 'MICA', 'MICE', 'MICH', 'MICK', 'MICO', 'MICS', 'MIDI', 'MIDS', 'MIEN', 'MIFF',
            'MIGG', 'MIGS', 'MIHA', 'MIHI', 'MIKE', 'MILD', 'MILE', 'MILK', 'MILL', 'MILO', 'MILS', 'MILT', 'MIME', 'MINA', 'MIND', 'MINE', 'MING', 'MINI', 'MINK', 'MINO',
            'MINT', 'MINX', 'MINY', 'MIPS', 'MIRE', 'MIRI', 'MIRK', 'MIRO', 'MIRS', 'MIRV', 'MIRY', 'MISE', 'MISO', 'MISS', 'MIST', 'MITE', 'MITT', 'MITY', 'MIXT', 'MIXY',
            'MIZZ', 'MNAS', 'MOAI', 'MOAN', 'MOAS', 'MOAT', 'MOBE', 'MOBS', 'MOBY', 'MOCH', 'MOCK', 'MOCS', 'MODE', 'MODI', 'MODS', 'MOER', 'MOES', 'MOFO', 'MOGS', 'MOHR',
            'MOIL', 'MOIT', 'MOJO', 'MOKE', 'MOKI', 'MOKO', 'MOLA', 'MOLD', 'MOLE', 'MOLL', 'MOLS', 'MOLT', 'MOLY', 'MOME', 'MOMI', 'MOMS', 'MONA', 'MONG', 'MONK', 'MONO',
            'MONS', 'MONY', 'MOOD', 'MOOI', 'MOOK', 'MOOL', 'MOON', 'MOOP', 'MOOR', 'MOOS', 'MOOT', 'MOPE', 'MOPS', 'MOPY', 'MORA', 'MORE', 'MORN', 'MORS', 'MORT', 'MOSE',
            'MOSH', 'MOSK', 'MOSS', 'MOST', 'MOTE', 'MOTH', 'MOTI', 'MOTS', 'MOTT', 'MOTU', 'MOUE', 'MOUP', 'MOUS', 'MOVE', 'MOWA', 'MOWN', 'MOWS', 'MOXA', 'MOYA', 'MOYL',
            'MOYS', 'MOZE', 'MOZO', 'MOZZ', 'MUCH', 'MUCK', 'MUDS', 'MUFF', 'MUGG', 'MUGS', 'MUID', 'MUIL', 'MUIR', 'MULE', 'MULL', 'MUMM', 'MUMP', 'MUMS', 'MUMU', 'MUNG',
            'MUNI', 'MUNS', 'MUNT', 'MUON', 'MURA', 'MURE', 'MURK', 'MURL', 'MURR', 'MUSE', 'MUSH', 'MUSK', 'MUSO', 'MUSS', 'MUST', 'MUTE', 'MUTI', 'MUTS', 'MUTT', 'MUZZ',
            'MYAL', 'MYCS', 'MYNA', 'MYTH', 'MYXO', 'MZEE', 'NAAM', 'NAAN', 'NABE', 'NABK', 'NABS', 'NACH', 'NADA', 'NADS', 'NAFF', 'NAGA', 'NAGS', 'NAIF', 'NAIK', 'NAIL',
            'NAIN', 'NALA', 'NAME', 'NAMS', 'NAMU', 'NANA', 'NANE', 'NANS', 'NAOI', 'NAOS', 'NAPA', 'NAPE', 'NAPS', 'NARC', 'NARD', 'NARE', 'NARK', 'NARY', 'NATS', 'NAVE',
            'NAVY', 'NAYS', 'NAZE', 'NAZI', 'NEAL', 'NEAP', 'NEAR', 'NEAT', 'NEBS', 'NECK', 'NEDS', 'NEED', 'NEEM', 'NEEP', 'NEFS', 'NEGS', 'NEIF', 'NEKS', 'NEMA', 'NEMN',
            'NENE', 'NEON', 'NEPS', 'NERD', 'NERK', 'NESH', 'NESS', 'NEST', 'NETE', 'NETS', 'NETT', 'NEUK', 'NEUM', 'NEVE', 'NEVI', 'NEWS', 'NEWT', 'NEXT', 'NIBS', 'NICE',
            'NICK', 'NIDE', 'NIDI', 'NIDS', 'NIED', 'NIEF', 'NIES', 'NIFE', 'NIFF', 'NIGH', 'NILL', 'NILS', 'NIMB', 'NIMS', 'NINE', 'NIPA', 'NIPS', 'NIRL', 'NISH', 'NISI',
            'NITE', 'NITS', 'NIXE', 'NIXY', 'NOAH', 'NOBS', 'NOCK', 'NODE', 'NODI', 'NODS', 'NOEL', 'NOES', 'NOGG', 'NOGS', 'NOIL', 'NOIR', 'NOLE', 'NOLL', 'NOLO', 'NOMA',
            'NOME', 'NOMS', 'NONA', 'NONE', 'NONG', 'NONI', 'NOOK', 'NOON', 'NOOP', 'NOPE', 'NORI', 'NORK', 'NORM', 'NOSE', 'NOSH', 'NOSY', 'NOTA', 'NOTE', 'NOTT', 'NOUL',
            'NOUN', 'NOUP', 'NOUS', 'NOUT', 'NOVA', 'NOWL', 'NOWN', 'NOWS', 'NOWT', 'NOWY', 'NOYS', 'NUBS', 'NUDE', 'NUFF', 'NUKE', 'NULL', 'NUMB', 'NUNS', 'NURD', 'NURL',
            'NURR', 'NURS', 'NUTS', 'NYAS', 'NYED', 'NYES', 'OAFS', 'OAKS', 'OAKY', 'OARS', 'OARY', 'OAST', 'OATH', 'OATS', 'OBAS', 'OBES', 'OBEY', 'OBIA', 'OBIS', 'OBIT',
            'OBOE', 'OBOL', 'OBOS', 'OCAS', 'OCCY', 'OCHE', 'OCTA', 'ODAH', 'ODAL', 'ODAS', 'ODDS', 'ODEA', 'ODES', 'ODIC', 'ODOR', 'ODSO', 'ODYL', 'OFAY', 'OFFS', 'OGAM',
            'OGEE', 'OGLE', 'OGRE', 'OHED', 'OHIA', 'OHMS', 'OHOS', 'OIKS', 'OILS', 'OILY', 'OINK', 'OINT', 'OKAS', 'OKAY', 'OKEH', 'OKES', 'OKRA', 'OKTA', 'OLDS', 'OLDY',
            'OLEA', 'OLEO', 'OLES', 'OLID', 'OLIO', 'OLLA', 'OLMS', 'OLPE', 'OMBU', 'OMEN', 'OMER', 'OMIT', 'OMOV', 'ONCE', 'ONER', 'ONES', 'ONIE', 'ONLY', 'ONOS', 'ONST',
            'ONTO', 'ONUS', 'ONYX', 'OOFS', 'OOFY', 'OOHS', 'OOMS', 'OONS', 'OONT', 'OOPS', 'OOSE', 'OOSY', 'OOTS', 'OOZE', 'OOZY', 'OPAH', 'OPAL', 'OPED', 'OPEN', 'OPES',
            'OPPO', 'OPTS', 'OPUS', 'ORAD', 'ORAL', 'ORBS', 'ORBY', 'ORCA', 'ORCS', 'ORDO', 'ORDS', 'ORES', 'ORFE', 'ORFS', 'ORGY', 'ORLE', 'ORRA', 'ORTS', 'ORYX', 'ORZO',
            'OSAR', 'OSES', 'OSSA', 'OTIC', 'OTTO', 'OUCH', 'OUDS', 'OUKS', 'OULD', 'OULK', 'OUMA', 'OUPA', 'OUPH', 'OUPS', 'OURN', 'OURS', 'OUST', 'OUTS', 'OUZO', 'OVAL',
            'OVEL', 'OVEN', 'OVER', 'OVUM', 'OWED', 'OWER', 'OWES', 'OWLS', 'OWLY', 'OWNS', 'OWRE', 'OWSE', 'OWTS', 'OXEN', 'OXER', 'OXES', 'OXID', 'OXIM', 'OYER', 'OYES',
            'OYEZ', 'PAAL', 'PACA', 'PACE', 'PACK', 'PACO', 'PACS', 'PACT', 'PACY', 'PADI', 'PADS', 'PAGE', 'PAHS', 'PAID', 'PAIK', 'PAIL', 'PAIN', 'PAIR', 'PAIS', 'PALE',
            'PALL', 'PALM', 'PALP', 'PALS', 'PALY', 'PAMS', 'PAND', 'PANE', 'PANG', 'PANS', 'PANT', 'PAPA', 'PAPE', 'PAPS', 'PARA', 'PARD', 'PARE', 'PARK', 'PARP', 'PARR',
            'PARS', 'PART', 'PASE', 'PASH', 'PASS', 'PAST', 'PATE', 'PATH', 'PATS', 'PATU', 'PATY', 'PAUA', 'PAUL', 'PAVE', 'PAVS', 'PAWA', 'PAWK', 'PAWL', 'PAWN', 'PAWS',
            'PAYS', 'PEAG', 'PEAK', 'PEAL', 'PEAN', 'PEAR', 'PEAS', 'PEAT', 'PEBA', 'PECH', 'PECK', 'PECS', 'PEDS', 'PEED', 'PEEK', 'PEEL', 'PEEN', 'PEEP', 'PEER', 'PEES',
            'PEGH', 'PEGS', 'PEHS', 'PEIN', 'PEKE', 'PELA', 'PELE', 'PELF', 'PELL', 'PELT', 'PEND', 'PENE', 'PENI', 'PENK', 'PENS', 'PENT', 'PEON', 'PEPO', 'PEPS', 'PERE',
            'PERI', 'PERK', 'PERM', 'PERN', 'PERP', 'PERT', 'PERV', 'PESO', 'PEST', 'PETS', 'PEWS', 'PFFT', 'PFUI', 'PHAT', 'PHEW', 'PHIS', 'PHIZ', 'PHOH', 'PHON', 'PHOS',
            'PHOT', 'PHUT', 'PIAL', 'PIAN', 'PIAS', 'PICA', 'PICE', 'PICK', 'PICS', 'PIED', 'PIER', 'PIES', 'PIET', 'PIGS', 'PIKA', 'PIKE', 'PIKI', 'PILA', 'PILE', 'PILI',
            'PILL', 'PILY', 'PIMA', 'PIMP', 'PINA', 'PINE', 'PING', 'PINK', 'PINS', 'PINT', 'PINY', 'PION', 'PIOY', 'PIPA', 'PIPE', 'PIPI', 'PIPS', 'PIPY', 'PIRL', 'PIRN',
            'PIRS', 'PISE', 'PISH', 'PISO', 'PISS', 'PITA', 'PITH', 'PITS', 'PITY', 'PIUM', 'PIXY', 'PIZE', 'PLAN', 'PLAP', 'PLAT', 'PLAY', 'PLEA', 'PLEB', 'PLED', 'PLEW',
            'PLEX', 'PLIE', 'PLIM', 'PLOD', 'PLOP', 'PLOT', 'PLOW', 'PLOY', 'PLUE', 'PLUG', 'PLUM', 'PLUS', 'POAS', 'POCK', 'POCO', 'PODS', 'POEM', 'POEP', 'POET', 'POGO',
            'POGY', 'POIS', 'POKE', 'POKY', 'POLE', 'POLK', 'POLL', 'POLO', 'POLS', 'POLT', 'POLY', 'POME', 'POMO', 'POMP', 'POMS', 'POND', 'PONE', 'PONG', 'PONK', 'PONS',
            'PONT', 'PONY', 'POOD', 'POOF', 'POOH', 'POOK', 'POOL', 'POON', 'POOP', 'POOR', 'POOS', 'POOT', 'POPE', 'POPS', 'PORE', 'PORK', 'PORN', 'PORT', 'PORY', 'POSE',
            'POSH', 'POSS', 'POST', 'POSY', 'POTE', 'POTS', 'POTT', 'POUF', 'POUK', 'POUR', 'POUT', 'POWN', 'POWS', 'POXY', 'POZZ', 'PRAD', 'PRAM', 'PRAO', 'PRAT', 'PRAU',
            'PRAY', 'PREE', 'PREM', 'PREP', 'PREX', 'PREY', 'PREZ', 'PRIG', 'PRIM', 'PROA', 'PROB', 'PROD', 'PROF', 'PROG', 'PROM', 'PROO', 'PROP', 'PROS', 'PROW', 'PRUH',
            'PRYS', 'PSIS', 'PSST', 'PTUI', 'PUBE', 'PUBS', 'PUCE', 'PUCK', 'PUDS', 'PUDU', 'PUER', 'PUFF', 'PUGH', 'PUGS', 'PUHA', 'PUIR', 'PUJA', 'PUKA', 'PUKE', 'PUKU',
            'PULA', 'PULE', 'PULI', 'PULK', 'PULL', 'PULP', 'PULS', 'PULU', 'PULY', 'PUMA', 'PUMP', 'PUMY', 'PUNA', 'PUNG', 'PUNK', 'PUNS', 'PUNT', 'PUNY', 'PUPA', 'PUPS',
            'PUPU', 'PURE', 'PURI', 'PURL', 'PURR', 'PURS', 'PUSH', 'PUSS', 'PUTS', 'PUTT', 'PUTZ', 'PUYS', 'PYAS', 'PYAT', 'PYES', 'PYET', 'PYIC', 'PYIN', 'PYNE', 'PYOT',
            'PYRE', 'PYRO', 'QADI', 'QAID', 'QATS', 'QOPH', 'QUAD', 'QUAG', 'QUAI', 'QUAT', 'QUAY', 'QUEP', 'QUEY', 'QUID', 'QUIM', 'QUIN', 'QUIP', 'QUIT', 'QUIZ', 'QUOD',
            'QUOP', 'RABI', 'RACA', 'RACE', 'RACH', 'RACK', 'RACY', 'RADE', 'RADS', 'RAFF', 'RAFT', 'RAGA', 'RAGE', 'RAGG', 'RAGI', 'RAGS', 'RAHS', 'RAIA', 'RAID', 'RAIK',
            'RAIL', 'RAIN', 'RAIS', 'RAIT', 'RAJA', 'RAKE', 'RAKI', 'RAKU', 'RALE', 'RAMI', 'RAMP', 'RAMS', 'RANA', 'RAND', 'RANG', 'RANI', 'RANK', 'RANT', 'RAPE', 'RAPS',
            'RAPT', 'RARE', 'RARK', 'RASE', 'RASH', 'RASP', 'RAST', 'RATA', 'RATE', 'RATH', 'RATO', 'RATS', 'RATU', 'RAUN', 'RAVE', 'RAWN', 'RAWS', 'RAYA', 'RAYS', 'RAZE',
            'RAZZ', 'READ', 'REAK', 'REAL', 'REAM', 'REAN', 'REAP', 'REAR', 'REBS', 'RECK', 'RECS', 'REDD', 'REDE', 'REDO', 'REDS', 'REED', 'REEF', 'REEK', 'REEL', 'REEN',
            'REES', 'REFS', 'REFT', 'REGO', 'REGS', 'REHS', 'REIF', 'REIK', 'REIN', 'REIS', 'REKE', 'RELY', 'REMS', 'REND', 'RENK', 'RENS', 'RENT', 'RENY', 'REOS', 'REPO',
            'REPP', 'REPS', 'RESH', 'REST', 'RETE', 'RETS', 'REVS', 'REWS', 'RHEA', 'RHOS', 'RHUS', 'RIAL', 'RIAS', 'RIBA', 'RIBS', 'RICE', 'RICH', 'RICK', 'RICY', 'RIDE',
            'RIDS', 'RIEL', 'RIEM', 'RIFE', 'RIFF', 'RIFS', 'RIFT', 'RIGG', 'RIGS', 'RILE', 'RILL', 'RIMA', 'RIME', 'RIMS', 'RIMU', 'RIMY', 'RIND', 'RINE', 'RING', 'RINK',
            'RINS', 'RIOT', 'RIPE', 'RIPP', 'RIPS', 'RIPT', 'RISE', 'RISK', 'RISP', 'RITE', 'RITS', 'RITT', 'RITZ', 'RIVA', 'RIVE', 'RIVO', 'RIZA', 'ROAD', 'ROAM', 'ROAN',
            'ROAR', 'ROBE', 'ROBS', 'ROCH', 'ROCK', 'ROCS', 'RODE', 'RODS', 'ROED', 'ROES', 'ROIL', 'ROIN', 'ROJI', 'ROKE', 'ROKS', 'ROKY', 'ROLE', 'ROLF', 'ROLL', 'ROMA',
            'ROMP', 'ROMS', 'RONE', 'RONG', 'RONT', 'ROOD', 'ROOF', 'ROOK', 'ROOM', 'ROON', 'ROOP', 'ROOS', 'ROOT', 'ROPE', 'ROPY', 'RORE', 'RORT', 'RORY', 'ROSE', 'ROST',
            'ROSY', 'ROTA', 'ROTE', 'ROTI', 'ROTL', 'ROTO', 'ROTS', 'ROUE', 'ROUL', 'ROUM', 'ROUP', 'ROUT', 'ROUX', 'ROVE', 'ROWS', 'ROWT', 'RUBE', 'RUBS', 'RUBY', 'RUCK',
            'RUCS', 'RUDD', 'RUDE', 'RUDS', 'RUED', 'RUER', 'RUES', 'RUFF', 'RUGA', 'RUGS', 'RUIN', 'RUKH', 'RULE', 'RULY', 'RUME', 'RUMP', 'RUMS', 'RUND', 'RUNE', 'RUNG',
            'RUNS', 'RUNT', 'RURP', 'RURU', 'RUSA', 'RUSE', 'RUSH', 'RUSK', 'RUST', 'RUTH', 'RUTS', 'RYAL', 'RYAS', 'RYES', 'RYFE', 'RYKE', 'RYND', 'RYOT', 'RYPE', 'SABE',
            'SABS', 'SACK', 'SACS', 'SADE', 'SADI', 'SADO', 'SADS', 'SAFE', 'SAFT', 'SAGA', 'SAGE', 'SAGO', 'SAGS', 'SAGY', 'SAIC', 'SAID', 'SAIL', 'SAIM', 'SAIN', 'SAIR',
            'SAIS', 'SAKE', 'SAKI', 'SALE', 'SALL', 'SALP', 'SALS', 'SALT', 'SAMA', 'SAME', 'SAMP', 'SAMS', 'SAND', 'SANE', 'SANG', 'SANK', 'SANS', 'SANT', 'SAPS', 'SARD',
            'SARI', 'SARK', 'SARS', 'SASH', 'SASS', 'SATE', 'SATI', 'SAUL', 'SAUT', 'SAVE', 'SAVS', 'SAWN', 'SAWS', 'SAXE', 'SAYS', 'SCAB', 'SCAD', 'SCAG', 'SCAM', 'SCAN',
            'SCAR', 'SCAT', 'SCAW', 'SCOG', 'SCOP', 'SCOT', 'SCOW', 'SCRY', 'SCUD', 'SCUG', 'SCUL', 'SCUM', 'SCUP', 'SCUR', 'SCUT', 'SCYE', 'SEAL', 'SEAM', 'SEAN', 'SEAR',
            'SEAS', 'SEAT', 'SECH', 'SECO', 'SECS', 'SECT', 'SEED', 'SEEK', 'SEEL', 'SEEM', 'SEEN', 'SEEP', 'SEER', 'SEES', 'SEGO', 'SEGS', 'SEIF', 'SEIK', 'SEIL', 'SEIR',
            'SEIS', 'SEKT', 'SELD', 'SELE', 'SELF', 'SELL', 'SELS', 'SEME', 'SEMI', 'SENA', 'SEND', 'SENE', 'SENS', 'SENT', 'SEPS', 'SEPT', 'SERA', 'SERE', 'SERF', 'SERK',
            'SERR', 'SERS', 'SESE', 'SESH', 'SESS', 'SETA', 'SETS', 'SETT', 'SEWN', 'SEWS', 'SEXT', 'SEXY', 'SEYS', 'SHAD', 'SHAH', 'SHAM', 'SHAN', 'SHAW', 'SHAY', 'SHEA',
            'SHED', 'SHES', 'SHET', 'SHEW', 'SHIM', 'SHIN', 'SHIP', 'SHIR', 'SHIV', 'SHMO', 'SHOD', 'SHOE', 'SHOG', 'SHOO', 'SHOP', 'SHOT', 'SHOW', 'SHRI', 'SHUL', 'SHUN',
            'SHUT', 'SHWA', 'SIAL', 'SIBB', 'SIBS', 'SICE', 'SICH', 'SICK', 'SICS', 'SIDA', 'SIDE', 'SIDH', 'SIEN', 'SIES', 'SIFT', 'SIGH', 'SIGN', 'SIJO', 'SIKA', 'SIKE',
            'SILD', 'SILE', 'SILK', 'SILL', 'SILO', 'SILT', 'SIMA', 'SIMI', 'SIMP', 'SIMS', 'SIND', 'SINE', 'SING', 'SINH', 'SINK', 'SINS', 'SIPE', 'SIPS', 'SIRE', 'SIRI',
            'SIRS', 'SISS', 'SIST', 'SITE', 'SITH', 'SITS', 'SITZ', 'SIZE', 'SIZY', 'SJOE', 'SKAG', 'SKAS', 'SKAT', 'SKAW', 'SKEE', 'SKEG', 'SKEN', 'SKEO', 'SKEP', 'SKER',
            'SKET', 'SKEW', 'SKID', 'SKIM', 'SKIN', 'SKIO', 'SKIP', 'SKIS', 'SKIT', 'SKOL', 'SKRY', 'SKUA', 'SKUG', 'SKYF', 'SKYR', 'SLAB', 'SLAE', 'SLAM', 'SLAP', 'SLAT',
            'SLAW', 'SLAY', 'SLED', 'SLEE', 'SLEW', 'SLEY', 'SLID', 'SLIM', 'SLIP', 'SLIT', 'SLOB', 'SLOE', 'SLOG', 'SLOP', 'SLOT', 'SLOW', 'SLUB', 'SLUE', 'SLUG', 'SLUM',
            'SLUR', 'SMEE', 'SMEW', 'SMIR', 'SMIT', 'SMOG', 'SMUG', 'SMUR', 'SMUT', 'SNAB', 'SNAG', 'SNAP', 'SNAR', 'SNAW', 'SNEB', 'SNED', 'SNEE', 'SNIB', 'SNIG', 'SNIP',
            'SNIT', 'SNOB', 'SNOD', 'SNOG', 'SNOT', 'SNOW', 'SNUB', 'SNUG', 'SNYE', 'SOAK', 'SOAP', 'SOAR', 'SOBA', 'SOBS', 'SOCA', 'SOCK', 'SOCS', 'SODA', 'SODS', 'SOFA',
            'SOFT', 'SOGS', 'SOHO', 'SOHS', 'SOIL', 'SOJA', 'SOKE', 'SOLA', 'SOLD', 'SOLE', 'SOLI', 'SOLO', 'SOLS', 'SOMA', 'SOME', 'SOMS', 'SOMY', 'SONE', 'SONG', 'SONS',
            'SOOK', 'SOOL', 'SOOM', 'SOON', 'SOOP', 'SOOT', 'SOPH', 'SOPS', 'SORA', 'SORB', 'SORD', 'SORE', 'SORI', 'SORN', 'SORT', 'SOSS', 'SOTH', 'SOTS', 'SOUK', 'SOUL',
            'SOUM', 'SOUP', 'SOUR', 'SOUS', 'SOUT', 'SOVS', 'SOWF', 'SOWL', 'SOWM', 'SOWN', 'SOWP', 'SOWS', 'SOYA', 'SOYS', 'SPAE', 'SPAG', 'SPAM', 'SPAN', 'SPAR', 'SPAS',
            'SPAT', 'SPAW', 'SPAY', 'SPAZ', 'SPEC', 'SPED', 'SPEK', 'SPET', 'SPEW', 'SPIC', 'SPIE', 'SPIF', 'SPIK', 'SPIM', 'SPIN', 'SPIT', 'SPIV', 'SPOD', 'SPOT', 'SPRY',
            'SPUD', 'SPUE', 'SPUG', 'SPUN', 'SPUR', 'SRIS', 'STAB', 'STAG', 'STAP', 'STAR', 'STAT', 'STAW', 'STAY', 'STED', 'STEM', 'STEN', 'STEP', 'STET', 'STEW', 'STEY',
            'STIE', 'STIM', 'STIR', 'STOA', 'STOB', 'STOP', 'STOT', 'STOW', 'STUB', 'STUD', 'STUM', 'STUN', 'STYE', 'SUBA', 'SUBS', 'SUCH', 'SUCK', 'SUDD', 'SUDS', 'SUED',
            'SUER', 'SUES', 'SUET', 'SUGH', 'SUID', 'SUIT', 'SUKH', 'SUKS', 'SULK', 'SULU', 'SUMO', 'SUMP', 'SUMS', 'SUMY', 'SUNG', 'SUNK', 'SUNN', 'SUNS', 'SUPE', 'SUPS',
            'SUQS', 'SURA', 'SURD', 'SURE', 'SURF', 'SUSS', 'SUSU', 'SWAB', 'SWAD', 'SWAG', 'SWAM', 'SWAN', 'SWAP', 'SWAT', 'SWAY', 'SWEE', 'SWEY', 'SWIG', 'SWIM', 'SWIZ',
            'SWOB', 'SWOP', 'SWOT', 'SWUM', 'SYBO', 'SYCE', 'SYED', 'SYEN', 'SYES', 'SYKE', 'SYLI', 'SYNC', 'SYND', 'SYNE', 'SYPE', 'SYPH', 'TAAL', 'TABI', 'TABS', 'TABU',
            'TACE', 'TACH', 'TACK', 'TACO', 'TACT', 'TADS', 'TAED', 'TAEL', 'TAES', 'TAGS', 'TAHA', 'TAHR', 'TAIG', 'TAIL', 'TAIN', 'TAIS', 'TAIT', 'TAKA', 'TAKE', 'TAKI',
            'TAKS', 'TAKY', 'TALA', 'TALC', 'TALE', 'TALI', 'TALK', 'TALL', 'TAME', 'TAMP', 'TAMS', 'TANA', 'TANE', 'TANG', 'TANH', 'TANK', 'TANS', 'TAOS', 'TAPA', 'TAPE',
            'TAPS', 'TAPU', 'TARA', 'TARE', 'TARN', 'TARO', 'TARP', 'TARS', 'TART', 'TASH', 'TASK', 'TASS', 'TATE', 'TATH', 'TATS', 'TATT', 'TATU', 'TAUS', 'TAUT', 'TAVA',
            'TAVS', 'TAWA', 'TAWS', 'TAWT', 'TAXA', 'TAXI', 'TAYS', 'TEAD', 'TEAK', 'TEAL', 'TEAM', 'TEAR', 'TEAS', 'TEAT', 'TECH', 'TECS', 'TEDS', 'TEDY', 'TEED', 'TEEK',
            'TEEL', 'TEEM', 'TEEN', 'TEER', 'TEES', 'TEFF', 'TEFS', 'TEGG', 'TEGS', 'TEGU', 'TEHR', 'TEIL', 'TELA', 'TELD', 'TELE', 'TELL', 'TELS', 'TELT', 'TEME', 'TEMP',
            'TEMS', 'TEND', 'TENE', 'TENS', 'TENT', 'TEPA', 'TERF', 'TERM', 'TERN', 'TEST', 'TETE', 'TETH', 'TETS', 'TEWS', 'TEXT', 'THAE', 'THAN', 'THAR', 'THAT', 'THAW',
            'THEE', 'THEM', 'THEN', 'THEW', 'THEY', 'THIG', 'THIN', 'THIO', 'THIR', 'THIS', 'THON', 'THOU', 'THRO', 'THRU', 'THUD', 'THUG', 'THUS', 'TIAR', 'TICE', 'TICH',
            'TICK', 'TICS', 'TIDE', 'TIDS', 'TIDY', 'TIED', 'TIER', 'TIES', 'TIFF', 'TIFT', 'TIGE', 'TIGS', 'TIKA', 'TIKE', 'TIKI', 'TILE', 'TILL', 'TILS', 'TILT', 'TIME',
            'TIND', 'TINE', 'TING', 'TINK', 'TINS', 'TINT', 'TINY', 'TIPI', 'TIPS', 'TIPT', 'TIRE', 'TIRL', 'TIRO', 'TIRR', 'TITE', 'TITI', 'TITS', 'TIVY', 'TIZZ', 'TOAD',
            'TOBY', 'TOCK', 'TOCO', 'TOCS', 'TODS', 'TODY', 'TOEA', 'TOED', 'TOES', 'TOEY', 'TOFF', 'TOFT', 'TOFU', 'TOGA', 'TOGE', 'TOGS', 'TOHO', 'TOIL', 'TOIT', 'TOKE',
            'TOKO', 'TOLA', 'TOLD', 'TOLE', 'TOLL', 'TOLT', 'TOLU', 'TOMB', 'TOME', 'TOMO', 'TOMS', 'TONE', 'TONG', 'TONK', 'TONS', 'TONY', 'TOOK', 'TOOL', 'TOOM', 'TOON',
            'TOOT', 'TOPE', 'TOPH', 'TOPI', 'TOPO', 'TOPS', 'TORA', 'TORC', 'TORE', 'TORI', 'TORN', 'TORO', 'TORR', 'TORS', 'TORT', 'TORY', 'TOSA', 'TOSE', 'TOSH', 'TOSS',
            'TOST', 'TOTE', 'TOTS', 'TOUK', 'TOUN', 'TOUR', 'TOUT', 'TOWN', 'TOWS', 'TOWT', 'TOWY', 'TOYO', 'TOYS', 'TOZE', 'TRAD', 'TRAM', 'TRAP', 'TRAT', 'TRAY', 'TREE',
            'TREF', 'TREK', 'TRES', 'TRET', 'TREW', 'TREY', 'TREZ', 'TRIE', 'TRIG', 'TRIM', 'TRIN', 'TRIO', 'TRIP', 'TROD', 'TROG', 'TRON', 'TROP', 'TROT', 'TROW', 'TROY',
            'TRUE', 'TRUG', 'TRYE', 'TRYP', 'TSAR', 'TSKS', 'TUAN', 'TUBA', 'TUBE', 'TUBS', 'TUCK', 'TUFA', 'TUFF', 'TUFT', 'TUGS', 'TUIS', 'TULE', 'TUMP', 'TUMS', 'TUNA',
            'TUND', 'TUNE', 'TUNG', 'TUNS', 'TUNY', 'TUPS', 'TURD', 'TURF', 'TURK', 'TURM', 'TURN', 'TUSH', 'TUSK', 'TUTS', 'TUTU', 'TUZZ', 'TWAE', 'TWAL', 'TWAS', 'TWAT',
            'TWAY', 'TWEE', 'TWIG', 'TWIN', 'TWIT', 'TWOS', 'TYDE', 'TYED', 'TYEE', 'TYER', 'TYES', 'TYGS', 'TYIN', 'TYKE', 'TYMP', 'TYND', 'TYNE', 'TYPE', 'TYPO', 'TYPP',
            'TYPY', 'TYRE', 'TYRO', 'TYTE', 'TZAR', 'UDAL', 'UDON', 'UDOS', 'UEYS', 'UFOS', 'UGHS', 'UGLY', 'UKES', 'ULAN', 'ULES', 'ULEX', 'ULNA', 'ULUS', 'ULVA', 'UMBO',
            'UMPH', 'UMPS', 'UMPY', 'UNAI', 'UNAU', 'UNBE', 'UNCE', 'UNCI', 'UNCO', 'UNDE', 'UNDO', 'UNDY', 'UNIS', 'UNIT', 'UNTO', 'UPAS', 'UPBY', 'UPDO', 'UPGO', 'UPON',
            'UPSY', 'UPTA', 'URAO', 'URBS', 'URDE', 'URDS', 'URDY', 'UREA', 'URES', 'URGE', 'URIC', 'URNS', 'URPS', 'URSA', 'URUS', 'URVA', 'USED', 'USER', 'USES', 'UTAS',
            'UTES', 'UTIS', 'UTUS', 'UVAE', 'UVAS', 'UVEA', 'VACS', 'VADE', 'VAES', 'VAGI', 'VAGS', 'VAIL', 'VAIN', 'VAIR', 'VALE', 'VALI', 'VAMP', 'VANE', 'VANG', 'VANS',
            'VANT', 'VARA', 'VARE', 'VARS', 'VARY', 'VASA', 'VASE', 'VAST', 'VATS', 'VATU', 'VAUS', 'VAUT', 'VAVS', 'VAWS', 'VEAL', 'VEEP', 'VEER', 'VEES', 'VEGA', 'VEGO',
            'VEHM', 'VEIL', 'VEIN', 'VELA', 'VELD', 'VELE', 'VELL', 'VENA', 'VEND', 'VENT', 'VERA', 'VERB', 'VERD', 'VERS', 'VERT', 'VERY', 'VEST', 'VETO', 'VETS', 'VEXT',
            'VIAE', 'VIAL', 'VIAS', 'VIBE', 'VIBS', 'VICE', 'VIDE', 'VIDS', 'VIED', 'VIER', 'VIES', 'VIEW', 'VIGA', 'VIGS', 'VILD', 'VILE', 'VILL', 'VIMS', 'VINA', 'VINE',
            'VINO', 'VINS', 'VINT', 'VINY', 'VIOL', 'VIRE', 'VIRL', 'VISA', 'VISE', 'VITA', 'VITE', 'VIVA', 'VIVE', 'VIVO', 'VIZY', 'VLEI', 'VOAR', 'VOES', 'VOID', 'VOLA',
            'VOLE', 'VOLK', 'VOLS', 'VOLT', 'VORS', 'VOTE', 'VOWS', 'VRIL', 'VROT', 'VROU', 'VROW', 'VUGG', 'VUGH', 'VUGS', 'VULN', 'VUMS', 'WAAC', 'WABS', 'WACK', 'WADD',
            'WADE', 'WADI', 'WADS', 'WADT', 'WADY', 'WAES', 'WAFF', 'WAFT', 'WAGE', 'WAGS', 'WAID', 'WAIF', 'WAIL', 'WAIN', 'WAIR', 'WAIS', 'WAIT', 'WAKA', 'WAKE', 'WAKF',
            'WALD', 'WALE', 'WALI', 'WALK', 'WALL', 'WALY', 'WAME', 'WAND', 'WANE', 'WANG', 'WANK', 'WANS', 'WANT', 'WANY', 'WAPS', 'WAQF', 'WARB', 'WARD', 'WARE', 'WARK',
            'WARM', 'WARN', 'WARP', 'WARS', 'WART', 'WARY', 'WASE', 'WASH', 'WASM', 'WASP', 'WAST', 'WATE', 'WATS', 'WATT', 'WAUK', 'WAUL', 'WAUR', 'WAVE', 'WAVY', 'WAWA',
            'WAWE', 'WAWL', 'WAWS', 'WAXY', 'WAYS', 'WEAK', 'WEAL', 'WEAN', 'WEAR', 'WEBS', 'WEDS', 'WEED', 'WEEK', 'WEEL', 'WEEM', 'WEEN', 'WEEP', 'WEER', 'WEES', 'WEET',
            'WEFT', 'WEID', 'WEIL', 'WEIR', 'WEKA', 'WELD', 'WELK', 'WELL', 'WELT', 'WEMB', 'WEMS', 'WENA', 'WEND', 'WENS', 'WENT', 'WEPT', 'WERE', 'WERO', 'WERT', 'WEST',
            'WETA', 'WETS', 'WEXE', 'WEYS', 'WHAE', 'WHAM', 'WHAP', 'WHAT', 'WHEE', 'WHEN', 'WHET', 'WHEW', 'WHEY', 'WHID', 'WHIG', 'WHIM', 'WHIN', 'WHIO', 'WHIP', 'WHIR',
            'WHIT', 'WHIZ', 'WHOA', 'WHOM', 'WHOP', 'WHOT', 'WHOW', 'WHUP', 'WHYS', 'WICE', 'WICH', 'WICK', 'WIDE', 'WIEL', 'WIFE', 'WIGS', 'WILD', 'WILE', 'WILI', 'WILL',
            'WILT', 'WILY', 'WIMP', 'WIND', 'WINE', 'WING', 'WINK', 'WINN', 'WINO', 'WINS', 'WINY', 'WIPE', 'WIRE', 'WIRY', 'WISE', 'WISH', 'WISP', 'WISS', 'WIST', 'WITE',
            'WITH', 'WITS', 'WIVE', 'WOAD', 'WOCK', 'WOES', 'WOFS', 'WOGS', 'WOKE', 'WOKS', 'WOLD', 'WOLF', 'WOMB', 'WONK', 'WONS', 'WONT', 'WOOD', 'WOOF', 'WOOL', 'WOON',
            'WOOS', 'WOOT', 'WOPS', 'WORD', 'WORE', 'WORK', 'WORM', 'WORN', 'WORT', 'WOST', 'WOTS', 'WOVE', 'WOWF', 'WOWS', 'WRAP', 'WREN', 'WRIT', 'WUDS', 'WUDU', 'WULL',
            'WUSS', 'WYCH', 'WYES', 'WYLE', 'WYND', 'WYNN', 'WYNS', 'WYTE', 'XYST', 'YAAR', 'YABA', 'YACK', 'YADS', 'YAFF', 'YAGI', 'YAGS', 'YAHS', 'YAKS', 'YALD', 'YALE',
            'YAMS', 'YANG', 'YANK', 'YAPP', 'YAPS', 'YARD', 'YARE', 'YARK', 'YARN', 'YARR', 'YATE', 'YAUD', 'YAUP', 'YAWL', 'YAWN', 'YAWP', 'YAWS', 'YAWY', 'YAYS', 'YBET',
            'YEAD', 'YEAH', 'YEAN', 'YEAR', 'YEAS', 'YEBO', 'YECH', 'YEDE', 'YEED', 'YEGG', 'YELD', 'YELK', 'YELL', 'YELM', 'YELP', 'YELT', 'YENS', 'YEPS', 'YERD', 'YERK',
            'YESK', 'YEST', 'YETI', 'YETT', 'YEUK', 'YEVE', 'YEWS', 'YGOE', 'YIDS', 'YIKE', 'YILL', 'YINS', 'YIPE', 'YIPS', 'YIRD', 'YIRK', 'YIRR', 'YITE', 'YLEM', 'YLKE',
            'YMPE', 'YMPT', 'YOBS', 'YOCK', 'YODE', 'YODH', 'YODS', 'YOGA', 'YOGH', 'YOGI', 'YOKE', 'YOKS', 'YOLD', 'YOLK', 'YOMP', 'YOND', 'YONI', 'YONT', 'YOOF', 'YOOP',
            'YORE', 'YORK', 'YORP', 'YOUK', 'YOUR', 'YOUS', 'YOWE', 'YOWL', 'YOWS', 'YUAN', 'YUCA', 'YUCH', 'YUCK', 'YUFT', 'YUGA', 'YUGS', 'YUKE', 'YUKO', 'YUKS', 'YUKY',
            'YULE', 'YUMP', 'YUNX', 'YUPS', 'YURT', 'YUTZ', 'YUZU', 'YWIS', 'ZACK', 'ZAGS', 'ZANY', 'ZAPS', 'ZARF', 'ZATI', 'ZEAL', 'ZEAS', 'ZEBU', 'ZEDS', 'ZEES', 'ZEIN',
            'ZEKS', 'ZELS', 'ZEPS', 'ZERK', 'ZERO', 'ZEST', 'ZETA', 'ZEZE', 'ZHOS', 'ZIFF', 'ZIGS', 'ZILA', 'ZILL', 'ZIMB', 'ZINC', 'ZINE', 'ZING', 'ZINS', 'ZIPS', 'ZITE',
            'ZITI', 'ZITS', 'ZIZZ', 'ZOBO', 'ZOBU', 'ZOEA', 'ZOIC', 'ZOLS', 'ZONA', 'ZONE', 'ZONK', 'ZOOM', 'ZOON', 'ZOOS', 'ZOOT', 'ZORI', 'ZOUK', 'ZULU', 'ZUPA', 'ZURF',
            'ZYGA', 'ZYME', 'ZZZS');
            $fourletterwordlistlen = count($fourletterwordlist);

            $fiveletterwordlist = array (
            "AAHED", "AALII", "AARGH", "ABACA", "ABACI", "ABACK", "ABAFT", "ABAKA", "ABAMP", "ABASE", "ABASH", "ABATE", "ABBAS", "ABBES", "ABBEY", "ABBOT", "ABEAM",
            "ABELE", "ABETS", "ABHOR", "ABIDE", "ABLER", "ABLES", "ABMHO", "ABODE", "ABOHM", "ABOIL", "ABOMA", "ABOON", "ABORT", "ABOUT", "ABOVE", "ABRIS", "ABUSE",
            "ABUTS", "ABUZZ", "ABYES", "ABYSM", "ABYSS", "ACARI", "ACERB", "ACETA", "ACHED", "ACHES", "ACHOO", "ACIDS", "ACIDY", "ACING", "ACINI", "ACKEE", "ACMES",
            "ACMIC", "ACNED", "ACNES", "ACOCK", "ACOLD", "ACORN", "ACRED", "ACRES", "ACRID", "ACTED", "ACTIN", "ACTOR", "ACUTE", "ACYLS", "ADAGE", "ADAPT", "ADDAX",
            "ADDED", "ADDER", "ADDLE", "ADEEM", "ADEPT", "ADIEU", "ADIOS", "ADITS", "ADMAN", "ADMEN", "ADMIT", "ADMIX", "ADOBE", "ADOBO", "ADOPT", "ADORE", "ADORN",
            "ADOWN", "ADOZE", "ADULT", "ADUNC", "ADUST", "ADYTA", "ADZES", "AECIA", "AEDES", "AEGIS", "AEONS", "AERIE", "AFARS", "AFFIX", "AFIRE", "AFOOT", "AFORE",
            "AFOUL", "AFRIT", "AFTER", "AGAIN", "AGAMA", "AGAPE", "AGARS", "AGATE", "AGAVE", "AGAZE", "AGENE", "AGENT", "AGERS", "AGGER", "AGGIE", "AGGRO", "AGHAS",
            "AGILE", "AGING", "AGIOS", "AGISM", "AGIST", "AGLEE", "AGLET", "AGLEY", "AGLOW", "AGMAS", "AGONE", "AGONS", "AGONY", "AGORA", "AGREE", "AGRIA", "AGUES",
            "AHEAD", "AHOLD", "AHULL", "AIDED", "AIDER", "AIDES", "AILED", "AIMED", "AIMER", "AIOLI", "AIRED", "AIRER", "AIRNS", "AIRTH", "AIRTS", "AISLE", "AITCH",
            "AIVER", "AJIVA", "AJUGA", "AKEES", "AKELA", "AKENE", "ALACK", "ALAMO", "ALAND", "ALANE", "ALANG", "ALANS", "ALANT", "ALARM", "ALARY", "ALATE", "ALBAS",
            "ALBUM", "ALCID", "ALDER", "ALDOL", "ALECS", "ALEFS", "ALEPH", "ALERT", "ALFAS", "ALGAE", "ALGAL", "ALGAS", "ALGID", "ALGIN", "ALGOR", "ALGUM", "ALIAS",
            "ALIBI", "ALIEN", "ALIFS", "ALIGN", "ALIKE", "ALINE", "ALIST", "ALIVE", "ALIYA", "ALKYD", "ALKYL", "ALLAY", "ALLEE", "ALLEY", "ALLOD", "ALLOT", "ALLOW",
            "ALLOY", "ALLYL", "ALMAH", "ALMAS", "ALMEH", "ALMES", "ALMUD", "ALMUG", "ALOES", "ALOFT", "ALOHA", "ALOIN", "ALONE", "ALONG", "ALOOF", "ALOUD", "ALPHA",
            "ALTAR", "ALTER", "ALTHO", "ALTOS", "ALULA", "ALUMS", "ALWAY", "AMAHS", "AMAIN", "AMASS", "AMAZE", "AMBER", "AMBIT", "AMBLE", "AMBOS", "AMBRY", "AMEBA",
            "AMEER", "AMEND", "AMENS", "AMENT", "AMIAS", "AMICE", "AMICI", "AMIDE", "AMIDO", "AMIDS", "AMIES", "AMIGA", "AMIGO", "AMINE", "AMINO", "AMINS", "AMIRS",
            "AMISS", "AMITY", "AMMOS", "AMNIA", "AMNIC", "AMNIO", "AMOKS", "AMOLE", "AMONG", "AMORT", "AMOUR", "AMPLE", "AMPLY", "AMPUL", "AMUCK", "AMUSE", "AMYLS",
            "ANCON", "ANEAR", "ANELE", "ANENT", "ANGAS", "ANGEL", "ANGER", "ANGLE", "ANGRY", "ANGST", "ANILE", "ANILS", "ANIMA", "ANIME", "ANIMI", "ANION", "ANISE",
            "ANKHS", "ANKLE", "ANKUS", "ANLAS", "ANNAL", "ANNAS", "ANNEX", "ANNOY", "ANNUL", "ANOAS", "ANODE", "ANOLE", "ANOMY", "ANSAE", "ANTAE", "ANTAS", "ANTED",
            "ANTES", "ANTIC", "ANTIS", "ANTRA", "ANTRE", "ANTSY", "ANVIL", "AORTA", "APACE", "APART", "APEAK", "APEEK", "APERS", "APERY", "APHID", "APHIS", "APIAN",
            "APING", "APISH", "APNEA", "APODS", "APORT", "APPAL", "APPEL", "APPLE", "APPLY", "APRES", "APRON", "APSES", "APSIS", "APTER", "APTLY", "AQUAE", "AQUAS",
            "ARAKS", "ARBOR", "ARCED", "ARCUS", "ARDEB", "ARDOR", "AREAE", "AREAL", "AREAS", "ARECA", "AREIC", "ARENA", "ARETE", "ARGAL", "ARGIL", "ARGLE", "ARGOL",
            "ARGON", "ARGOT", "ARGUE", "ARGUS", "ARHAT", "ARIAS", "ARIEL", "ARILS", "ARISE", "ARLES", "ARMED", "ARMER", "ARMET", "ARMOR", "AROID", "AROMA", "AROSE",
            "ARPEN", "ARRAS", "ARRAY", "ARRIS", "ARROW", "ARSES", "ARSIS", "ARSON", "ARTAL", "ARTEL", "ARTSY", "ARUMS", "ARVAL", "ARVOS", "ARYLS", "ASANA", "ASCOT",
            "ASCUS", "ASDIC", "ASHED", "ASHEN", "ASHES", "ASIDE", "ASKED", "ASKER", "ASKEW", "ASKOI", "ASKOS", "ASPEN", "ASPER", "ASPIC", "ASPIS", "ASSAI", "ASSAY",
            "ASSED", "ASSES", "ASSET", "ASTER", "ASTIR", "ASYLA", "ATAPS", "ATAXY", "ATILT", "ATLAS", "ATMAN", "ATMAS", "ATOLL", "ATOMS", "ATOMY", "ATONE", "ATONY",
            "ATOPY", "ATRIA", "ATRIP", "ATTAR", "ATTIC", "AUDAD", "AUDIO", "AUDIT", "AUGER", "AUGHT", "AUGUR", "AULIC", "AUNTS", "AUNTY", "AURAE", "AURAL", "AURAR",
            "AURAS", "AUREI", "AURES", "AURIC", "AURIS", "AURUM", "AUTOS", "AUXIN", "AVAIL", "AVANT", "AVAST", "AVENS", "AVERS", "AVERT", "AVGAS", "AVIAN", "AVION",
            "AVISO", "AVOID", "AVOWS", "AWAIT", "AWAKE", "AWARD", "AWARE", "AWASH", "AWFUL", "AWING", "AWNED", "AWOKE", "AWOLS", "AXELS", "AXIAL", "AXILE", "AXILS",
            "AXING", "AXIOM", "AXION", "AXITE", "AXLED", "AXLES", "AXMAN", "AXMEN", "AXONE", "AXONS", "AYAHS", "AYINS", "AZANS", "AZIDE", "AZIDO", "AZINE", "AZLON",
            "AZOIC", "AZOLE", "AZONS", "AZOTE", "AZOTH", "AZURE", "BAAED", "BAALS", "BABAS", "BABEL", "BABES", "BABKA", "BABOO", "BABUL", "BABUS", "BACCA", "BACKS",
            "BACON", "BADDY", "BADGE", "BADLY", "BAFFS", "BAFFY", "BAGEL", "BAGGY", "BAHTS", "BAILS", "BAIRN", "BAITH", "BAITS", "BAIZA", "BAIZE", "BAKED", "BAKER",
            "BAKES", "BALAS", "BALDS", "BALDY", "BALED", "BALER", "BALES", "BALKS", "BALKY", "BALLS", "BALLY", "BALMS", "BALMY", "BALSA", "BANAL", "BANCO", "BANDS",
            "BANDY", "BANED", "BANES", "BANGS", "BANJO", "BANKS", "BANNS", "BANTY", "BARBE", "BARBS", "BARDE", "BARDS", "BARED", "BARER", "BARES", "BARFS", "BARGE",
            "BARIC", "BARKS", "BARKY", "BARMS", "BARMY", "BARNS", "BARNY", "BARON", "BARRE", "BARYE", "BASAL", "BASED", "BASER", "BASES", "BASIC", "BASIL", "BASIN",
            "BASIS", "BASKS", "BASSI", "BASSO", "BASSY", "BASTE", "BASTS", "BATCH", "BATED", "BATES", "BATHE", "BATHS", "BATIK", "BATON", "BATTS", "BATTU", "BATTY",
            "BAUDS", "BAULK", "BAWDS", "BAWDY", "BAWLS", "BAWTY", "BAYED", "BAYOU", "BAZAR", "BAZOO", "BEACH", "BEADS", "BEADY", "BEAKS", "BEAKY", "BEAMS", "BEAMY",
            "BEANO", "BEANS", "BEARD", "BEARS", "BEAST", "BEATS", "BEAUS", "BEAUT", "BEAUX", "BEBOP", "BECAP", "BECKS", "BEDEL", "BEDEW", "BEDIM", "BEECH", "BEEFS",
            "BEEFY", "BEEPS", "BEERS", "BEERY", "BEETS", "BEFIT", "BEFOG", "BEGAN", "BEGAT", "BEGET", "BEGIN", "BEGOT", "BEGUM", "BEGUN", "BEIGE", "BEIGY", "BEING",
            "BELAY", "BELCH", "BELGA", "BELIE", "BELLE", "BELLS", "BELLY", "BELOW", "BELTS", "BEMAS", "BEMIX", "BENCH", "BENDS", "BENDY", "BENES", "BENNE", "BENNI",
            "BENNY", "BENTS", "BERET", "BERGS", "BERME", "BERMS", "BERRY", "BERTH", "BERYL", "BESET", "BESOM", "BESOT", "BESTS", "BETAS", "BETEL", "BETHS", "BETON",
            "BETTA", "BEVEL", "BEVOR", "BEWIG", "BEZEL", "BEZIL", "BHANG", "BHOOT", "BHUTS", "BIALI", "BIALY", "BIBBS", "BIBLE", "BICES", "BIDDY", "BIDED", "BIDER",
            "BIDES", "BIDET", "BIELD", "BIERS", "BIFFS", "BIFFY", "BIFID", "BIGHT", "BIGLY", "BIGOT", "BIJOU", "BIKED", "BIKER", "BIKES", "BIKIE", "BILBO", "BILES",
            "BILGE", "BILGY", "BILKS", "BILLS", "BILLY", "BIMAH", "BIMAS", "BIMBO", "BINAL", "BINDI", "BINDS", "BINES", "BINGE", "BINGO", "BINIT", "BINTS", "BIOME",
            "BIONT", "BIOTA", "BIPED", "BIPOD", "BIRCH", "BIRDS", "BIRKS", "BIRLE", "BIRLS", "BIRRS", "BIRSE", "BIRTH", "BISES", "BISKS", "BISON", "BITCH", "BITER",
            "BITES", "BITSY", "BITTS", "BITTY", "BIZES", "BLABS", "BLACK", "BLADE", "BLAHS", "BLAIN", "BLAME", "BLAMS", "BLAND", "BLANK", "BLARE", "BLASE", "BLAST",
            "BLATE", "BLATS", "BLAWN", "BLAWS", "BLAZE", "BLEAK", "BLEAR", "BLEAT", "BLEBS", "BLEED", "BLEEP", "BLEND", "BLENT", "BLESS", "BLEST", "BLETS", "BLIMP",
            "BLIMY", "BLIND", "BLINI", "BLINK", "BLIPS", "BLISS", "BLITE", "BLITZ", "BLOAT", "BLOBS", "BLOCK", "BLOCS", "BLOKE", "BLOND", "BLOOD", "BLOOM", "BLOOP",
            "BLOTS", "BLOWN", "BLOWS", "BLOWY", "BLUBS", "BLUED", "BLUER", "BLUES", "BLUET", "BLUEY", "BLUFF", "BLUME", "BLUNT", "BLURB", "BLURS", "BLURT", "BLUSH",
            "BLYPE", "BOARD", "BOARS", "BOART", "BOAST", "BOATS", "BOBBY", "BOCCE", "BOCCI", "BOCHE", "BOCKS", "BODED", "BODES", "BOFFO", "BOFFS", "BOGAN", "BOGEY",
            "BOGGY", "BOGIE", "BOGLE", "BOGUS", "BOHEA", "BOILS", "BOING", "BOITE", "BOLAR", "BOLAS", "BOLDS", "BOLES", "BOLLS", "BOLOS", "BOLTS", "BOLUS", "BOMBE",
            "BOMBS", "BONDS", "BONED", "BONER", "BONES", "BONEY", "BONGO", "BONGS", "BONKS", "BONNE", "BONNY", "BONUS", "BONZE", "BOOBS", "BOOBY", "BOOED", "BOOGY",
            "BOOKS", "BOOMS", "BOOMY", "BOONS", "BOORS", "BOOST", "BOOTH", "BOOTS", "BOOTY", "BOOZE", "BOOZY", "BORAL", "BORAS", "BORAX", "BORED", "BORER", "BORES",
            "BORIC", "BORNE", "BORON", "BORTS", "BORTY", "BORTZ", "BOSKS", "BOSKY", "BOSOM", "BOSON", "BOSSY", "BOSUN", "BOTAS", "BOTCH", "BOTEL", "BOTHY", "BOTTS",
            "BOUGH", "BOULE", "BOUND", "BOURG", "BOURN", "BOUSE", "BOUSY", "BOUTS", "BOVID", "BOWED", "BOWEL", "BOWER", "BOWLS", "BOWSE", "BOXED", "BOXER", "BOXES",
            "BOYAR", "BOYLA", "BOYOS", "BOZOS", "BRACE", "BRACH", "BRACT", "BRADS", "BRAES", "BRAGS", "BRAID", "BRAIL", "BRAIN", "BRAKE", "BRAKY", "BRAND", "BRANK",
            "BRANS", "BRANT", "BRASH", "BRASS", "BRATS", "BRAVA", "BRAVE", "BRAVI", "BRAVO", "BRAWL", "BRAWN", "BRAWS", "BRAXY", "BRAYS", "BRAZA", "BRAZE", "BREAD",
            "BREAK", "BREAM", "BREDE", "BREED", "BREES", "BRENS", "BRENT", "BREVE", "BREWS", "BRIAR", "BRIBE", "BRICK", "BRIDE", "BRIEF", "BRIER", "BRIES", "BRIGS",
            "BRILL", "BRIMS", "BRINE", "BRING", "BRINK", "BRINS", "BRINY", "BRIOS", "BRISK", "BRITS", "BRITT", "BROAD", "BROCK", "BROIL", "BROKE", "BROME", "BROMO",
            "BRONC", "BROOD", "BROOK", "BROOM", "BROOS", "BROSE", "BROSY", "BROTH", "BROWN", "BROWS", "BRUGH", "BRUIN", "BRUIT", "BRUME", "BRUNT", "BRUSH", "BRUSK",
            "BRUTE", "BUBAL", "BUBBY", "BUCKO", "BUCKS", "BUDDY", "BUDGE", "BUFFI", "BUFFO", "BUFFS", "BUFFY", "BUGGY", "BUGLE", "BUHLS", "BUHRS", "BUILD", "BUILT",
            "BULBS", "BULGE", "BULGY", "BULKS", "BULKY", "BULLA", "BULLS", "BULLY", "BUMFS", "BUMPH", "BUMPS", "BUMPY", "BUNCH", "BUNCO", "BUNDS", "BUNDT", "BUNGS",
            "BUNKO", "BUNKS", "BUNNS", "BUNNY", "BUNTS", "BUNYA", "BUOYS", "BURAN", "BURAS", "BURBS", "BURDS", "BURET", "BURGH", "BURGS", "BURIN", "BURKE", "BURLS",
            "BURLY", "BURNS", "BURNT", "BURPS", "BURRO", "BURRS", "BURRY", "BURSA", "BURSE", "BURST", "BUSBY", "BUSED", "BUSES", "BUSHY", "BUSKS", "BUSTS", "BUSTY",
            "BUTCH", "BUTEO", "BUTES", "BUTLE", "BUTTE", "BUTTS", "BUTTY", "BUTUT", "BUTYL", "BUXOM", "BUYER", "BWANA", "BYLAW", "BYRES", "BYRLS", "BYSSI", "BYTES",
            "BYWAY", "CABAL", "CABBY", "CABER", "CABIN", "CABLE", "CABOB", "CACAO", "CACAS", "CACHE", "CACTI", "CADDY", "CADES", "CADET", "CADGE", "CADGY", "CADIS",
            "CADRE", "CAECA", "CAFES", "CAFFS", "CAGED", "CAGER", "CAGES", "CAGEY", "CAHOW", "CAIDS", "CAINS", "CAIRD", "CAIRN", "CAJON", "CAKED", "CAKES", "CAKEY",
            "CALFS", "CALIF", "CALIX", "CALKS", "CALLA", "CALLS", "CALMS", "CALOS", "CALVE", "CALYX", "CAMAS", "CAMEL", "CAMEO", "CAMES", "CAMPI", "CAMPO", "CAMPS",
            "CAMPY", "CANAL", "CANDY", "CANED", "CANER", "CANES", "CANID", "CANNA", "CANNY", "CANOE", "CANON", "CANSO", "CANST", "CANTO", "CANTS", "CANTY", "CAPED",
            "CAPER", "CAPES", "CAPHS", "CAPON", "CAPOS", "CAPUT", "CARAT", "CARBO", "CARBS", "CARDS", "CARED", "CARER", "CARES", "CARET", "CAREX", "CARGO", "CARKS",
            "CARLE", "CARLS", "CARNS", "CARNY", "CAROB", "CAROL", "CAROM", "CARPI", "CARPS", "CARRS", "CARRY", "CARSE", "CARTE", "CARTS", "CARVE", "CASAS", "CASED",
            "CASES", "CASKS", "CASKY", "CASTE", "CASTS", "CASUS", "CATCH", "CATER", "CATES", "CATTY", "CAULD", "CAULK", "CAULS", "CAUSE", "CAVED", "CAVER", "CAVES",
            "CAVIE", "CAVIL", "CAWED", "CEASE", "CEBID", "CECAL", "CECUM", "CEDAR", "CEDED", "CEDER", "CEDES", "CEDIS", "CEIBA", "CEILS", "CELEB", "CELLA", "CELLI",
            "CELLO", "CELLS", "CELOM", "CELTS", "CENSE", "CENTO", "CENTS", "CENTU", "CEORL", "CEPES", "CERCI", "CERED", "CERES", "CERIA", "CERIC", "CEROS", "CESTA",
            "CESTI", "CETES", "CHADS", "CHAFE", "CHAFF", "CHAIN", "CHAIR", "CHALK", "CHAMP", "CHAMS", "CHANG", "CHANT", "CHAOS", "CHAPE", "CHAPS", "CHAPT", "CHARD",
            "CHARE", "CHARK", "CHARM", "CHARR", "CHARS", "CHART", "CHARY", "CHASE", "CHASM", "CHATS", "CHAWS", "CHAYS", "CHEAP", "CHEAT", "CHECK", "CHEEK", "CHEEP",
            "CHEER", "CHEFS", "CHELA", "CHEMO", "CHERT", "CHESS", "CHEST", "CHETH", "CHEVY", "CHEWS", "CHEWY", "CHIAO", "CHIAS", "CHICK", "CHICO", "CHICS", "CHIDE",
            "CHIEF", "CHIEL", "CHILD", "CHILE", "CHILI", "CHILL", "CHIMB", "CHIME", "CHIMP", "CHINA", "CHINE", "CHINK", "CHINO", "CHINS", "CHIPS", "CHIRK", "CHIRM",
            "CHIRO", "CHIRP", "CHIRR", "CHITS", "CHIVE", "CHIVY", "CHOCK", "CHOIR", "CHOKE", "CHOKY", "CHOLO", "CHOMP", "CHOOK", "CHOPS", "CHORD", "CHORE", "CHOSE",
            "CHOTT", "CHOWS", "CHUBS", "CHUCK", "CHUFA", "CHUFF", "CHUGS", "CHUMP", "CHUMS", "CHUNK", "CHURL", "CHURN", "CHURR", "CHUTE", "CHYLE", "CHYME", "CIBOL",
            "CIDER", "CIGAR", "CILIA", "CIMEX", "CINCH", "CINES", "CIONS", "CIRCA", "CIRES", "CIRRI", "CISCO", "CISSY", "CISTS", "CITED", "CITER", "CITES", "CIVET",
            "CIVIC", "CIVIE", "CIVIL", "CIVVY", "CLACH", "CLACK", "CLADE", "CLADS", "CLAGS", "CLAIM", "CLAMP", "CLAMS", "CLANG", "CLANK", "CLANS", "CLAPS", "CLAPT",
            "CLARO", "CLARY", "CLASH", "CLASP", "CLASS", "CLAST", "CLAVE", "CLAVI", "CLAWS", "CLAYS", "CLEAN", "CLEAR", "CLEAT", "CLEEK", "CLEFS", "CLEFT", "CLEPE",
            "CLEPT", "CLERK", "CLEWS", "CLICK", "CLIFF", "CLIFT", "CLIMB", "CLIME", "CLINE", "CLING", "CLINK", "CLIPS", "CLIPT", "CLITS", "CLOAK", "CLOCK", "CLODS",
            "CLOGS", "CLOMB", "CLOMP", "CLONE", "CLONK", "CLONS", "CLOOT", "CLOPS", "CLOSE", "CLOTH", "CLOTS", "CLOUD", "CLOUR", "CLOUT", "CLOVE", "CLOWN", "CLOYS",
            "CLOZE", "CLUBS", "CLUCK", "CLUED", "CLUES", "CLUMP", "CLUNG", "CLUNK", "COACH", "COACT", "COALA", "COALS", "COALY", "COAPT", "COAST", "COATI", "COATS",
            "COBBS", "COBBY", "COBIA", "COBLE", "COBRA", "COCAS", "COCCI", "COCKS", "COCKY", "COCOA", "COCOS", "CODAS", "CODEC", "CODED", "CODEN", "CODER", "CODES",
            "CODEX", "CODON", "COEDS", "COFFS", "COGON", "COHOG", "COHOS", "COIFS", "COIGN", "COILS", "COINS", "COIRS", "COKED", "COKES", "COLAS", "COLDS", "COLED",
            "COLES", "COLIC", "COLIN", "COLLY", "COLOG", "COLON", "COLOR", "COLTS", "COLZA", "COMAE", "COMAL", "COMAS", "COMBE", "COMBO", "COMBS", "COMER", "COMES",
            "COMET", "COMFY", "COMIC", "COMIX", "COMMA", "COMMY", "COMPO", "COMPS", "COMPT", "COMTE", "CONCH", "CONDO", "CONED", "CONES", "CONEY", "CONGA", "CONGE",
            "CONGO", "CONIC", "CONIN", "CONKS", "CONKY", "CONNS", "CONTE", "CONTO", "CONUS", "COOCH", "COOED", "COOEE", "COOER", "COOEY", "COOFS", "COOKS", "COOKY",
            "COOLS", "COOLY", "COOMB", "COONS", "COOPS", "COOPT", "COOTS", "COPAL", "COPED", "COPEN", "COPER", "COPES", "COPRA", "COPSE", "CORAL", "CORBY", "CORDS",
            "CORED", "CORER", "CORES", "CORGI", "CORIA", "CORKS", "CORKY", "CORMS", "CORNS", "CORNU", "CORNY", "CORPS", "CORSE", "COSEC", "COSES", "COSET", "COSEY",
            "COSIE", "COSTA", "COSTS", "COTAN", "COTED", "COTES", "COTTA", "COUCH", "COUDE", "COUGH", "COULD", "COUNT", "COUPE", "COUPS", "COURT", "COUTH", "COVED",
            "COVEN", "COVER", "COVES", "COVET", "COVEY", "COVIN", "COWED", "COWER", "COWLS", "COWRY", "COXAE", "COXAL", "COXED", "COXES", "COYED", "COYER", "COYLY",
            "COYPU", "COZEN", "COZES", "COZEY", "COZIE", "CRAAL", "CRABS", "CRACK", "CRAFT", "CRAGS", "CRAKE", "CRAMP", "CRAMS", "CRANE", "CRANK", "CRAPE", "CRAPS",
            "CRASH", "CRASS", "CRATE", "CRAVE", "CRAWL", "CRAWS", "CRAZE", "CRAZY", "CREAK", "CREAM", "CREDO", "CREED", "CREEK", "CREEL", "CREEP", "CREME", "CREPE",
            "CREPT", "CREPY", "CRESS", "CREST", "CREWS", "CRIBS", "CRICK", "CRIED", "CRIER", "CRIES", "CRIME", "CRIMP", "CRIPE", "CRISP", "CROAK", "CROCI", "CROCK",
            "CROCS", "CROFT", "CRONE", "CRONY", "CROOK", "CROON", "CROPS", "CRORE", "CROSS", "CROUP", "CROWD", "CROWN", "CROWS", "CROZE", "CRUCK", "CRUDE", "CRUDS",
            "CRUEL", "CRUET", "CRUMB", "CRUMP", "CRUOR", "CRURA", "CRUSE", "CRUSH", "CRUST", "CRWTH", "CRYPT", "CUBBY", "CUBEB", "CUBED", "CUBER", "CUBES", "CUBIC",
            "CUBIT", "CUDDY", "CUFFS", "CUIFS", "CUING", "CUISH", "CUKES", "CULCH", "CULET", "CULEX", "CULLS", "CULLY", "CULMS", "CULPA", "CULTI", "CULTS", "CUMIN",
            "CUNTS", "CUPEL", "CUPID", "CUPPA", "CUPPY", "CURBS", "CURCH", "CURDS", "CURDY", "CURED", "CURER", "CURES", "CURET", "CURFS", "CURIA", "CURIE", "CURIO",
            "CURLS", "CURLY", "CURNS", "CURRS", "CURRY", "CURSE", "CURST", "CURVE", "CURVY", "CUSEC", "CUSHY", "CUSKS", "CUSPS", "CUSSO", "CUTCH", "CUTER", "CUTES",
            "CUTEY", "CUTIE", "CUTIN", "CUTIS", "CUTTY", "CUTUP", "CYANO", "CYANS", "CYCAD", "CYCAS", "CYCLE", "CYCLO", "CYDER", "CYLIX", "CYMAE", "CYMAR", "CYMAS",
            "CYMES", "CYMOL", "CYNIC", "CYSTS", "CYTON", "CZARS", "DACES", "DACHA", "DADAS", "DADDY", "DADOS", "DAFFS", "DAFFY", "DAGGA", "DAGOS", "DAHLS", "DAILY",
            "DAIRY", "DAISY", "DALES", "DALLY", "DAMAN", "DAMAR", "DAMES", "DAMNS", "DAMPS", "DANCE", "DANDY", "DANGS", "DANIO", "DARBS", "DARED", "DARER", "DARES",
            "DARIC", "DARKS", "DARKY", "DARNS", "DARTS", "DASHI", "DASHY", "DATED", "DATER", "DATES", "DATOS", "DATTO", "DATUM", "DAUBE", "DAUBS", "DAUBY", "DAUNT",
            "DAUTS", "DAVEN", "DAVIT", "DAWED", "DAWEN", "DAWKS", "DAWNS", "DAWTS", "DAZED", "DAZES", "DEADS", "DEAIR", "DEALS", "DEALT", "DEANS", "DEARS", "DEARY",
            "DEASH", "DEATH", "DEAVE", "DEBAR", "DEBIT", "DEBTS", "DEBUG", "DEBUT", "DEBYE", "DECAF", "DECAL", "DECAY", "DECKS", "DECOR", "DECOS", "DECOY", "DECRY",
            "DEDAL", "DEEDS", "DEEDY", "DEEMS", "DEEPS", "DEERS", "DEETS", "DEFAT", "DEFER", "DEFIS", "DEFOG", "DEGAS", "DEGUM", "DEICE", "DEIFY", "DEIGN", "DEILS",
            "DEISM", "DEIST", "DEITY", "DEKED", "DEKES", "DEKKO", "DELAY", "DELED", "DELES", "DELFS", "DELFT", "DELIS", "DELLS", "DELLY", "DELTA", "DELTS", "DELVE",
            "DEMES", "DEMIT", "DEMOB", "DEMON", "DEMOS", "DEMUR", "DENAR", "DENES", "DENIM", "DENSE", "DENTS", "DEOXY", "DEPOT", "DEPTH", "DERAT", "DERAY", "DERBY",
            "DERMA", "DERMS", "DERRY", "DESEX", "DESKS", "DETER", "DETOX", "DEUCE", "DEVAS", "DEVEL", "DEVIL", "DEVON", "DEWAN", "DEWAR", "DEWAX", "DEWED", "DEXES",
            "DEXIE", "DHAKS", "DHALS", "DHOBI", "DHOLE", "DHOTI", "DHOWS", "DHUTI", "DIALS", "DIARY", "DIAZO", "DICED", "DICER", "DICES", "DICEY", "DICKS", "DICKY",
            "DICOT", "DICTA", "DICTY", "DIDIE", "DIDOS", "DIDST", "DIENE", "DIETS", "DIGHT", "DIGIT", "DIKED", "DIKER", "DIKES", "DIKEY", "DILDO", "DILLS", "DILLY",
            "DIMER", "DIMES", "DIMLY", "DINAR", "DINED", "DINER", "DINES", "DINGE", "DINGO", "DINGS", "DINGY", "DINKS", "DINKY", "DINTS", "DIODE", "DIOLS", "DIPPY",
            "DIPSO", "DIRER", "DIRGE", "DIRKS", "DIRLS", "DIRTS", "DIRTY", "DISCI", "DISCO", "DISCS", "DISHY", "DISKS", "DISME", "DITAS", "DITCH", "DITES", "DITSY",
            "DITTO", "DITTY", "DITZY", "DIVAN", "DIVAS", "DIVED", "DIVER", "DIVES", "DIVOT", "DIVVY", "DIWAN", "DIXIT", "DIZEN", "DIZZY", "DJINN", "DJINS", "DOATS",
            "DOBBY", "DOBIE", "DOBLA", "DOBRA", "DOBRO", "DOCKS", "DODGE", "DODGY", "DODOS", "DOERS", "DOEST", "DOETH", "DOFFS", "DOGES", "DOGEY", "DOGGO", "DOGGY",
            "DOGIE", "DOGMA", "DOILY", "DOING", "DOITS", "DOJOS", "DOLCE", "DOLCI", "DOLED", "DOLES", "DOLLS", "DOLLY", "DOLMA", "DOLOR", "DOLTS", "DOMAL", "DOMED",
            "DOMES", "DOMIC", "DONAS", "DONEE", "DONGA", "DONGS", "DONNA", "DONNE", "DONOR", "DONSY", "DONUT", "DOOLY", "DOOMS", "DOOMY", "DOORS", "DOOZY", "DOPAS",
            "DOPED", "DOPER", "DOPES", "DOPEY", "DORKS", "DORKY", "DORMS", "DORMY", "DORPS", "DORRS", "DORSA", "DORTY", "DOSED", "DOSER", "DOSES", "DOTAL", "DOTED",
            "DOTER", "DOTES", "DOTTY", "DOUBT", "DOUCE", "DOUGH", "DOUMA", "DOUMS", "DOURA", "DOUSE", "DOVEN", "DOVES", "DOWDY", "DOWED", "DOWEL", "DOWER", "DOWIE",
            "DOWNS", "DOWNY", "DOWRY", "DOWSE", "DOXIE", "DOYEN", "DOYLY", "DOZED", "DOZEN", "DOZER", "DOZES", "DRABS", "DRAFF", "DRAFT", "DRAGS", "DRAIL", "DRAIN",
            "DRAKE", "DRAMA", "DRAMS", "DRANK", "DRAPE", "DRATS", "DRAVE", "DRAWL", "DRAWN", "DRAWS", "DRAYS", "DREAD", "DREAM", "DREAR", "DRECK", "DREED", "DREES",
            "DREGS", "DREKS", "DRESS", "DREST", "DRIBS", "DRIED", "DRIER", "DRIES", "DRIFT", "DRILL", "DRILY", "DRINK", "DRIPS", "DRIPT", "DRIVE", "DROID", "DROIT",
            "DROLL", "DRONE", "DROOL", "DROOP", "DROPS", "DROPT", "DROSS", "DROUK", "DROVE", "DROWN", "DRUBS", "DRUGS", "DRUID", "DRUMS", "DRUNK", "DRUPE", "DRUSE",
            "DRYAD", "DRYER", "DRYLY", "DUADS", "DUALS", "DUCAL", "DUCAT", "DUCES", "DUCHY", "DUCKS", "DUCKY", "DUCTS", "DUDDY", "DUDED", "DUDES", "DUELS", "DUETS",
            "DUFFS", "DUITS", "DUKED", "DUKES", "DULIA", "DULLS", "DULLY", "DULSE", "DUMAS", "DUMBS", "DUMKA", "DUMKY", "DUMMY", "DUMPS", "DUMPY", "DUNAM", "DUNCE",
            "DUNCH", "DUNES", "DUNGS", "DUNGY", "DUNKS", "DUNTS", "DUOMI", "DUOMO", "DUPED", "DUPER", "DUPES", "DUPLE", "DURAL", "DURAS", "DURED", "DURES", "DURNS",
            "DUROC", "DUROS", "DURRA", "DURRS", "DURST", "DURUM", "DUSKS", "DUSKY", "DUSTS", "DUSTY", "DUTCH", "DUVET", "DWARF", "DWEEB", "DWELL", "DWELT", "DWINE",
            "DYADS", "DYERS", "DYING", "DYKED", "DYKES", "DYKEY", "DYNEL", "DYNES", "EAGER", "EAGLE", "EAGRE", "EARED", "EARLS", "EARLY", "EARNS", "EARTH", "EASED",
            "EASEL", "EASES", "EASTS", "EATEN", "EATER", "EAVED", "EAVES", "EBBED", "EBBET", "EBONS", "EBONY", "ECHED", "ECHES", "ECHOS", "ECLAT", "ECRUS", "EDEMA",
            "EDGED", "EDGER", "EDGES", "EDICT", "EDIFY", "EDILE", "EDITS", "EDUCE", "EDUCT", "EERIE", "EGADS", "EGERS", "EGEST", "EGGAR", "EGGED", "EGGER", "EGRET",
            "EIDER", "EIDOS", "EIGHT", "EIKON", "EJECT", "EKING", "ELAIN", "ELAND", "ELANS", "ELATE", "ELBOW", "ELDER", "ELECT", "ELEGY", "ELEMI", "ELFIN", "ELIDE",
            "ELINT", "ELITE", "ELOIN", "ELOPE", "ELUDE", "ELUTE", "ELVER", "ELVES", "EMAIL", "EMBAR", "EMBAY", "EMBED", "EMBER", "EMBOW", "EMCEE", "EMEER", "EMEND",
            "EMERY", "EMEUS", "EMIRS", "EMITS", "EMMER", "EMMET", "EMOTE", "EMPTY", "EMYDE", "EMYDS", "ENACT", "ENATE", "ENDED", "ENDER", "ENDOW", "ENDUE", "ENEMA",
            "ENEMY", "ENJOY", "ENNUI", "ENOKI", "ENOLS", "ENORM", "ENOWS", "ENROL", "ENSKY", "ENSUE", "ENTER", "ENTIA", "ENTRY", "ENURE", "ENVOI", "ENVOY", "ENZYM",
            "EOSIN", "EPACT", "EPEES", "EPHAH", "EPHAS", "EPHOD", "EPHOR", "EPICS", "EPOCH", "EPODE", "EPOXY", "EQUAL", "EQUID", "EQUIP", "ERASE", "ERECT", "ERGOT",
            "ERICA", "ERNES", "ERODE", "EROSE", "ERRED", "ERROR", "ERSES", "ERUCT", "ERUGO", "ERUPT", "ERVIL", "ESCAR", "ESCOT", "ESKAR", "ESKER", "ESSAY", "ESSES",
            "ESTER", "ESTOP", "ETAPE", "ETHER", "ETHIC", "ETHOS", "ETHYL", "ETNAS", "ETUDE", "ETUIS", "ETWEE", "ETYMA", "EUROS", "EVADE", "EVENS", "EVENT", "EVERT",
            "EVERY", "EVICT", "EVILS", "EVITE", "EVOKE", "EWERS", "EXACT", "EXALT", "EXAMS", "EXCEL", "EXECS", "EXERT", "EXILE", "EXINE", "EXIST", "EXITS", "EXONS",
            "EXPAT", "EXPEL", "EXPOS", "EXTOL", "EXTRA", "EXUDE", "EXULT", "EXURB", "EYERS", "EYING", "EYRAS", "EYRES", "EYRIE", "EYRIR", "FABLE", "FACED", "FACER",
            "FACES", "FACET", "FACIA", "FACTS", "FADDY", "FADED", "FADER", "FADES", "FADGE", "FADOS", "FAENA", "FAERY", "FAGGY", "FAGIN", "FAGOT", "FAILS", "FAINT",
            "FAIRS", "FAIRY", "FAITH", "FAKED", "FAKER", "FAKES", "FAKEY", "FAKIR", "FALLS", "FALSE", "FAMED", "FAMES", "FANCY", "FANES", "FANGA", "FANGS", "FANNY",
            "FANON", "FANOS", "FANUM", "FAQIR", "FARAD", "FARCE", "FARCI", "FARCY", "FARDS", "FARED", "FARER", "FARES", "FARLE", "FARLS", "FARMS", "FAROS", "FARTS",
            "FASTS", "FATAL", "FATED", "FATES", "FATLY", "FATSO", "FATTY", "FATWA", "FAUGH", "FAULD", "FAULT", "FAUNA", "FAUNS", "FAUVE", "FAVAS", "FAVES", "FAVOR",
            "FAVUS", "FAWNS", "FAWNY", "FAXED", "FAXES", "FAYED", "FAZED", "FAZES", "FEARS", "FEASE", "FEAST", "FEATS", "FEAZE", "FECAL", "FECES", "FECKS", "FEEDS",
            "FEELS", "FEEZE", "FEIGN", "FEINT", "FEIST", "FELID", "FELLA", "FELLS", "FELLY", "FELON", "FELTS", "FEMES", "FEMME", "FEMUR", "FENCE", "FENDS", "FENNY",
            "FEODS", "FEOFF", "FERAL", "FERES", "FERIA", "FERLY", "FERMI", "FERNS", "FERNY", "FERRY", "FESSE", "FETAL", "FETAS", "FETCH", "FETED", "FETES", "FETID",
            "FETOR", "FETUS", "FEUAR", "FEUDS", "FEUED", "FEVER", "FEWER", "FEYER", "FEYLY", "FEZES", "FIARS", "FIATS", "FIBER", "FIBRE", "FICES", "FICHE", "FICHU",
            "FICIN", "FICUS", "FIDGE", "FIDOS", "FIEFS", "FIELD", "FIEND", "FIERY", "FIFED", "FIFER", "FIFES", "FIFTH", "FIFTY", "FIGHT", "FILAR", "FILCH", "FILED",
            "FILER", "FILES", "FILET", "FILLE", "FILLO", "FILLS", "FILLY", "FILMS", "FILMY", "FILOS", "FILTH", "FILUM", "FINAL", "FINCH", "FINDS", "FINED", "FINER",
            "FINES", "FINIS", "FINKS", "FINNY", "FINOS", "FIORD", "FIQUE", "FIRED", "FIRER", "FIRES", "FIRMS", "FIRNS", "FIRRY", "FIRST", "FIRTH", "FISCS", "FISHY",
            "FISTS", "FITCH", "FITLY", "FIVER", "FIVES", "FIXED", "FIXER", "FIXES", "FIXIT", "FIZZY", "FJELD", "FJORD", "FLABS", "FLACK", "FLAGS", "FLAIL", "FLAIR",
            "FLAKE", "FLAKY", "FLAME", "FLAMS", "FLAMY", "FLANK", "FLANS", "FLAPS", "FLARE", "FLASH", "FLASK", "FLATS", "FLAWS", "FLAWY", "FLAXY", "FLAYS", "FLEAM",
            "FLEAS", "FLECK", "FLEER", "FLEES", "FLEET", "FLESH", "FLEWS", "FLEYS", "FLICK", "FLICS", "FLIED", "FLIER", "FLIES", "FLING", "FLINT", "FLIPS", "FLIRT",
            "FLITE", "FLITS", "FLOAT", "FLOCK", "FLOCS", "FLOES", "FLOGS", "FLONG", "FLOOD", "FLOOR", "FLOPS", "FLORA", "FLOSS", "FLOTA", "FLOUR", "FLOUT", "FLOWN",
            "FLOWS", "FLUBS", "FLUED", "FLUES", "FLUFF", "FLUID", "FLUKE", "FLUKY", "FLUME", "FLUMP", "FLUNG", "FLUNK", "FLUOR", "FLUSH", "FLUTE", "FLUTY", "FLUYT",
            "FLYBY", "FLYER", "FLYTE", "FOALS", "FOAMS", "FOAMY", "FOCAL", "FOCUS", "FOEHN", "FOGEY", "FOGGY", "FOGIE", "FOHNS", "FOILS", "FOINS", "FOIST", "FOLDS",
            "FOLIA", "FOLIO", "FOLKS", "FOLKY", "FOLLY", "FONDS", "FONDU", "FONTS", "FOODS", "FOOLS", "FOOTS", "FOOTY", "FORAM", "FORAY", "FORBS", "FORBY", "FORCE",
            "FORDO", "FORDS", "FORES", "FORGE", "FORGO", "FORKS", "FORKY", "FORME", "FORMS", "FORTE", "FORTH", "FORTS", "FORTY", "FORUM", "FOSSA", "FOSSE", "FOULS",
            "FOUND", "FOUNT", "FOURS", "FOVEA", "FOWLS", "FOXED", "FOXES", "FOYER", "FRAGS", "FRAIL", "FRAME", "FRANC", "FRANK", "FRAPS", "FRASS", "FRATS", "FRAUD",
            "FRAYS", "FREAK", "FREED", "FREER", "FREES", "FREMD", "FRENA", "FRERE", "FRESH", "FRETS", "FRIAR", "FRIED", "FRIER", "FRIES", "FRIGS", "FRILL", "FRISE",
            "FRISK", "FRITH", "FRITS", "FRITT", "FRITZ", "FRIZZ", "FROCK", "FROES", "FROGS", "FROND", "FRONS", "FRONT", "FRORE", "FROSH", "FROST", "FROTH", "FROWN",
            "FROWS", "FROZE", "FRUGS", "FRUIT", "FRUMP", "FRYER", "FUBSY", "FUCKS", "FUCUS", "FUDGE", "FUELS", "FUGAL", "FUGGY", "FUGIO", "FUGLE", "FUGUE", "FUGUS",
            "FUJIS", "FULLS", "FULLY", "FUMED", "FUMER", "FUMES", "FUMET", "FUNDI", "FUNDS", "FUNGI", "FUNGO", "FUNKS", "FUNKY", "FUNNY", "FURAN", "FURLS", "FUROR",
            "FURRY", "FURZE", "FURZY", "FUSED", "FUSEE", "FUSEL", "FUSES", "FUSIL", "FUSSY", "FUSTY", "FUTON", "FUZED", "FUZEE", "FUZES", "FUZIL", "FUZZY", "FYCES",
            "FYKES", "FYTTE", "GABBY", "GABLE", "GADDI", "GADID", "GADIS", "GAFFE", "GAFFS", "GAGED", "GAGER", "GAGES", "GAILY", "GAINS", "GAITS", "GALAH", "GALAS",
            "GALAX", "GALEA", "GALES", "GALLS", "GALLY", "GALOP", "GAMAS", "GAMAY", "GAMBA", "GAMBE", "GAMBS", "GAMED", "GAMER", "GAMES", "GAMEY", "GAMIC", "GAMIN",
            "GAMMA", "GAMMY", "GAMPS", "GAMUT", "GANEF", "GANEV", "GANGS", "GANJA", "GANOF", "GAOLS", "GAPED", "GAPER", "GAPES", "GAPPY", "GARBS", "GARNI", "GARTH",
            "GASES", "GASPS", "GASSY", "GASTS", "GATED", "GATES", "GATOR", "GAUDS", "GAUDY", "GAUGE", "GAULT", "GAUMS", "GAUNT", "GAURS", "GAUSS", "GAUZE", "GAUZY",
            "GAVEL", "GAVOT", "GAWKS", "GAWKY", "GAWPS", "GAWSY", "GAYAL", "GAYER", "GAYLY", "GAZAR", "GAZED", "GAZER", "GAZES", "GAZOO", "GEARS", "GECKO", "GECKS",
            "GEEKS", "GEEKY", "GEESE", "GEEST", "GELDS", "GELEE", "GELID", "GELTS", "GEMMA", "GEMMY", "GEMOT", "GENES", "GENET", "GENIC", "GENIE", "GENII", "GENIP",
            "GENOA", "GENOM", "GENRE", "GENRO", "GENTS", "GENUA", "GENUS", "GEODE", "GEOID", "GERAH", "GERMS", "GERMY", "GESSO", "GESTE", "GESTS", "GETAS", "GETUP",
            "GEUMS", "GHAST", "GHATS", "GHAUT", "GHAZI", "GHEES", "GHOST", "GHOUL", "GHYLL", "GIANT", "GIBED", "GIBER", "GIBES", "GIDDY", "GIFTS", "GIGAS", "GIGHE",
            "GIGOT", "GIGUE", "GILDS", "GILLS", "GILLY", "GILTS", "GIMEL", "GIMME", "GIMPS", "GIMPY", "GINKS", "GINNY", "GIPON", "GIPSY", "GIRDS", "GIRLS", "GIRLY",
            "GIRNS", "GIRON", "GIROS", "GIRSH", "GIRTH", "GIRTS", "GISMO", "GISTS", "GIVEN", "GIVER", "GIVES", "GIZMO", "GLACE", "GLADE", "GLADS", "GLADY", "GLAIR",
            "GLAND", "GLANS", "GLARE", "GLARY", "GLASS", "GLAZE", "GLAZY", "GLEAM", "GLEAN", "GLEBA", "GLEBE", "GLEDE", "GLEDS", "GLEED", "GLEEK", "GLEES", "GLEET",
            "GLENS", "GLEYS", "GLIAL", "GLIAS", "GLIDE", "GLIFF", "GLIME", "GLIMS", "GLINT", "GLITZ", "GLOAM", "GLOAT", "GLOBE", "GLOBS", "GLOGG", "GLOMS", "GLOOM",
            "GLOPS", "GLORY", "GLOSS", "GLOST", "GLOUT", "GLOVE", "GLOWS", "GLOZE", "GLUED", "GLUER", "GLUES", "GLUEY", "GLUGS", "GLUME", "GLUON", "GLUTS", "GLYPH",
            "GNARL", "GNARR", "GNARS", "GNASH", "GNATS", "GNAWN", "GNAWS", "GNOME", "GOADS", "GOALS", "GOATS", "GOBAN", "GOBOS", "GODET", "GODLY", "GOERS", "GOFER",
            "GOGOS", "GOING", "GOLDS", "GOLEM", "GOLFS", "GOLLY", "GOMBO", "GONAD", "GONEF", "GONER", "GONGS", "GONIA", "GONIF", "GONOF", "GONZO", "GOODS", "GOODY",
            "GOOEY", "GOOFS", "GOOFY", "GOOKS", "GOOKY", "GOONS", "GOONY", "GOOPS", "GOOPY", "GOOSE", "GOOSY", "GOPIK", "GORAL", "GORED", "GORES", "GORGE", "GORPS",
            "GORSE", "GORSY", "GOUGE", "GOURD", "GOUTS", "GOUTY", "GOWAN", "GOWDS", "GOWKS", "GOWNS", "GOXES", "GOYIM", "GRAAL", "GRABS", "GRACE", "GRADE", "GRADS",
            "GRAFT", "GRAIL", "GRAIN", "GRAMA", "GRAMP", "GRAMS", "GRANA", "GRAND", "GRANS", "GRANT", "GRAPE", "GRAPH", "GRAPY", "GRASP", "GRASS", "GRATE", "GRAVE",
            "GRAVY", "GRAYS", "GRAZE", "GREAT", "GREBE", "GREED", "GREEK", "GREEN", "GREES", "GREET", "GREGO", "GREYS", "GRIDE", "GRIDS", "GRIEF", "GRIFF", "GRIFT",
            "GRIGS", "GRILL", "GRIME", "GRIMY", "GRIND", "GRINS", "GRIOT", "GRIPE", "GRIPS", "GRIPT", "GRIPY", "GRIST", "GRITH", "GRITS", "GROAN", "GROAT", "GRODY",
            "GROGS", "GROIN", "GROOM", "GROPE", "GROSS", "GROSZ", "GROTS", "GROUP", "GROUT", "GROVE", "GROWL", "GROWN", "GROWS", "GRUBS", "GRUEL", "GRUES", "GRUFF",
            "GRUME", "GRUMP", "GRUNT", "GUACO", "GUANO", "GUANS", "GUARD", "GUARS", "GUAVA", "GUCKS", "GUDES", "GUESS", "GUEST", "GUFFS", "GUIDE", "GUIDS", "GUILD",
            "GUILE", "GUILT", "GUIRO", "GUISE", "GULAG", "GULAR", "GULCH", "GULES", "GULFS", "GULFY", "GULLS", "GULLY", "GULPS", "GULPY", "GUMBO", "GUMMA", "GUMMY",
            "GUNKS", "GUNKY", "GUNNY", "GUPPY", "GURGE", "GURRY", "GURSH", "GURUS", "GUSHY", "GUSSY", "GUSTO", "GUSTS", "GUSTY", "GUTSY", "GUTTA", "GUTTY", "GUYED",
            "GUYOT", "GYBED", "GYBES", "GYPSY", "GYRAL", "GYRED", "GYRES", "GYRON", "GYROS", "GYRUS", "GYVED", "GYVES", "HAAFS", "HAARS", "HABIT", "HABUS", "HACEK",
            "HACKS", "HADAL", "HADED", "HADES", "HADJI", "HADST", "HAEMS", "HAETS", "HAFIS", "HAFIZ", "HAFTS", "HAHAS", "HAIKA", "HAIKS", "HAIKU", "HAILS", "HAIRS",
            "HAIRY", "HAJES", "HAJIS", "HAJJI", "HAKES", "HAKIM", "HALED", "HALER", "HALES", "HALID", "HALLO", "HALLS", "HALMA", "HALMS", "HALOS", "HALTS", "HALVA",
            "HALVE", "HAMAL", "HAMES", "HAMMY", "HAMZA", "HANCE", "HANDS", "HANDY", "HANGS", "HANKS", "HANKY", "HANSA", "HANSE", "HANTS", "HAOLE", "HAPAX", "HAPLY",
            "HAPPY", "HARDS", "HARDY", "HARED", "HAREM", "HARES", "HARKS", "HARLS", "HARMS", "HARPS", "HARPY", "HARRY", "HARSH", "HARTS", "HASPS", "HASTE", "HASTY",
            "HATCH", "HATED", "HATER", "HATES", "HAUGH", "HAULM", "HAULS", "HAUNT", "HAUTE", "HAVEN", "HAVER", "HAVES", "HAVOC", "HAWED", "HAWKS", "HAWSE", "HAYED",
            "HAYER", "HAZAN", "HAZED", "HAZEL", "HAZER", "HAZES", "HEADS", "HEADY", "HEALS", "HEAPS", "HEARD", "HEARS", "HEART", "HEATH", "HEATS", "HEAVE", "HEAVY",
            "HEBES", "HECKS", "HEDER", "HEDGE", "HEDGY", "HEEDS", "HEELS", "HEEZE", "HEFTS", "HEFTY", "HEIGH", "HEILS", "HEIRS", "HEIST", "HELIO", "HELIX", "HELLO",
            "HELLS", "HELMS", "HELOS", "HELOT", "HELPS", "HELVE", "HEMAL", "HEMES", "HEMIC", "HEMIN", "HEMPS", "HEMPY", "HENCE", "HENNA", "HENRY", "HENTS", "HERBS",
            "HERBY", "HERDS", "HERES", "HERLS", "HERMA", "HERMS", "HERNS", "HERON", "HEROS", "HERRY", "HERTZ", "HESTS", "HETHS", "HEUCH", "HEUGH", "HEWED", "HEWER",
            "HEXAD", "HEXED", "HEXER", "HEXES", "HEXYL", "HICKS", "HIDED", "HIDER", "HIDES", "HIGHS", "HIGHT", "HIKED", "HIKER", "HIKES", "HILAR", "HILLO", "HILLS",
            "HILLY", "HILTS", "HILUM", "HILUS", "HINDS", "HINGE", "HINNY", "HINTS", "HIPPO", "HIPPY", "HIRED", "HIRER", "HIRES", "HISSY", "HISTS", "HITCH", "HIVED",
            "HIVES", "HOAGY", "HOARD", "HOARS", "HOARY", "HOBBY", "HOBOS", "HOCKS", "HOCUS", "HODAD", "HOERS", "HOGAN", "HOGGS", "HOICK", "HOISE", "HOIST", "HOKED",
            "HOKES", "HOKEY", "HOKKU", "HOKUM", "HOLDS", "HOLED", "HOLES", "HOLEY", "HOLKS", "HOLLA", "HOLLO", "HOLLY", "HOLMS", "HOLTS", "HOMED", "HOMER", "HOMES",
            "HOMEY", "HOMOS", "HONAN", "HONDA", "HONED", "HONER", "HONES", "HONEY", "HONGS", "HONKS", "HONKY", "HONOR", "HOOCH", "HOODS", "HOODY", "HOOEY", "HOOFS",
            "HOOKA", "HOOKS", "HOOKY", "HOOLY", "HOOPS", "HOOTS", "HOOTY", "HOPED", "HOPER", "HOPES", "HOPPY", "HORAH", "HORAL", "HORAS", "HORDE", "HORNS", "HORNY",
            "HORSE", "HORST", "HORSY", "HOSED", "HOSEL", "HOSEN", "HOSES", "HOSTA", "HOSTS", "HOTCH", "HOTEL", "HOTLY", "HOUND", "HOURI", "HOURS", "HOUSE", "HOVEL",
            "HOVER", "HOWDY", "HOWES", "HOWFF", "HOWFS", "HOWKS", "HOWLS", "HOYAS", "HOYLE", "HUBBY", "HUCKS", "HUFFS", "HUFFY", "HUGER", "HULAS", "HULKS", "HULKY",
            "HULLO", "HULLS", "HUMAN", "HUMIC", "HUMID", "HUMOR", "HUMPH", "HUMPS", "HUMPY", "HUMUS", "HUNCH", "HUNKS", "HUNKY", "HUNTS", "HURDS", "HURLS", "HURLY",
            "HURRY", "HURST", "HURTS", "HUSKS", "HUSKY", "HUSSY", "HUTCH", "HUZZA", "HYDRA", "HYDRO", "HYENA", "HYING", "HYLAS", "HYMEN", "HYMNS", "HYOID", "HYPED",
            "HYPER", "HYPES", "HYPHA", "HYPOS", "HYRAX", "HYSON", "IAMBI", "IAMBS", "ICHOR", "ICIER", "ICILY", "ICING", "ICKER", "ICONS", "ICTIC", "ICTUS", "IDEAL",
            "IDEAS", "IDIOM", "IDIOT", "IDLED", "IDLER", "IDLES", "IDOLS", "IDYLL", "IDYLS", "IGLOO", "IGLUS", "IHRAM", "IKATS", "IKONS", "ILEAC", "ILEAL", "ILEUM",
            "ILEUS", "ILIAC", "ILIAD", "ILIAL", "ILIUM", "ILLER", "IMAGE", "IMAGO", "IMAMS", "IMAUM", "IMBED", "IMBUE", "IMIDE", "IMIDO", "IMIDS", "IMINE", "IMINO",
            "IMMIX", "IMPED", "IMPEL", "IMPIS", "IMPLY", "INANE", "INAPT", "INARM", "INBYE", "INCOG", "INCUR", "INCUS", "INDEX", "INDIE", "INDOL", "INDOW", "INDRI",
            "INDUE", "INEPT", "INERT", "INFER", "INFIX", "INFOS", "INFRA", "INGLE", "INGOT", "INION", "INKED", "INKER", "INKLE", "INLAY", "INLET", "INNED", "INNER",
            "INPUT", "INSET", "INTER", "INTIS", "INTRO", "INURE", "INURN", "INVAR", "IODIC", "IODID", "IODIN", "IONIC", "IOTAS", "IRADE", "IRATE", "IRIDS", "IRING",
            "IRKED", "IROKO", "IRONE", "IRONS", "IRONY", "ISBAS", "ISLED", "ISLES", "ISLET", "ISSEI", "ISSUE", "ISTLE", "ITCHY", "ITEMS", "ITHER", "IVIED", "IVIES",
            "IVORY", "IXIAS", "IXORA", "IXTLE", "IZARS", "JABOT", "JACAL", "JACKS", "JACKY", "JADED", "JADES", "JAGER", "JAGGS", "JAGGY", "JAGRA", "JAILS", "JAKES",
            "JALAP", "JALOP", "JAMBE", "JAMBS", "JAMMY", "JANES", "JANTY", "JAPAN", "JAPED", "JAPER", "JAPES", "JARLS", "JATOS", "JAUKS", "JAUNT", "JAUPS", "JAVAS",
            "JAWAN", "JAWED", "JAZZY", "JEANS", "JEBEL", "JEEPS", "JEERS", "JEFES", "JEHAD", "JEHUS", "JELLS", "JELLY", "JEMMY", "JENNY", "JERID", "JERKS", "JERKY",
            "JERRY", "JESSE", "JESTS", "JETES", "JETON", "JETTY", "JEWED", "JEWEL", "JIBBS", "JIBED", "JIBER", "JIBES", "JIFFS", "JIFFY", "JIHAD", "JILLS", "JILTS",
            "JIMMY", "JIMPY", "JINGO", "JINKS", "JINNI", "JINNS", "JISMS", "JIVED", "JIVER", "JIVES", "JIVEY", "JNANA", "JOCKO", "JOCKS", "JOEYS", "JOHNS", "JOINS",
            "JOINT", "JOIST", "JOKED", "JOKER", "JOKES", "JOKEY", "JOLES", "JOLLY", "JOLTS", "JOLTY", "JONES", "JORAM", "JORUM", "JOTAS", "JOTTY", "JOUAL", "JOUKS",
            "JOULE", "JOUST", "JOWAR", "JOWED", "JOWLS", "JOWLY", "JOYED", "JUBAS", "JUBES", "JUDAS", "JUDGE", "JUDOS", "JUGAL", "JUGUM", "JUICE", "JUICY", "JUJUS",
            "JUKED", "JUKES", "JULEP", "JUMBO", "JUMPS", "JUMPY", "JUNCO", "JUNKS", "JUNKY", "JUNTA", "JUNTO", "JUPES", "JUPON", "JURAL", "JURAT", "JUREL", "JUROR",
            "JUSTS", "JUTES", "JUTTY", "KABAB", "KABAR", "KABOB", "KADIS", "KAFIR", "KAGUS", "KAIAK", "KAIFS", "KAILS", "KAINS", "KAKAS", "KAKIS", "KALAM", "KALES",
            "KALIF", "KALPA", "KAMES", "KAMIK", "KANAS", "KANES", "KANJI", "KAONS", "KAPAS", "KAPHS", "KAPOK", "KAPPA", "KAPUT", "KARAT", "KARMA", "KARNS", "KAROO",
            "KARST", "KARTS", "KASHA", "KATAS", "KAURI", "KAURY", "KAVAS", "KAYAK", "KAYOS", "KAZOO", "KBARS", "KEBAB", "KEBAR", "KEBOB", "KECKS", "KEDGE", "KEEFS",
            "KEEKS", "KEELS", "KEENS", "KEEPS", "KEETS", "KEEVE", "KEFIR", "KEIRS", "KELEP", "KELIM", "KELLY", "KELPS", "KELPY", "KEMPS", "KEMPT", "KENAF", "KENCH",
            "KENDO", "KENOS", "KEPIS", "KERBS", "KERFS", "KERNE", "KERNS", "KERRY", "KETCH", "KETOL", "KEVEL", "KEVIL", "KEXES", "KEYED", "KHADI", "KHAFS", "KHAKI",
            "KHANS", "KHAPH", "KHATS", "KHEDA", "KHETH", "KHETS", "KHOUM", "KIANG", "KIBBE", "KIBBI", "KIBEI", "KIBES", "KIBLA", "KICKS", "KICKY", "KIDDO", "KIDDY",
            "KIEFS", "KIERS", "KIKES", "KILIM", "KILLS", "KILNS", "KILOS", "KILTS", "KILTY", "KINAS", "KINDS", "KINES", "KINGS", "KININ", "KINKS", "KINKY", "KINOS",
            "KIOSK", "KIRKS", "KIRNS", "KISSY", "KISTS", "KITED", "KITER", "KITES", "KITHE", "KITHS", "KITTY", "KIVAS", "KIWIS", "KLONG", "KLOOF", "KLUGE", "KLUTZ",
            "KNACK", "KNAPS", "KNARS", "KNAUR", "KNAVE", "KNEAD", "KNEED", "KNEEL", "KNEES", "KNELL", "KNELT", "KNIFE", "KNISH", "KNITS", "KNOBS", "KNOCK", "KNOLL",
            "KNOPS", "KNOSP", "KNOTS", "KNOUT", "KNOWN", "KNOWS", "KNURL", "KNURS", "KOALA", "KOANS", "KOBOS", "KOELS", "KOHLS", "KOINE", "KOLAS", "KOLOS", "KONKS",
            "KOOKS", "KOOKY", "KOPEK", "KOPHS", "KOPJE", "KOPPA", "KORAI", "KORAT", "KORUN", "KOTOS", "KOTOW", "KRAAL", "KRAFT", "KRAIT", "KRAUT", "KREEP", "KRILL",
            "KRONA", "KRONE", "KROON", "KRUBI", "KUDOS", "KUDUS", "KUDZU", "KUGEL", "KUKRI", "KULAK", "KUMYS", "KURTA", "KURUS", "KUSSO", "KVASS", "KYACK", "KYAKS",
            "KYARS", "KYATS", "KYLIX", "KYRIE", "KYTES", "KYTHE", "LAARI", "LABEL", "LABIA", "LABOR", "LABRA", "LACED", "LACER", "LACES", "LACEY", "LACKS", "LADED",
            "LADEN", "LADER", "LADES", "LADLE", "LAEVO", "LAGAN", "LAGER", "LAHAR", "LAICH", "LAICS", "LAIGH", "LAIRD", "LAIRS", "LAITH", "LAITY", "LAKED", "LAKER",
            "LAKES", "LAKHS", "LALLS", "LAMAS", "LAMBS", "LAMBY", "LAMED", "LAMER", "LAMES", "LAMIA", "LAMPS", "LANAI", "LANCE", "LANDS", "LANES", "LANKY", "LAPEL",
            "LAPIN", "LAPIS", "LAPSE", "LARCH", "LARDS", "LARDY", "LAREE", "LARES", "LARGE", "LARGO", "LARIS", "LARKS", "LARKY", "LARUM", "LARVA", "LASED", "LASER",
            "LASES", "LASSO", "LASTS", "LATCH", "LATED", "LATEN", "LATER", "LATEX", "LATHE", "LATHI", "LATHS", "LATHY", "LATKE", "LATTE", "LAUAN", "LAUDS", "LAUGH",
            "LAURA", "LAVAS", "LAVED", "LAVER", "LAVES", "LAWED", "LAWNS", "LAWNY", "LAXER", "LAXLY", "LAYED", "LAYER", "LAYUP", "LAZAR", "LAZED", "LAZES", "LEACH",
            "LEADS", "LEADY", "LEAFS", "LEAFY", "LEAKS", "LEAKY", "LEANS", "LEANT", "LEAPS", "LEAPT", "LEARN", "LEARS", "LEARY", "LEASE", "LEASH", "LEAST", "LEAVE",
            "LEAVY", "LEBEN", "LEDGE", "LEDGY", "LEECH", "LEEKS", "LEERS", "LEERY", "LEETS", "LEFTS", "LEFTY", "LEGAL", "LEGER", "LEGES", "LEGGY", "LEGIT", "LEHRS",
            "LEHUA", "LEMAN", "LEMMA", "LEMON", "LEMUR", "LENDS", "LENES", "LENIS", "LENOS", "LENSE", "LENTO", "LEONE", "LEPER", "LEPTA", "LETCH", "LETHE", "LETUP",
            "LEUDS", "LEVEE", "LEVEL", "LEVER", "LEVIN", "LEWIS", "LEXES", "LEXIS", "LEZZY", "LIANA", "LIANE", "LIANG", "LIARD", "LIARS", "LIBEL", "LIBER", "LIBRA",
            "LIBRI", "LICHI", "LICHT", "LICIT", "LICKS", "LIDAR", "LIDOS", "LIEGE", "LIENS", "LIERS", "LIEUS", "LIEVE", "LIFER", "LIFTS", "LIGAN", "LIGER", "LIGHT",
            "LIKED", "LIKEN", "LIKER", "LIKES", "LILAC", "LILTS", "LIMAN", "LIMAS", "LIMBA", "LIMBI", "LIMBO", "LIMBS", "LIMBY", "LIMED", "LIMEN", "LIMES", "LIMEY",
            "LIMIT", "LIMNS", "LIMOS", "LIMPA", "LIMPS", "LINAC", "LINDY", "LINED", "LINEN", "LINER", "LINES", "LINEY", "LINGA", "LINGO", "LINGS", "LINGY", "LININ",
            "LINKS", "LINKY", "LINNS", "LINOS", "LINTS", "LINTY", "LINUM", "LIONS", "LIPID", "LIPIN", "LIPPY", "LIRAS", "LIROT", "LISLE", "LISPS", "LISTS", "LITAI",
            "LITAS", "LITER", "LITHE", "LITHO", "LITRE", "LIVED", "LIVEN", "LIVER", "LIVES", "LIVID", "LIVRE", "LLAMA", "LLANO", "LOACH", "LOADS", "LOAFS", "LOAMS",
            "LOAMY", "LOANS", "LOATH", "LOBAR", "LOBBY", "LOBED", "LOBES", "LOBOS", "LOCAL", "LOCHS", "LOCKS", "LOCOS", "LOCUM", "LOCUS", "LODEN", "LODES", "LODGE",
            "LOESS", "LOFTS", "LOFTY", "LOGAN", "LOGES", "LOGGY", "LOGIA", "LOGIC", "LOGOI", "LOGOS", "LOINS", "LOLLS", "LOLLY", "LONER", "LONGE", "LONGS", "LOOBY",
            "LOOED", "LOOEY", "LOOFA", "LOOFS", "LOOIE", "LOOKS", "LOOMS", "LOONS", "LOONY", "LOOPS", "LOOPY", "LOOSE", "LOOTS", "LOPED", "LOPER", "LOPES", "LOPPY",
            "LORAL", "LORAN", "LORDS", "LORES", "LORIS", "LORRY", "LOSEL", "LOSER", "LOSES", "LOSSY", "LOTAH", "LOTAS", "LOTIC", "LOTOS", "LOTTE", "LOTTO", "LOTUS",
            "LOUGH", "LOUIE", "LOUIS", "LOUPE", "LOUPS", "LOURS", "LOURY", "LOUSE", "LOUSY", "LOUTS", "LOVAT", "LOVED", "LOVER", "LOVES", "LOWED", "LOWER", "LOWES",
            "LOWLY", "LOWSE", "LOXED", "LOXES", "LOYAL", "LUAUS", "LUBED", "LUBES", "LUCES", "LUCID", "LUCKS", "LUCKY", "LUCRE", "LUDES", "LUDIC", "LUFFA", "LUFFS",
            "LUGED", "LUGER", "LUGES", "LULLS", "LULUS", "LUMEN", "LUMPS", "LUMPY", "LUNAR", "LUNAS", "LUNCH", "LUNES", "LUNET", "LUNGE", "LUNGI", "LUNGS", "LUNKS",
            "LUNTS", "LUPIN", "LUPUS", "LURCH", "LURED", "LURER", "LURES", "LURID", "LURKS", "LUSTS", "LUSTY", "LUSUS", "LUTEA", "LUTED", "LUTES", "LUXES", "LWEIS",
            "LYARD", "LYART", "LYASE", "LYCEA", "LYCEE", "LYING", "LYMPH", "LYNCH", "LYRES", "LYRIC", "LYSED", "LYSES", "LYSIN", "LYSIS", "LYSSA", "LYTIC", "LYTTA",
            "MAARS", "MABES", "MACAW", "MACED", "MACER", "MACES", "MACHE", "MACHO", "MACHS", "MACKS", "MACLE", "MACON", "MACRO", "MADAM", "MADLY", "MADRE", "MAFIA",
            "MAFIC", "MAGES", "MAGIC", "MAGMA", "MAGOT", "MAGUS", "MAHOE", "MAIDS", "MAILE", "MAILL", "MAILS", "MAIMS", "MAINS", "MAIRS", "MAIST", "MAIZE", "MAJOR",
            "MAKAR", "MAKER", "MAKES", "MAKOS", "MALAR", "MALES", "MALIC", "MALLS", "MALMS", "MALMY", "MALTS", "MALTY", "MAMAS", "MAMBA", "MAMBO", "MAMEY", "MAMIE",
            "MAMMA", "MAMMY", "MANAS", "MANAT", "MANED", "MANES", "MANGE", "MANGO", "MANGY", "MANIA", "MANIC", "MANLY", "MANNA", "MANOR", "MANOS", "MANSE", "MANTA",
            "MANUS", "MAPLE", "MAQUI", "MARCH", "MARCS", "MARES", "MARGE", "MARIA", "MARKS", "MARLS", "MARLY", "MARRY", "MARSE", "MARSH", "MARTS", "MARVY", "MASER",
            "MASHY", "MASKS", "MASON", "MASSA", "MASSE", "MASSY", "MASTS", "MATCH", "MATED", "MATER", "MATES", "MATEY", "MATHS", "MATIN", "MATTE", "MATTS", "MATZA",
            "MATZO", "MAUDS", "MAULS", "MAUND", "MAUTS", "MAUVE", "MAVEN", "MAVIE", "MAVIN", "MAVIS", "MAWED", "MAXES", "MAXIM", "MAXIS", "MAYAN", "MAYAS", "MAYBE",
            "MAYED", "MAYOR", "MAYOS", "MAYST", "MAZED", "MAZER", "MAZES", "MBIRA", "MEADS", "MEALS", "MEALY", "MEANS", "MEANT", "MEANY", "MEATS", "MEATY", "MECCA",
            "MEDAL", "MEDIA", "MEDIC", "MEDII", "MEEDS", "MEETS", "MEINY", "MELDS", "MELEE", "MELIC", "MELLS", "MELON", "MELTS", "MEMES", "MEMOS", "MENAD", "MENDS",
            "MENSA", "MENSE", "MENTA", "MENUS", "MEOUS", "MEOWS", "MERCY", "MERDE", "MERER", "MERES", "MERGE", "MERIT", "MERKS", "MERLE", "MERLS", "MERRY", "MESAS",
            "MESHY", "MESIC", "MESNE", "MESON", "MESSY", "METAL", "METED", "METER", "METES", "METHS", "METIS", "METRE", "METRO", "MEWED", "MEWLS", "MEZES", "MEZZO",
            "MIAOU", "MIAOW", "MIASM", "MIAUL", "MICAS", "MICHE", "MICKS", "MICRA", "MICRO", "MIDDY", "MIDGE", "MIDIS", "MIDST", "MIENS", "MIFFS", "MIFFY", "MIGGS",
            "MIGHT", "MIKED", "MIKES", "MIKRA", "MILCH", "MILER", "MILES", "MILIA", "MILKS", "MILKY", "MILLE", "MILLS", "MILOS", "MILPA", "MILTS", "MILTY", "MIMED",
            "MIMEO", "MIMER", "MIMES", "MIMIC", "MINAE", "MINAS", "MINCE", "MINCY", "MINDS", "MINED", "MINER", "MINES", "MINGY", "MINIM", "MINIS", "MINKE", "MINKS",
            "MINNY", "MINOR", "MINTS", "MINTY", "MINUS", "MIRED", "MIRES", "MIREX", "MIRKS", "MIRKY", "MIRTH", "MIRZA", "MISDO", "MISER", "MISES", "MISOS", "MISSY",
            "MISTS", "MISTY", "MITER", "MITES", "MITIS", "MITRE", "MITTS", "MIXED", "MIXER", "MIXES", "MIXUP", "MIZEN", "MOANS", "MOATS", "MOCHA", "MOCKS", "MODAL",
            "MODEL", "MODEM", "MODES", "MODUS", "MOGGY", "MOGUL", "MOHEL", "MOHUR", "MOILS", "MOIRA", "MOIRE", "MOIST", "MOJOS", "MOKES", "MOLAL", "MOLAR", "MOLAS",
            "MOLDS", "MOLDY", "MOLES", "MOLLS", "MOLLY", "MOLTO", "MOLTS", "MOMES", "MOMMA", "MOMMY", "MOMUS", "MONAD", "MONAS", "MONDE", "MONDO", "MONEY", "MONGO",
            "MONIE", "MONKS", "MONOS", "MONTE", "MONTH", "MOOCH", "MOODS", "MOODY", "MOOED", "MOOLA", "MOOLS", "MOONS", "MOONY", "MOORS", "MOORY", "MOOSE", "MOOTS",
            "MOPED", "MOPER", "MOPES", "MOPEY", "MORAE", "MORAL", "MORAS", "MORAY", "MOREL", "MORES", "MORNS", "MORON", "MORPH", "MORRO", "MORSE", "MORTS", "MOSEY",
            "MOSKS", "MOSSO", "MOSSY", "MOSTE", "MOSTS", "MOTEL", "MOTES", "MOTET", "MOTEY", "MOTHS", "MOTHY", "MOTIF", "MOTOR", "MOTTE", "MOTTO", "MOTTS", "MOUCH",
            "MOUES", "MOULD", "MOULT", "MOUND", "MOUNT", "MOURN", "MOUSE", "MOUSY", "MOUTH", "MOVED", "MOVER", "MOVES", "MOVIE", "MOWED", "MOWER", "MOXAS", "MOXIE",
            "MOZOS", "MUCID", "MUCIN", "MUCKS", "MUCKY", "MUCOR", "MUCRO", "MUCUS", "MUDDY", "MUDRA", "MUFFS", "MUFTI", "MUGGS", "MUGGY", "MUHLY", "MUJIK", "MULCH",
            "MULCT", "MULED", "MULES", "MULEY", "MULLA", "MULLS", "MUMMS", "MUMMY", "MUMPS", "MUMUS", "MUNCH", "MUNGO", "MUNIS", "MUONS", "MURAL", "MURAS", "MURED",
            "MURES", "MUREX", "MURID", "MURKS", "MURKY", "MURRA", "MURRE", "MURRS", "MURRY", "MUSCA", "MUSED", "MUSER", "MUSES", "MUSHY", "MUSIC", "MUSKS", "MUSKY",
            "MUSSY", "MUSTH", "MUSTS", "MUSTY", "MUTCH", "MUTED", "MUTER", "MUTES", "MUTON", "MUTTS", "MUZZY", "MYNAH", "MYNAS", "MYOID", "MYOMA", "MYOPE", "MYOPY",
            "MYRRH", "MYSID", "MYTHS", "MYTHY", "NAANS", "NABES", "NABIS", "NABOB", "NACHO", "NACRE", "NADAS", "NADIR", "NAEVI", "NAGGY", "NAIAD", "NAIFS", "NAILS",
            "NAIRA", "NAIVE", "NAKED", "NALED", "NAMED", "NAMER", "NAMES", "NANAS", "NANCE", "NANCY", "NANNY", "NAPES", "NAPPE", "NAPPY", "NARCO", "NARCS", "NARDS",
            "NARES", "NARIC", "NARIS", "NARKS", "NARKY", "NASAL", "NASTY", "NATAL", "NATCH", "NATES", "NATTY", "NAVAL", "NAVAR", "NAVEL", "NAVES", "NAVVY", "NAWAB",
            "NAZIS", "NEAPS", "NEARS", "NEATH", "NEATS", "NECKS", "NEEDS", "NEEDY", "NEEMS", "NEEPS", "NEGUS", "NEIFS", "NEIGH", "NEIST", "NELLY", "NEMAS", "NENES",
            "NEONS", "NERDS", "NERDY", "NEROL", "NERTS", "NERTZ", "NERVE", "NERVY", "NESTS", "NETOP", "NETTS", "NETTY", "NEUKS", "NEUME", "NEUMS", "NEVER", "NEVES",
            "NEVUS", "NEWEL", "NEWER", "NEWIE", "NEWLY", "NEWSY", "NEWTS", "NEXUS", "NGWEE", "NICAD", "NICER", "NICHE", "NICKS", "NICOL", "NIDAL", "NIDED", "NIDES",
            "NIDUS", "NIECE", "NIEVE", "NIFTY", "NIGHS", "NIGHT", "NIHIL", "NILLS", "NIMBI", "NINES", "NINJA", "NINNY", "NINON", "NINTH", "NIPAS", "NIPPY", "NISEI",
            "NISUS", "NITER", "NITES", "NITID", "NITON", "NITRE", "NITRO", "NITTY", "NIVAL", "NIXED", "NIXES", "NIXIE", "NIZAM", "NOBBY", "NOBLE", "NOBLY", "NOCKS",
            "NODAL", "NODDY", "NODES", "NODUS", "NOELS", "NOGGS", "NOHOW", "NOILS", "NOILY", "NOIRS", "NOISE", "NOISY", "NOLOS", "NOMAD", "NOMAS", "NOMEN", "NOMES",
            "NOMOI", "NOMOS", "NONAS", "NONCE", "NONES", "NONET", "NONYL", "NOOKS", "NOOKY", "NOONS", "NOOSE", "NOPAL", "NORIA", "NORIS", "NORMS", "NORTH", "NOSED",
            "NOSES", "NOSEY", "NOTAL", "NOTCH", "NOTED", "NOTER", "NOTES", "NOTUM", "NOUNS", "NOVAE", "NOVAS", "NOVEL", "NOWAY", "NOWTS", "NUBBY", "NUBIA", "NUCHA",
            "NUDER", "NUDES", "NUDGE", "NUDIE", "NUDZH", "NUKED", "NUKES", "NULLS", "NUMBS", "NUMEN", "NURDS", "NURLS", "NURSE", "NUTSY", "NUTTY", "NYALA", "NYLON",
            "NYMPH", "OAKEN", "OAKUM", "OARED", "OASES", "OASIS", "OASTS", "OATEN", "OATER", "OATHS", "OAVES", "OBEAH", "OBELI", "OBESE", "OBEYS", "OBIAS", "OBITS",
            "OBJET", "OBOES", "OBOLE", "OBOLI", "OBOLS", "OCCUR", "OCEAN", "OCHER", "OCHRE", "OCHRY", "OCKER", "OCREA", "OCTAD", "OCTAL", "OCTAN", "OCTET", "OCTYL",
            "OCULI", "ODDER", "ODDLY", "ODEON", "ODEUM", "ODIST", "ODIUM", "ODORS", "ODOUR", "ODYLE", "ODYLS", "OFAYS", "OFFAL", "OFFED", "OFFER", "OFTEN", "OFTER",
            "OGAMS", "OGEES", "OGHAM", "OGIVE", "OGLED", "OGLER", "OGLES", "OGRES", "OHIAS", "OHING", "OHMIC", "OIDIA", "OILED", "OILER", "OINKS", "OKAPI", "OKAYS",
            "OKEHS", "OKRAS", "OLDEN", "OLDER", "OLDIE", "OLEIC", "OLEIN", "OLEOS", "OLEUM", "OLIOS", "OLIVE", "OLLAS", "OLOGY", "OMASA", "OMBER", "OMBRE", "OMEGA",
            "OMENS", "OMERS", "OMITS", "ONCES", "ONERY", "ONION", "ONIUM", "ONSET", "ONTIC", "OOHED", "OOMPH", "OORIE", "OOTID", "OOZED", "OOZES", "OPAHS", "OPALS",
            "OPENS", "OPERA", "OPINE", "OPING", "OPIUM", "OPSIN", "OPTED", "OPTIC", "ORACH", "ORALS", "ORANG", "ORATE", "ORBED", "ORBIT", "ORCAS", "ORCIN", "ORDER",
            "ORDOS", "OREAD", "ORGAN", "ORGIC", "ORIBI", "ORIEL", "ORLES", "ORLOP", "ORMER", "ORNIS", "ORPIN", "ORRIS", "ORTHO", "ORZOS", "OSIER", "OSMIC", "OSMOL",
            "OSSIA", "OSTIA", "OTHER", "OTTAR", "OTTER", "OTTOS", "OUGHT", "OUNCE", "OUPHE", "OUPHS", "OURIE", "OUSEL", "OUSTS", "OUTBY", "OUTDO", "OUTED", "OUTER",
            "OUTGO", "OUTRE", "OUZEL", "OUZOS", "OVALS", "OVARY", "OVATE", "OVENS", "OVERS", "OVERT", "OVINE", "OVOID", "OVOLI", "OVOLO", "OVULE", "OWING", "OWLET",
            "OWNED", "OWNER", "OWSEN", "OXBOW", "OXEYE", "OXIDE", "OXIDS", "OXIME", "OXIMS", "OXLIP", "OXTER", "OYERS", "OZONE", "PACAS", "PACED", "PACER", "PACES",
            "PACHA", "PACKS", "PACTS", "PADDY", "PADIS", "PADLE", "PADRE", "PADRI", "PAEAN", "PAEON", "PAGAN", "PAGED", "PAGER", "PAGES", "PAGOD", "PAIKS", "PAILS",
            "PAINS", "PAINT", "PAIRS", "PAISA", "PAISE", "PALEA", "PALED", "PALER", "PALES", "PALET", "PALLS", "PALLY", "PALMS", "PALMY", "PALPI", "PALPS", "PALSY",
            "PAMPA", "PANDA", "PANDY", "PANED", "PANEL", "PANES", "PANGA", "PANGS", "PANIC", "PANNE", "PANSY", "PANTO", "PANTS", "PANTY", "PAPAL", "PAPAS", "PAPAW",
            "PAPER", "PAPPI", "PAPPY", "PARAE", "PARAS", "PARCH", "PARDI", "PARDS", "PARDY", "PARED", "PAREO", "PARER", "PARES", "PAREU", "PARGE", "PARGO", "PARIS",
            "PARKA", "PARKS", "PARLE", "PAROL", "PARRS", "PARRY", "PARSE", "PARTS", "PARTY", "PARVE", "PARVO", "PASEO", "PASES", "PASHA", "PASSE", "PASTA", "PASTE",
            "PASTS", "PASTY", "PATCH", "PATED", "PATEN", "PATER", "PATES", "PATHS", "PATIN", "PATIO", "PATLY", "PATSY", "PATTY", "PAUSE", "PAVAN", "PAVED", "PAVER",
            "PAVES", "PAVID", "PAVIN", "PAVIS", "PAWED", "PAWER", "PAWKY", "PAWLS", "PAWNS", "PAXES", "PAYED", "PAYEE", "PAYER", "PAYOR", "PEACE", "PEACH", "PEAGE",
            "PEAGS", "PEAKS", "PEAKY", "PEALS", "PEANS", "PEARL", "PEARS", "PEART", "PEASE", "PEATS", "PEATY", "PEAVY", "PECAN", "PECHS", "PECKS", "PECKY", "PEDAL",
            "PEDES", "PEDRO", "PEEKS", "PEELS", "PEENS", "PEEPS", "PEERS", "PEERY", "PEEVE", "PEINS", "PEISE", "PEKAN", "PEKES", "PEKIN", "PEKOE", "PELES", "PELFS",
            "PELON", "PELTS", "PENAL", "PENCE", "PENDS", "PENES", "PENGO", "PENIS", "PENNA", "PENNE", "PENNI", "PENNY", "PEONS", "PEONY", "PEPLA", "PEPOS", "PEPPY",
            "PERCH", "PERDU", "PERDY", "PEREA", "PERIL", "PERIS", "PERKS", "PERKY", "PERMS", "PERPS", "PERRY", "PERSE", "PESKY", "PESOS", "PESTO", "PESTS", "PESTY",
            "PETAL", "PETER", "PETIT", "PETTI", "PETTO", "PETTY", "PEWEE", "PEWIT", "PHAGE", "PHASE", "PHIAL", "PHLOX", "PHONE", "PHONO", "PHONS", "PHONY", "PHOTO",
            "PHOTS", "PHPHT", "PHUTS", "PHYLA", "PHYLE", "PIANO", "PIANS", "PIBAL", "PICAL", "PICAS", "PICKS", "PICKY", "PICOT", "PICUL", "PIECE", "PIERS", "PIETA",
            "PIETY", "PIGGY", "PIGMY", "PIING", "PIKAS", "PIKED", "PIKER", "PIKES", "PIKIS", "PILAF", "PILAR", "PILAU", "PILAW", "PILEA", "PILED", "PILEI", "PILES",
            "PILIS", "PILLS", "PILOT", "PILUS", "PIMAS", "PIMPS", "PINAS", "PINCH", "PINED", "PINES", "PINEY", "PINGO", "PINGS", "PINKO", "PINKS", "PINKY", "PINNA",
            "PINNY", "PINON", "PINOT", "PINTA", "PINTO", "PINTS", "PINUP", "PIONS", "PIOUS", "PIPAL", "PIPED", "PIPER", "PIPES", "PIPET", "PIPIT", "PIQUE", "PIRNS",
            "PIROG", "PISCO", "PISOS", "PISTE", "PITAS", "PITCH", "PITHS", "PITHY", "PITON", "PIVOT", "PIXEL", "PIXES", "PIXIE", "PIZZA", "PLACE", "PLACK", "PLAGE",
            "PLAID", "PLAIN", "PLAIT", "PLANE", "PLANK", "PLANS", "PLANT", "PLASH", "PLASM", "PLATE", "PLATS", "PLATY", "PLAYA", "PLAYS", "PLAZA", "PLEAD", "PLEAS",
            "PLEAT", "PLEBE", "PLEBS", "PLENA", "PLEWS", "PLICA", "PLIED", "PLIER", "PLIES", "PLINK", "PLODS", "PLONK", "PLOPS", "PLOTS", "PLOTZ", "PLOWS", "PLOYS",
            "PLUCK", "PLUGS", "PLUMB", "PLUME", "PLUMP", "PLUMS", "PLUMY", "PLUNK", "PLUSH", "PLYER", "POACH", "POCKS", "POCKY", "PODGY", "PODIA", "POEMS", "POESY",
            "POETS", "POGEY", "POILU", "POIND", "POINT", "POISE", "POKED", "POKER", "POKES", "POKEY", "POLAR", "POLED", "POLER", "POLES", "POLIO", "POLIS", "POLKA",
            "POLLS", "POLOS", "POLYP", "POLYS", "POMES", "POMMY", "POMPS", "PONCE", "PONDS", "PONES", "PONGS", "POOCH", "POODS", "POOFS", "POOFY", "POOHS", "POOKA",
            "POOLS", "POONS", "POOPS", "POORI", "POOVE", "POPES", "POPPA", "POPPY", "POPSY", "PORCH", "PORED", "PORES", "PORGY", "PORKS", "PORKY", "PORNO", "PORNS",
            "PORNY", "PORTS", "POSED", "POSER", "POSES", "POSIT", "POSSE", "POSTS", "POTSY", "POTTO", "POTTY", "POUCH", "POUFF", "POUFS", "POULT", "POUND", "POURS",
            "POUTS", "POUTY", "POWER", "POXED", "POXES", "POYOU", "PRAAM", "PRAHU", "PRAMS", "PRANG", "PRANK", "PRAOS", "PRASE", "PRATE", "PRATS", "PRAUS", "PRAWN",
            "PRAYS", "PREED", "PREEN", "PREES", "PREPS", "PRESA", "PRESE", "PRESS", "PREST", "PREXY", "PREYS", "PRICE", "PRICK", "PRICY", "PRIDE", "PRIED", "PRIER",
            "PRIES", "PRIGS", "PRILL", "PRIMA", "PRIME", "PRIMI", "PRIMO", "PRIMP", "PRIMS", "PRINK", "PRINT", "PRION", "PRIOR", "PRISE", "PRISM", "PRISS", "PRIVY",
            "PRIZE", "PROAS", "PROBE", "PRODS", "PROEM", "PROFS", "PROGS", "PROLE", "PROMO", "PROMS", "PRONE", "PRONG", "PROOF", "PROPS", "PROSE", "PROSO", "PROSS",
            "PROST", "PROSY", "PROUD", "PROVE", "PROWL", "PROWS", "PROXY", "PRUDE", "PRUNE", "PRUTA", "PRYER", "PSALM", "PSEUD", "PSHAW", "PSOAE", "PSOAI", "PSOAS",
            "PSYCH", "PUBES", "PUBIC", "PUBIS", "PUCES", "PUCKA", "PUCKS", "PUDGY", "PUDIC", "PUFFS", "PUFFY", "PUGGY", "PUJAH", "PUJAS", "PUKED", "PUKES", "PUKKA",
            "PULED", "PULER", "PULES", "PULIK", "PULIS", "PULLS", "PULPS", "PULPY", "PULSE", "PUMAS", "PUMPS", "PUNAS", "PUNCH", "PUNGS", "PUNKA", "PUNKS", "PUNKY",
            "PUNNY", "PUNTO", "PUNTS", "PUNTY", "PUPAE", "PUPAL", "PUPAS", "PUPIL", "PUPPY", "PURDA", "PUREE", "PURER", "PURGE", "PURIN", "PURIS", "PURLS", "PURRS",
            "PURSE", "PURSY", "PUSES", "PUSHY", "PUSSY", "PUTON", "PUTTI", "PUTTO", "PUTTS", "PUTTY", "PYGMY", "PYINS", "PYLON", "PYOID", "PYRAN", "PYRES", "PYRIC",
            "PYXES", "PYXIE", "PYXIS", "QAIDS", "QANAT", "QOPHS", "QUACK", "QUADS", "QUAFF", "QUAGS", "QUAIL", "QUAIS", "QUAKE", "QUAKY", "QUALE", "QUALM", "QUANT",
            "QUARE", "QUARK", "QUART", "QUASH", "QUASI", "QUASS", "QUATE", "QUAYS", "QUEAN", "QUEEN", "QUEER", "QUELL", "QUERN", "QUERY", "QUEST", "QUEUE", "QUEYS",
            "QUICK", "QUIDS", "QUIET", "QUIFF", "QUILL", "QUILT", "QUINS", "QUINT", "QUIPS", "QUIPU", "QUIRE", "QUIRK", "QUIRT", "QUITE", "QUITS", "QUODS", "QUOIN",
            "QUOIT", "QUOTA", "QUOTE", "QUOTH", "QURSH", "RABAT", "RABBI", "RABIC", "RABID", "RACED", "RACER", "RACES", "RACKS", "RACON", "RADAR", "RADII", "RADIO",
            "RADIX", "RADON", "RAFFS", "RAFTS", "RAGAS", "RAGED", "RAGEE", "RAGES", "RAGGY", "RAGIS", "RAIAS", "RAIDS", "RAILS", "RAINS", "RAINY", "RAISE", "RAJAH",
            "RAJAS", "RAJES", "RAKED", "RAKEE", "RAKER", "RAKES", "RAKIS", "RALES", "RALLY", "RALPH", "RAMEE", "RAMEN", "RAMET", "RAMIE", "RAMMY", "RAMPS", "RAMUS",
            "RANCE", "RANCH", "RANDS", "RANDY", "RANEE", "RANGE", "RANGY", "RANID", "RANIS", "RANKS", "RANTS", "RAPED", "RAPER", "RAPES", "RAPHE", "RAPID", "RARED",
            "RARER", "RARES", "RASED", "RASER", "RASES", "RASPS", "RASPY", "RATAL", "RATAN", "RATCH", "RATED", "RATEL", "RATER", "RATES", "RATHE", "RATIO", "RATOS",
            "RATTY", "RAVED", "RAVEL", "RAVEN", "RAVER", "RAVES", "RAVIN", "RAWER", "RAWIN", "RAWLY", "RAXED", "RAXES", "RAYAH", "RAYAS", "RAYED", "RAYON", "RAZED",
            "RAZEE", "RAZER", "RAZES", "RAZOR", "REACH", "REACT", "READD", "READS", "READY", "REALM", "REALS", "REAMS", "REAPS", "REARM", "REARS", "REATA", "REAVE",
            "REBAR", "REBBE", "REBEC", "REBEL", "REBID", "REBOP", "REBUS", "REBUT", "REBUY", "RECAP", "RECCE", "RECKS", "RECON", "RECTA", "RECTI", "RECTO", "RECUR",
            "RECUT", "REDAN", "REDDS", "REDED", "REDES", "REDIA", "REDID", "REDIP", "REDLY", "REDON", "REDOS", "REDOX", "REDRY", "REDUB", "REDUX", "REDYE", "REEDS",
            "REEDY", "REEFS", "REEFY", "REEKS", "REEKY", "REELS", "REEST", "REEVE", "REFED", "REFEL", "REFER", "REFIT", "REFIX", "REFLY", "REFRY", "REGAL", "REGES",
            "REGMA", "REGNA", "REHAB", "REHEM", "REIFS", "REIFY", "REIGN", "REINK", "REINS", "REIVE", "REKEY", "RELAX", "RELAY", "RELET", "RELIC", "RELIT", "REMAN",
            "REMAP", "REMET", "REMEX", "REMIT", "REMIX", "RENAL", "RENDS", "RENEW", "RENIG", "RENIN", "RENTE", "RENTS", "REOIL", "REPAY", "REPEG", "REPEL", "REPIN",
            "REPLY", "REPOS", "REPOT", "REPPS", "REPRO", "RERAN", "RERIG", "RERUN", "RESAW", "RESAY", "RESEE", "RESET", "RESEW", "RESID", "RESIN", "RESOD", "RESOW",
            "RESTS", "RETAG", "RETAX", "RETCH", "RETEM", "RETIA", "RETIE", "RETRO", "RETRY", "REUSE", "REVEL", "REVET", "REVUE", "REWAN", "REWAX", "REWED", "REWET",
            "REWIN", "REWON", "REXES", "RHEAS", "RHEUM", "RHINO", "RHOMB", "RHUMB", "RHYME", "RHYTA", "RIALS", "RIANT", "RIATA", "RIBBY", "RIBES", "RICED", "RICER",
            "RICES", "RICIN", "RICKS", "RIDER", "RIDES", "RIDGE", "RIDGY", "RIELS", "RIFER", "RIFFS", "RIFLE", "RIFTS", "RIGHT", "RIGID", "RIGOR", "RILED", "RILES",
            "RILEY", "RILLE", "RILLS", "RIMED", "RIMER", "RIMES", "RINDS", "RINGS", "RINKS", "RINSE", "RIOJA", "RIOTS", "RIPED", "RIPEN", "RIPER", "RIPES", "RISEN",
            "RISER", "RISES", "RISHI", "RISKS", "RISKY", "RISUS", "RITES", "RITZY", "RIVAL", "RIVED", "RIVEN", "RIVER", "RIVES", "RIVET", "RIYAL", "ROACH", "ROADS",
            "ROAMS", "ROANS", "ROARS", "ROAST", "ROBED", "ROBES", "ROBIN", "ROBLE", "ROBOT", "ROCKS", "ROCKY", "RODEO", "ROGER", "ROGUE", "ROILS", "ROILY", "ROLES",
            "ROLFS", "ROLLS", "ROMAN", "ROMEO", "ROMPS", "RONDO", "ROODS", "ROOFS", "ROOKS", "ROOKY", "ROOMS", "ROOMY", "ROOSE", "ROOST", "ROOTS", "ROOTY", "ROPED",
            "ROPER", "ROPES", "ROPEY", "ROQUE", "ROSED", "ROSES", "ROSET", "ROSIN", "ROTAS", "ROTCH", "ROTES", "ROTIS", "ROTLS", "ROTOR", "ROTOS", "ROTTE", "ROUEN",
            "ROUES", "ROUGE", "ROUGH", "ROUND", "ROUPS", "ROUPY", "ROUSE", "ROUST", "ROUTE", "ROUTH", "ROUTS", "ROVED", "ROVEN", "ROVER", "ROVES", "ROWAN", "ROWDY",
            "ROWED", "ROWEL", "ROWEN", "ROWER", "ROWTH", "ROYAL", "RUANA", "RUBES", "RUBLE", "RUBUS", "RUCHE", "RUCKS", "RUDDS", "RUDDY", "RUDER", "RUERS", "RUFFE",
            "RUFFS", "RUGAE", "RUGAL", "RUGBY", "RUING", "RUINS", "RULED", "RULER", "RULES", "RUMBA", "RUMEN", "RUMMY", "RUMOR", "RUMPS", "RUNES", "RUNGS", "RUNIC",
            "RUNNY", "RUNTS", "RUNTY", "RUPEE", "RURAL", "RUSES", "RUSHY", "RUSKS", "RUSTS", "RUSTY", "RUTHS", "RUTIN", "RUTTY", "RYKED", "RYKES", "RYNDS", "RYOTS",
            "SABED", "SABER", "SABES", "SABIN", "SABIR", "SABLE", "SABOT", "SABRA", "SABRE", "SACKS", "SACRA", "SADES", "SADHE", "SADHU", "SADIS", "SADLY", "SAFER",
            "SAFES", "SAGAS", "SAGER", "SAGES", "SAGGY", "SAGOS", "SAGUM", "SAHIB", "SAICE", "SAIDS", "SAIGA", "SAILS", "SAINS", "SAINT", "SAITH", "SAJOU", "SAKER",
            "SAKES", "SAKIS", "SALAD", "SALAL", "SALEP", "SALES", "SALIC", "SALLY", "SALMI", "SALOL", "SALON", "SALPA", "SALPS", "SALSA", "SALTS", "SALTY", "SALVE",
            "SALVO", "SAMBA", "SAMBO", "SAMEK", "SAMPS", "SANDS", "SANDY", "SANED", "SANER", "SANES", "SANGA", "SANGH", "SANTO", "SAPID", "SAPOR", "SAPPY", "SARAN",
            "SARDS", "SAREE", "SARGE", "SARIN", "SARIS", "SARKS", "SARKY", "SAROD", "SAROS", "SASIN", "SASSY", "SATAY", "SATED", "SATEM", "SATES", "SATIN", "SATIS",
            "SATYR", "SAUCE", "SAUCH", "SAUCY", "SAUGH", "SAULS", "SAULT", "SAUNA", "SAURY", "SAUTE", "SAVED", "SAVER", "SAVES", "SAVIN", "SAVOR", "SAVOY", "SAVVY",
            "SAWED", "SAWER", "SAXES", "SAYER", "SAYID", "SAYST", "SCABS", "SCADS", "SCAGS", "SCALD", "SCALE", "SCALL", "SCALP", "SCALY", "SCAMP", "SCAMS", "SCANS",
            "SCANT", "SCAPE", "SCARE", "SCARF", "SCARP", "SCARS", "SCART", "SCARY", "SCATS", "SCATT", "SCAUP", "SCAUR", "SCENA", "SCEND", "SCENE", "SCENT", "SCHAV",
            "SCHMO", "SCHUL", "SCHWA", "SCION", "SCOFF", "SCOLD", "SCONE", "SCOOP", "SCOOT", "SCOPE", "SCOPS", "SCORE", "SCORN", "SCOTS", "SCOUR", "SCOUT", "SCOWL",
            "SCOWS", "SCRAG", "SCRAM", "SCRAP", "SCREE", "SCREW", "SCRIM", "SCRIP", "SCROD", "SCRUB", "SCRUM", "SCUBA", "SCUDI", "SCUDO", "SCUDS", "SCUFF", "SCULK",
            "SCULL", "SCULP", "SCUMS", "SCUPS", "SCURF", "SCUTA", "SCUTE", "SCUTS", "SEALS", "SEAMS", "SEAMY", "SEARS", "SEATS", "SEBUM", "SECCO", "SECTS", "SEDAN",
            "SEDER", "SEDGE", "SEDGY", "SEDUM", "SEEDS", "SEEDY", "SEEKS", "SEELS", "SEELY", "SEEMS", "SEEPS", "SEEPY", "SEERS", "SEGNI", "SEGNO", "SEGOS", "SEGUE",
            "SEIFS", "SEINE", "SEISE", "SEISM", "SEIZE", "SELAH", "SELFS", "SELLE", "SELLS", "SELVA", "SEMEN", "SEMES", "SEMIS", "SENDS", "SENGI", "SENNA", "SENOR",
            "SENSA", "SENSE", "SENTE", "SENTI", "SEPAL", "SEPIA", "SEPIC", "SEPOY", "SEPTA", "SEPTS", "SERAC", "SERAI", "SERAL", "SERED", "SERER", "SERES", "SERFS",
            "SERGE", "SERIF", "SERIN", "SEROW", "SERRY", "SERUM", "SERVE", "SERVO", "SETAE", "SETAL", "SETON", "SETTS", "SETUP", "SEVEN", "SEVER", "SEWAN", "SEWAR",
            "SEWED", "SEWER", "SEXED", "SEXES", "SEXTO", "SEXTS", "SHACK", "SHADE", "SHADS", "SHADY", "SHAFT", "SHAGS", "SHAHS", "SHAKE", "SHAKO", "SHAKY", "SHALE",
            "SHALL", "SHALT", "SHALY", "SHAME", "SHAMS", "SHANK", "SHAPE", "SHARD", "SHARE", "SHARK", "SHARN", "SHARP", "SHAUL", "SHAVE", "SHAWL", "SHAWM", "SHAWN",
            "SHAWS", "SHAYS", "SHEAF", "SHEAL", "SHEAR", "SHEAS", "SHEDS", "SHEEN", "SHEEP", "SHEER", "SHEET", "SHEIK", "SHELF", "SHELL", "SHEND", "SHENT", "SHEOL",
            "SHERD", "SHEWN", "SHEWS", "SHIED", "SHIEL", "SHIER", "SHIES", "SHIFT", "SHILL", "SHILY", "SHIMS", "SHINE", "SHINS", "SHINY", "SHIPS", "SHIRE", "SHIRK",
            "SHIRR", "SHIRT", "SHIST", "SHITS", "SHIVA", "SHIVE", "SHIVS", "SHLEP", "SHOAL", "SHOAT", "SHOCK", "SHOED", "SHOER", "SHOES", "SHOGS", "SHOJI", "SHONE",
            "SHOOK", "SHOOL", "SHOON", "SHOOS", "SHOOT", "SHOPS", "SHORE", "SHORL", "SHORN", "SHORT", "SHOTE", "SHOTS", "SHOTT", "SHOUT", "SHOVE", "SHOWN", "SHOWS",
            "SHOWY", "SHOYU", "SHRED", "SHREW", "SHRIS", "SHRUB", "SHRUG", "SHTIK", "SHUCK", "SHULN", "SHULS", "SHUNS", "SHUNT", "SHUSH", "SHUTE", "SHUTS", "SHYER",
            "SHYLY", "SIALS", "SIBBS", "SIBYL", "SICES", "SICKO", "SICKS", "SIDED", "SIDES", "SIDLE", "SIEGE", "SIEUR", "SIEVE", "SIFTS", "SIGHS", "SIGHT", "SIGIL",
            "SIGMA", "SIGNS", "SIKER", "SIKES", "SILDS", "SILEX", "SILKS", "SILKY", "SILLS", "SILLY", "SILOS", "SILTS", "SILTY", "SILVA", "SIMAR", "SIMAS", "SIMPS",
            "SINCE", "SINES", "SINEW", "SINGE", "SINGS", "SINHS", "SINKS", "SINUS", "SIPED", "SIPES", "SIRED", "SIREE", "SIREN", "SIRES", "SIRRA", "SIRUP", "SISAL",
            "SISES", "SISSY", "SITAR", "SITED", "SITES", "SITUP", "SITUS", "SIVER", "SIXES", "SIXMO", "SIXTE", "SIXTH", "SIXTY", "SIZAR", "SIZED", "SIZER", "SIZES",
            "SKAGS", "SKALD", "SKATE", "SKATS", "SKEAN", "SKEED", "SKEEN", "SKEES", "SKEET", "SKEGS", "SKEIN", "SKELM", "SKELP", "SKENE", "SKEPS", "SKEWS", "SKIDS",
            "SKIED", "SKIER", "SKIES", "SKIEY", "SKIFF", "SKILL", "SKIMO", "SKIMP", "SKIMS", "SKINK", "SKINS", "SKINT", "SKIPS", "SKIRL", "SKIRR", "SKIRT", "SKITE",
            "SKITS", "SKIVE", "SKOAL", "SKOSH", "SKUAS", "SKULK", "SKULL", "SKUNK", "SKYED", "SKYEY", "SLABS", "SLACK", "SLAGS", "SLAIN", "SLAKE", "SLAMS", "SLANG",
            "SLANK", "SLANT", "SLAPS", "SLASH", "SLATE", "SLATS", "SLATY", "SLAVE", "SLAWS", "SLAYS", "SLEDS", "SLEEK", "SLEEP", "SLEET", "SLEPT", "SLEWS", "SLICE",
            "SLICK", "SLIDE", "SLIER", "SLILY", "SLIME", "SLIMS", "SLIMY", "SLING", "SLINK", "SLIPE", "SLIPS", "SLIPT", "SLITS", "SLOBS", "SLOES", "SLOGS", "SLOID",
            "SLOJD", "SLOOP", "SLOPE", "SLOPS", "SLOSH", "SLOTH", "SLOTS", "SLOWS", "SLOYD", "SLUBS", "SLUED", "SLUES", "SLUFF", "SLUGS", "SLUMP", "SLUMS", "SLUNG",
            "SLUNK", "SLURB", "SLURP", "SLURS", "SLUSH", "SLUTS", "SLYER", "SLYLY", "SLYPE", "SMACK", "SMALL", "SMALT", "SMARM", "SMART", "SMASH", "SMAZE", "SMEAR",
            "SMEEK", "SMELL", "SMELT", "SMERK", "SMEWS", "SMILE", "SMIRK", "SMITE", "SMITH", "SMOCK", "SMOGS", "SMOKE", "SMOKY", "SMOLT", "SMOTE", "SMUTS", "SNACK",
            "SNAFU", "SNAGS", "SNAIL", "SNAKE", "SNAKY", "SNAPS", "SNARE", "SNARK", "SNARL", "SNASH", "SNATH", "SNAWS", "SNEAK", "SNEAP", "SNECK", "SNEDS", "SNEER",
            "SNELL", "SNIBS", "SNICK", "SNIDE", "SNIFF", "SNIPE", "SNIPS", "SNITS", "SNOBS", "SNOGS", "SNOOD", "SNOOK", "SNOOL", "SNOOP", "SNOOT", "SNORE", "SNORT",
            "SNOTS", "SNOUT", "SNOWS", "SNOWY", "SNUBS", "SNUCK", "SNUFF", "SNUGS", "SNYES", "SOAKS", "SOAPS", "SOAPY", "SOARS", "SOAVE", "SOBER", "SOCKO", "SOCKS",
            "SOCLE", "SODAS", "SODDY", "SODIC", "SODOM", "SOFAR", "SOFAS", "SOFTA", "SOFTS", "SOFTY", "SOGGY", "SOILS", "SOJAS", "SOKES", "SOKOL", "SOLAN", "SOLAR",
            "SOLDI", "SOLDO", "SOLED", "SOLEI", "SOLES", "SOLID", "SOLON", "SOLOS", "SOLUM", "SOLUS", "SOLVE", "SOMAS", "SONAR", "SONDE", "SONES", "SONGS", "SONIC",
            "SONLY", "SONNY", "SONSY", "SOOEY", "SOOKS", "SOOTH", "SOOTS", "SOOTY", "SOPHS", "SOPHY", "SOPOR", "SOPPY", "SORAS", "SORBS", "SORDS", "SOREL", "SORER",
            "SORES", "SORGO", "SORNS", "SORRY", "SORTS", "SORUS", "SOTHS", "SOTOL", "SOUGH", "SOUKS", "SOULS", "SOUND", "SOUPS", "SOUPY", "SOURS", "SOUSE", "SOUTH",
            "SOWAR", "SOWED", "SOWER", "SOYAS", "SOYUZ", "SOZIN", "SPACE", "SPACY", "SPADE", "SPADO", "SPAED", "SPAES", "SPAHI", "SPAIL", "SPAIT", "SPAKE", "SPALE",
            "SPALL", "SPAMS", "SPANG", "SPANK", "SPANS", "SPARE", "SPARK", "SPARS", "SPASM", "SPATE", "SPATS", "SPAWN", "SPAYS", "SPEAK", "SPEAN", "SPEAR", "SPECK",
            "SPECS", "SPEED", "SPEEL", "SPEER", "SPEIL", "SPEIR", "SPELL", "SPELT", "SPEND", "SPENT", "SPERM", "SPEWS", "SPICA", "SPICE", "SPICK", "SPICS", "SPICY",
            "SPIED", "SPIEL", "SPIER", "SPIES", "SPIFF", "SPIKE", "SPIKS", "SPIKY", "SPILE", "SPILL", "SPILT", "SPINE", "SPINS", "SPINY", "SPIRE", "SPIRT", "SPIRY",
            "SPITE", "SPITS", "SPITZ", "SPIVS", "SPLAT", "SPLAY", "SPLIT", "SPODE", "SPOIL", "SPOKE", "SPOOF", "SPOOK", "SPOOL", "SPOON", "SPOOR", "SPORE", "SPORT",
            "SPOTS", "SPOUT", "SPRAG", "SPRAT", "SPRAY", "SPREE", "SPRIG", "SPRIT", "SPRUE", "SPRUG", "SPUDS", "SPUED", "SPUES", "SPUME", "SPUMY", "SPUNK", "SPURN",
            "SPURS", "SPURT", "SPUTA", "SQUAB", "SQUAD", "SQUAT", "SQUAW", "SQUEG", "SQUIB", "SQUID", "STABS", "STACK", "STADE", "STAFF", "STAGE", "STAGS", "STAGY",
            "STAID", "STAIG", "STAIN", "STAIR", "STAKE", "STALE", "STALK", "STALL", "STAMP", "STAND", "STANE", "STANG", "STANK", "STAPH", "STARE", "STARK", "STARS",
            "START", "STASH", "STATE", "STATS", "STAVE", "STAYS", "STEAD", "STEAK", "STEAL", "STEAM", "STEED", "STEEK", "STEEL", "STEEP", "STEER", "STEIN", "STELA",
            "STELE", "STEMS", "STENO", "STEPS", "STERE", "STERN", "STETS", "STEWS", "STICH", "STICK", "STIED", "STIES", "STIFF", "STILE", "STILL", "STILT", "STIME",
            "STIMY", "STING", "STINK", "STINT", "STIPE", "STIRK", "STIRP", "STIRS", "STOAE", "STOAI", "STOAS", "STOAT", "STOBS", "STOCK", "STOGY", "STOIC", "STOKE",
            "STOLE", "STOMA", "STOMP", "STONE", "STONY", "STOOD", "STOOK", "STOOL", "STOOP", "STOPE", "STOPS", "STOPT", "STORE", "STORK", "STORM", "STORY", "STOSS",
            "STOUP", "STOUR", "STOUT", "STOVE", "STOWP", "STOWS", "STRAP", "STRAW", "STRAY", "STREP", "STREW", "STRIA", "STRIP", "STROP", "STROW", "STROY", "STRUM",
            "STRUT", "STUBS", "STUCK", "STUDS", "STUDY", "STUFF", "STULL", "STUMP", "STUMS", "STUNG", "STUNK", "STUNS", "STUNT", "STUPA", "STUPE", "STURT", "STYED",
            "STYES", "STYLE", "STYLI", "STYMY", "SUAVE", "SUBAH", "SUBAS", "SUBER", "SUCKS", "SUCRE", "SUDDS", "SUDOR", "SUDSY", "SUEDE", "SUERS", "SUETS", "SUETY",
            "SUGAR", "SUGHS", "SUING", "SUINT", "SUITE", "SUITS", "SULCI", "SULFA", "SULFO", "SULKS", "SULKY", "SULLY", "SULUS", "SUMAC", "SUMMA", "SUMOS", "SUMPS",
            "SUNNA", "SUNNS", "SUNNY", "SUNUP", "SUPER", "SUPES", "SUPRA", "SURAH", "SURAL", "SURAS", "SURDS", "SURER", "SURFS", "SURFY", "SURGE", "SURGY", "SURLY",
            "SURRA", "SUSHI", "SUTRA", "SUTTA", "SWABS", "SWAGE", "SWAGS", "SWAIL", "SWAIN", "SWALE", "SWAMI", "SWAMP", "SWAMY", "SWANG", "SWANK", "SWANS", "SWAPS",
            "SWARD", "SWARE", "SWARF", "SWARM", "SWART", "SWASH", "SWATH", "SWATS", "SWAYS", "SWEAR", "SWEAT", "SWEDE", "SWEEP", "SWEER", "SWEET", "SWELL", "SWEPT",
            "SWIFT", "SWIGS", "SWILL", "SWIMS", "SWINE", "SWING", "SWINK", "SWIPE", "SWIRL", "SWISH", "SWISS", "SWITH", "SWIVE", "SWOBS", "SWOON", "SWOOP", "SWOPS",
            "SWORD", "SWORE", "SWORN", "SWOTS", "SWOUN", "SWUNG", "SYCEE", "SYCES", "SYKES", "SYLIS", "SYLPH", "SYLVA", "SYNCH", "SYNCS", "SYNOD", "SYNTH", "SYPHS",
            "SYREN", "SYRUP", "SYSOP", "TABBY", "TABER", "TABES", "TABID", "TABLA", "TABLE", "TABOO", "TABOR", "TABUN", "TABUS", "TACES", "TACET", "TACHE", "TACHS",
            "TACIT", "TACKS", "TACKY", "TACOS", "TACTS", "TAELS", "TAFFY", "TAFIA", "TAHRS", "TAIGA", "TAILS", "TAINS", "TAINT", "TAJES", "TAKAS", "TAKEN", "TAKER",
            "TAKES", "TAKIN", "TALAR", "TALAS", "TALCS", "TALER", "TALES", "TALKS", "TALKY", "TALLY", "TALON", "TALUK", "TALUS", "TAMAL", "TAMED", "TAMER", "TAMES",
            "TAMIS", "TAMMY", "TAMPS", "TANGO", "TANGS", "TANGY", "TANKA", "TANKS", "TANSY", "TANTO", "TAPAS", "TAPED", "TAPER", "TAPES", "TAPIR", "TAPIS", "TARDO",
            "TARDY", "TARED", "TARES", "TARGE", "TARNS", "TAROC", "TAROK", "TAROS", "TAROT", "TARPS", "TARRE", "TARRY", "TARSI", "TARTS", "TARTY", "TASKS", "TASSE",
            "TASTE", "TASTY", "TATAR", "TATER", "TATES", "TATTY", "TAUNT", "TAUPE", "TAUTS", "TAWED", "TAWER", "TAWIE", "TAWNY", "TAWSE", "TAXED", "TAXER", "TAXES",
            "TAXIS", "TAXON", "TAXUS", "TAZZA", "TAZZE", "TEACH", "TEAKS", "TEALS", "TEAMS", "TEARS", "TEARY", "TEASE", "TEATS", "TECHY", "TECTA", "TEDDY", "TEELS",
            "TEEMS", "TEENS", "TEENY", "TEETH", "TEFFS", "TEGUA", "TEIID", "TEIND", "TELAE", "TELES", "TELEX", "TELIA", "TELIC", "TELLS", "TELLY", "TELOI", "TELOS",
            "TEMPI", "TEMPO", "TEMPS", "TEMPT", "TENCH", "TENDS", "TENET", "TENGE", "TENIA", "TENON", "TENOR", "TENSE", "TENTH", "TENTS", "TENTY", "TEPAL", "TEPAS",
            "TEPEE", "TEPID", "TEPOY", "TERAI", "TERCE", "TERGA", "TERMS", "TERNE", "TERNS", "TERRA", "TERRY", "TERSE", "TESLA", "TESTA", "TESTS", "TESTY", "TETHS",
            "TETRA", "TEUCH", "TEUGH", "TEWED", "TEXAS", "TEXTS", "THACK", "THANE", "THANK", "THARM", "THAWS", "THEBE", "THECA", "THEFT", "THEGN", "THEIN", "THEIR",
            "THEME", "THENS", "THERE", "THERM", "THESE", "THETA", "THEWS", "THEWY", "THICK", "THIEF", "THIGH", "THILL", "THINE", "THING", "THINK", "THINS", "THIOL",
            "THIRD", "THIRL", "THOLE", "THONG", "THORN", "THORO", "THORP", "THOSE", "THOUS", "THRAW", "THREE", "THREW", "THRIP", "THROB", "THROE", "THROW", "THRUM",
            "THUDS", "THUGS", "THUJA", "THUMB", "THUMP", "THUNK", "THURL", "THUYA", "THYME", "THYMI", "THYMY", "TIARA", "TIBIA", "TICAL", "TICKS", "TIDAL", "TIDED",
            "TIDES", "TIERS", "TIFFS", "TIGER", "TIGHT", "TIGON", "TIKES", "TIKIS", "TILAK", "TILDE", "TILED", "TILER", "TILES", "TILLS", "TILTH", "TILTS", "TIMED",
            "TIMER", "TIMES", "TIMID", "TINCT", "TINEA", "TINED", "TINES", "TINGE", "TINGS", "TINNY", "TINTS", "TIPIS", "TIPPY", "TIPSY", "TIRED", "TIRES", "TIRLS",
            "TIROS", "TITAN", "TITER", "TITHE", "TITIS", "TITLE", "TITRE", "TITTY", "TIZZY", "TOADS", "TOADY", "TOAST", "TODAY", "TODDY", "TOEAS", "TOFFS", "TOFFY",
            "TOFTS", "TOFUS", "TOGAE", "TOGAS", "TOGUE", "TOILE", "TOILS", "TOITS", "TOKAY", "TOKED", "TOKEN", "TOKER", "TOKES", "TOLAN", "TOLAR", "TOLAS", "TOLED",
            "TOLES", "TOLLS", "TOLUS", "TOLYL", "TOMAN", "TOMBS", "TOMES", "TOMMY", "TONAL", "TONDI", "TONDO", "TONED", "TONER", "TONES", "TONEY", "TONGA", "TONGS",
            "TONIC", "TONNE", "TONUS", "TOOLS", "TOONS", "TOOTH", "TOOTS", "TOPAZ", "TOPED", "TOPEE", "TOPER", "TOPES", "TOPHE", "TOPHI", "TOPHS", "TOPIC", "TOPIS",
            "TOPOI", "TOPOS", "TOQUE", "TORAH", "TORAS", "TORCH", "TORCS", "TORES", "TORIC", "TORII", "TOROS", "TOROT", "TORSE", "TORSI", "TORSK", "TORSO", "TORTE",
            "TORTS", "TORUS", "TOTAL", "TOTED", "TOTEM", "TOTER", "TOTES", "TOUCH", "TOUGH", "TOURS", "TOUSE", "TOUTS", "TOWED", "TOWEL", "TOWER", "TOWIE", "TOWNS",
            "TOWNY", "TOXIC", "TOXIN", "TOYED", "TOYER", "TOYON", "TOYOS", "TRACE", "TRACK", "TRACT", "TRADE", "TRAGI", "TRAIK", "TRAIL", "TRAIN", "TRAIT", "TRAMP",
            "TRAMS", "TRANK", "TRANQ", "TRANS", "TRAPS", "TRAPT", "TRASH", "TRASS", "TRAVE", "TRAWL", "TRAYS", "TREAD", "TREAT", "TREED", "TREEN", "TREES", "TREKS",
            "TREND", "TRESS", "TRETS", "TREWS", "TREYS", "TRIAC", "TRIAD", "TRIAL", "TRIBE", "TRICE", "TRICK", "TRIED", "TRIER", "TRIES", "TRIGO", "TRIGS", "TRIKE",
            "TRILL", "TRIMS", "TRINE", "TRIOL", "TRIOS", "TRIPE", "TRIPS", "TRITE", "TROAK", "TROCK", "TRODE", "TROIS", "TROKE", "TROLL", "TROMP", "TRONA", "TRONE",
            "TROOP", "TROOZ", "TROPE", "TROTH", "TROTS", "TROUT", "TROVE", "TROWS", "TROYS", "TRUCE", "TRUCK", "TRUED", "TRUER", "TRUES", "TRUGS", "TRULL", "TRULY",
            "TRUMP", "TRUNK", "TRUSS", "TRUST", "TRUTH", "TRYMA", "TRYST", "TSADE", "TSADI", "TSARS", "TSKED", "TSUBA", "TUBAE", "TUBAL", "TUBAS", "TUBBY", "TUBED",
            "TUBER", "TUBES", "TUCKS", "TUFAS", "TUFFS", "TUFTS", "TUFTY", "TULES", "TULIP", "TULLE", "TUMID", "TUMMY", "TUMOR", "TUMPS", "TUNAS", "TUNED", "TUNER",
            "TUNES", "TUNGS", "TUNIC", "TUNNY", "TUPIK", "TUQUE", "TURBO", "TURDS", "TURFS", "TURFY", "TURKS", "TURNS", "TURPS", "TUSHY", "TUSKS", "TUTEE", "TUTOR",
            "TUTTI", "TUTTY", "TUTUS", "TUXES", "TUYER", "TWAES", "TWAIN", "TWANG", "TWATS", "TWEAK", "TWEED", "TWEEN", "TWEET", "TWERP", "TWICE", "TWIER", "TWIGS",
            "TWILL", "TWINE", "TWINS", "TWINY", "TWIRL", "TWIRP", "TWIST", "TWITS", "TWIXT", "TWYER", "TYEES", "TYERS", "TYING", "TYIYN", "TYKES", "TYNED", "TYNES",
            "TYPAL", "TYPED", "TYPES", "TYPEY", "TYPIC", "TYPOS", "TYPPS", "TYRED", "TYRES", "TYROS", "TYTHE", "TZARS", "UDDER", "UHLAN", "UKASE", "ULAMA", "ULANS",
            "ULCER", "ULEMA", "ULNAD", "ULNAE", "ULNAR", "ULNAS", "ULPAN", "ULTRA", "ULVAS", "UMBEL", "UMBER", "UMBOS", "UMBRA", "UMIAC", "UMIAK", "UMIAQ", "UMPED",
            "UNAIS", "UNAPT", "UNARM", "UNARY", "UNAUS", "UNBAN", "UNBAR", "UNBID", "UNBOX", "UNCAP", "UNCIA", "UNCLE", "UNCOS", "UNCOY", "UNCUS", "UNCUT", "UNDEE",
            "UNDER", "UNDID", "UNDUE", "UNFED", "UNFIT", "UNFIX", "UNGOT", "UNHAT", "UNHIP", "UNIFY", "UNION", "UNITE", "UNITS", "UNITY", "UNJAM", "UNLAY", "UNLED",
            "UNLET", "UNLIT", "UNMAN", "UNMET", "UNMEW", "UNMIX", "UNPEG", "UNPEN", "UNPIN", "UNRIG", "UNRIP", "UNSAY", "UNSET", "UNSEW", "UNSEX", "UNTIE", "UNTIL",
            "UNWED", "UNWIT", "UNWON", "UNZIP", "UPBOW", "UPBYE", "UPDOS", "UPDRY", "UPEND", "UPLIT", "UPPED", "UPPER", "UPSET", "URAEI", "URARE", "URARI", "URASE",
            "URATE", "URBAN", "URBIA", "UREAL", "UREAS", "UREDO", "UREIC", "URGED", "URGER", "URGES", "URIAL", "URINE", "URSAE", "USAGE", "USERS", "USHER", "USING",
            "USNEA", "USQUE", "USUAL", "USURP", "USURY", "UTERI", "UTILE", "UTTER", "UVEAL", "UVEAS", "UVULA", "VACUA", "VAGAL", "VAGUE", "VAGUS", "VAILS", "VAIRS",
            "VAKIL", "VALES", "VALET", "VALID", "VALOR", "VALSE", "VALUE", "VALVE", "VAMPS", "VANDA", "VANED", "VANES", "VANGS", "VAPID", "VAPOR", "VARAS", "VARIA",
            "VARIX", "VARNA", "VARUS", "VARVE", "VASAL", "VASES", "VASTS", "VASTY", "VATIC", "VATUS", "VAULT", "VAUNT", "VEALS", "VEALY", "VEENA", "VEEPS", "VEERS",
            "VEERY", "VEGAN", "VEGIE", "VEILS", "VEINS", "VEINY", "VELAR", "VELDS", "VELDT", "VELUM", "VENAE", "VENAL", "VENDS", "VENGE", "VENIN", "VENOM", "VENTS",
            "VENUE", "VERBS", "VERGE", "VERSE", "VERSO", "VERST", "VERTS", "VERTU", "VERVE", "VESTA", "VESTS", "VETCH", "VEXED", "VEXER", "VEXES", "VEXIL", "VIALS",
            "VIAND", "VIBES", "VICAR", "VICED", "VICES", "VICHY", "VIDEO", "VIERS", "VIEWS", "VIEWY", "VIGAS", "VIGIL", "VIGOR", "VILER", "VILLA", "VILLI", "VILLS",
            "VIMEN", "VINAL", "VINAS", "VINCA", "VINED", "VINES", "VINIC", "VINOS", "VINYL", "VIOLA", "VIOLS", "VIPER", "VIRAL", "VIREO", "VIRES", "VIRGA", "VIRID",
            "VIRLS", "VIRTU", "VIRUS", "VISAS", "VISED", "VISES", "VISIT", "VISOR", "VISTA", "VITAE", "VITAL", "VITTA", "VIVAS", "VIVID", "VIXEN", "VIZIR", "VIZOR",
            "VOCAL", "VOCES", "VODKA", "VODUN", "VOGIE", "VOGUE", "VOICE", "VOIDS", "VOILA", "VOILE", "VOLAR", "VOLED", "VOLES", "VOLTA", "VOLTE", "VOLTI", "VOLTS",
            "VOLVA", "VOMER", "VOMIT", "VOTED", "VOTER", "VOTES", "VOUCH", "VOWED", "VOWEL", "VOWER", "VROOM", "VROUW", "VROWS", "VUGGS", "VUGGY", "VUGHS", "VULGO",
            "VULVA", "VYING", "WACKE", "WACKO", "WACKS", "WACKY", "WADDY", "WADED", "WADER", "WADES", "WADIS", "WAFER", "WAFFS", "WAFTS", "WAGED", "WAGER", "WAGES",
            "WAGON", "WAHOO", "WAIFS", "WAILS", "WAINS", "WAIRS", "WAIST", "WAITS", "WAIVE", "WAKED", "WAKEN", "WAKER", "WAKES", "WALDO", "WALED", "WALER", "WALES",
            "WALKS", "WALLA", "WALLS", "WALLY", "WALTZ", "WAMES", "WAMUS", "WANDS", "WANED", "WANES", "WANEY", "WANLY", "WANTS", "WARDS", "WARED", "WARES", "WAREZ",
            "WARKS", "WARMS", "WARNS", "WARPS", "WARTS", "WARTY", "WASHY", "WASPS", "WASPY", "WASTE", "WASTS", "WATAP", "WATCH", "WATER", "WATTS", "WAUGH", "WAUKS",
            "WAULS", "WAVED", "WAVER", "WAVES", "WAVEY", "WAWLS", "WAXED", "WAXEN", "WAXER", "WAXES", "WAZOO", "WEALD", "WEALS", "WEANS", "WEARS", "WEARY", "WEAVE",
            "WEBBY", "WEBER", "WECHT", "WEDEL", "WEDGE", "WEDGY", "WEEDS", "WEEDY", "WEEKS", "WEENS", "WEENY", "WEEPS", "WEEPY", "WEEST", "WEETS", "WEFTS", "WEIGH",
            "WEIRD", "WEIRS", "WEKAS", "WELCH", "WELDS", "WELLS", "WELLY", "WELSH", "WELTS", "WENCH", "WENDS", "WENNY", "WESTS", "WETLY", "WHACK", "WHALE", "WHAMO",
            "WHAMS", "WHANG", "WHAPS", "WHARF", "WHATS", "WHAUP", "WHEAL", "WHEAT", "WHEEL", "WHEEN", "WHEEP", "WHELK", "WHELM", "WHELP", "WHENS", "WHERE", "WHETS",
            "WHEWS", "WHEYS", "WHICH", "WHIDS", "WHIFF", "WHIGS", "WHILE", "WHIMS", "WHINE", "WHINS", "WHINY", "WHIPS", "WHIPT", "WHIRL", "WHIRR", "WHIRS", "WHISH",
            "WHISK", "WHIST", "WHITE", "WHITS", "WHITY", "WHIZZ", "WHOLE", "WHOMP", "WHOOF", "WHOOP", "WHOPS", "WHORE", "WHORL", "WHORT", "WHOSE", "WHOSO", "WHUMP",
            "WICKS", "WIDDY", "WIDEN", "WIDER", "WIDES", "WIDOW", "WIDTH", "WIELD", "WIFED", "WIFES", "WIFTY", "WIGAN", "WIGGY", "WIGHT", "WILCO", "WILDS", "WILED",
            "WILES", "WILLS", "WILLY", "WILTS", "WIMPS", "WIMPY", "WINCE", "WINCH", "WINDS", "WINDY", "WINED", "WINES", "WINEY", "WINGS", "WINGY", "WINKS", "WINOS",
            "WINZE", "WIPED", "WIPER", "WIPES", "WIRED", "WIRER", "WIRES", "WIRRA", "WISED", "WISER", "WISES", "WISHA", "WISPS", "WISPY", "WISTS", "WITAN", "WITCH",
            "WITED", "WITES", "WITHE", "WITHY", "WITTY", "WIVED", "WIVER", "WIVES", "WIZEN", "WIZES", "WOADS", "WOALD", "WODGE", "WOFUL", "WOKEN", "WOLDS", "WOLFS",
            "WOMAN", "WOMBS", "WOMBY", "WOMEN", "WONKS", "WONKY", "WONTS", "WOODS", "WOODY", "WOOED", "WOOER", "WOOFS", "WOOLS", "WOOLY", "WOOPS", "WOOSH", "WOOZY",
            "WORDS", "WORDY", "WORKS", "WORLD", "WORMS", "WORMY", "WORRY", "WORSE", "WORST", "WORTH", "WORTS", "WOULD", "WOUND", "WOVEN", "WOWED", "WRACK", "WRANG",
            "WRAPS", "WRAPT", "WRATH", "WREAK", "WRECK", "WRENS", "WREST", "WRICK", "WRIED", "WRIER", "WRIES", "WRING", "WRIST", "WRITE", "WRITS", "WRONG", "WROTE",
            "WROTH", "WRUNG", "WRYER", "WRYLY", "WURST", "WUSSY", "WYLED", "WYLES", "WYNDS", "WYNNS", "WYTED", "WYTES", "XEBEC", "XENIA", "XENIC", "XENON", "XERIC",
            "XEROX", "XERUS", "XYLAN", "XYLEM", "XYLOL", "XYLYL", "XYSTI", "XYSTS", "YACHT", "YACKS", "YAFFS", "YAGER", "YAGIS", "YAHOO", "YAIRD", "YAMEN", "YAMUN",
            "YANGS", "YANKS", "YAPOK", "YAPON", "YAPPY", "YARDS", "YARER", "YARNS", "YAUDS", "YAULD", "YAUPS", "YAWED", "YAWLS", "YAWNS", "YAWPS", "YEANS", "YEARN",
            "YEARS", "YEAST", "YECCH", "YECHS", "YECHY", "YEGGS", "YELKS", "YELLS", "YELPS", "YENTA", "YENTE", "YERBA", "YERKS", "YESES", "YETIS", "YETTS", "YEUKS",
            "YEUKY", "YIELD", "YIKES", "YILLS", "YINCE", "YIPES", "YIRDS", "YIRRS", "YIRTH", "YLEMS", "YOBBO", "YOCKS", "YODEL", "YODHS", "YODLE", "YOGAS", "YOGEE",
            "YOGHS", "YOGIC", "YOGIN", "YOGIS", "YOKED", "YOKEL", "YOKES", "YOLKS", "YOLKY", "YOMIM", "YONIC", "YONIS", "YORES", "YOUNG", "YOURN", "YOURS", "YOUSE",
            "YOUTH", "YOWED", "YOWES", "YOWIE", "YOWLS", "YUANS", "YUCAS", "YUCCA", "YUCCH", "YUCKS", "YUCKY", "YUGAS", "YULAN", "YULES", "YUMMY", "YUPON", "YURTA",
            "YURTS", "ZAIRE", "ZAMIA", "ZANZA", "ZAPPY", "ZARFS", "ZAXES", "ZAYIN", "ZAZEN", "ZEALS", "ZEBEC", "ZEBRA", "ZEBUS", "ZEINS", "ZERKS", "ZEROS", "ZESTS",
            "ZESTY", "ZETAS", "ZIBET", "ZILCH", "ZILLS", "ZINCS", "ZINCY", "ZINEB", "ZINGS", "ZINGY", "ZINKY", "ZIPPY", "ZIRAM", "ZITIS", "ZIZIT", "ZLOTE", "ZLOTY",
            "ZOEAE", "ZOEAL", "ZOEAS", "ZOMBI", "ZONAL", "ZONED", "ZONER", "ZONES", "ZONKS", "ZOOID", "ZOOKS", "ZOOMS", "ZOONS", "ZOOTY", "ZORCH", "ZORIL", "ZORIS",
            "ZOWIE", "ZYMES");
            $fiveletterwordlistlen = count($fiveletterwordlist);

            $charlist = array (
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
            $charlistlen = count($charlist);


            /**
             * File Operations
             */

            // With thanks to the moodle.org blocks forum people. :)

            // The next line points to the default location and file - change if you absolutely have to.
            $customfile = $CFG->dirroot . '/blocks/ekg/custom.txt';

            // Check if it is a file and not a folder or a banana.
            if (!is_file($customfile)) {
                $customwordlist = 'Warning: '.$customfile .' is NOT a file.';
                $customwordlistlen = 1;
            } else {
                // Check if it exists.
                if (!file_exists($customfile)) {
                    $customwordlist = 'Warning: '.$customfile . ' does NOT exit.';
                    $customwordlistlen = 1;
                } else {
                    // Basic checks complete, load in the file. Could probably do with more checks, file size, line length etc.
                    $customwordlist = file($customfile);
                    $customwordlistlen = count($customwordlist);
                } // end of file exists
            } // end of is file


            /**
             * String assembly
             */
            $result = '';
            $interim = '';

            // FOR loop for number of keys.
            for ($j=1; $j <= $this->config->block_ekg_number_of_keys; $j++) {

                // Add the prefix, even if empty. Probably quicker to add an empty string than to check if it's empty and add it if not.
                $result .= $this->config->block_ekg_prefix;

                // Initialise Count for the hybrid key type
                $count=0;

                // FOR loop which iterates through the number of blocks or words required.
                for ($i=1; $i <= $this->config->block_ekg_blocks_or_words; $i++) {

                    // Get a word or block of characters as required.
                    switch ($this->config->block_ekg_key_type) {
                        case 'three':
                            $interim = getitem($threeletterwordlist, $threeletterwordlistlen);
                        break;
                        case 'four':
                            $interim = getitem($fourletterwordlist, $fourletterwordlistlen);
                        break;
                        case 'five':
                            $interim = getitem($fiveletterwordlist, $fiveletterwordlistlen);
                        break;
                        case 'rand':
                            for($k=1; $k <= $this->config->block_ekg_chars_per_block; $k++) {
                                $interim .= getitem($charlist, $charlistlen);
                            }
                        break;
                        case 'rand_numeric':
                            for($k=1; $k <= $this->config->block_ekg_chars_per_block; $k++) {
                                $interim .= rand(0,9);
                            }
                        break;
                        case 'md5':
                            $interim .= substr(getmd5(), ($i-1) * $this->config->block_ekg_blocks_or_words, $this->config->block_ekg_chars_per_block);
                        break;
                        case 'custom':
                            $interim = getitem($customwordlist, $customwordlistlen);
                        break;
                        case 'hybrid':
                            $count++;
                            switch ($this->config->block_ekg_hybrid_structure) {
                                case 'three-four-five':
                                    if ($count==1) {
                                        $interim = getitem($threeletterwordlist, $threeletterwordlistlen);
                                    } elseif($count==2) {
                                        $interim = getitem($fourletterwordlist, $fourletterwordlistlen);
                                    } elseif($count==3) {
                                        $interim = getitem($fiveletterwordlist, $fiveletterwordlistlen);
                                    }
                                break;
                                case 'five-four-three':
                                    if ($count==1) {
                                        $interim = getitem($fiveletterwordlist, $fiveletterwordlistlen);
                                    } elseif($count==2) {
                                        $interim = getitem($fourletterwordlist, $fourletterwordlistlen);
                                    } elseif($count==3) {
                                        $interim = getitem($threeletterwordlist, $threeletterwordlistlen);
                                    }
                                break;
                                case 'three-number-five':
                                    if ($count==1) {
                                        $interim = getitem($threeletterwordlist, $threeletterwordlistlen);
                                    } elseif($count==2) {
                                        $interim = rand(0,9);
                                    } elseif($count==3) {
                                        $interim = getitem($fiveletterwordlist, $fiveletterwordlistlen);
                                    }
                                break;
                                case 'five-number-three':
                                    if ($count==1) {
                                        $interim = getitem($fiveletterwordlist, $fiveletterwordlistlen);
                                    } elseif($count==2) {
                                        $interim = rand(0,9);
                                    } elseif($count==3) {
                                        $interim = getitem($threeletterwordlist, $threeletterwordlistlen);
                                    }
                                break;
                                case 'three-numbernumber-five':
                                    if ($count==1) {
                                        $interim = getitem($threeletterwordlist, $threeletterwordlistlen);
                                    } elseif($count==2) {
                                        $interim = rand(0,9).rand(0,9);
                                    } elseif($count==3) {
                                        $interim = getitem($fiveletterwordlist, $fiveletterwordlistlen);
                                    }
                                break;
                                case 'five-numbernumber-three':
                                    if ($count==1) {
                                        $interim = getitem($fiveletterwordlist, $fiveletterwordlistlen);
                                    } elseif($count==2) {
                                        $interim = rand(0,9).rand(0,9);
                                    } elseif($count==3) {
                                        $interim = getitem($threeletterwordlist, $threeletterwordlistlen);
                                    }
                                break;
                                case 'custom-number-custom':
                                    if ($count==1) {
                                        $interim = getitem($customwordlist, $customwordlistlen);
                                    } elseif($count==2) {
                                        $interim = rand(0,9);
                                    } elseif($count==3) {
                                        $interim = getitem($customwordlist, $customwordlistlen);
                                    }
                                break;
                                case 'custom-numbernumber-custom':
                                    if ($count==1) {
                                        $interim = getitem($customwordlist, $customwordlistlen);
                                    } elseif($count==2) {
                                        $interim = rand(0,9).rand(0,9);
                                    } elseif($count==3) {
                                        $interim = getitem($customwordlist, $customwordlistlen);
                                    }
                                break;
                            }
                        break;
                    }

                    // $interim gets transformed if required.
                    $result .= transform_text($interim, $this->config->block_ekg_text_transform);
                    $interim = "";

                    // If we're not done yet, add the separator, even if empty.
                    if ($i <> $this->config->block_ekg_blocks_or_words) {
                        $result .= $this->config->block_ekg_separator;
                    }
                }

                // Add the suffix, even if empty.
                $result .= $this->config->block_ekg_suffix;

                // Add in a HTML line break and a newline too.
                if ($j <> $this->config->block_ekg_number_of_keys) {
                    $result .= "<br />\n";
                }

            } // END for loop for number of keys

            /**
             * Sorting out the footer
             */
             
            $words_in_list = '';
            switch ($this->config->block_ekg_key_type) {
                case 'three':
                    $words_in_list = $threeletterwordlistlen;
                break;
                case 'four':
                    $words_in_list  = $fourletterwordlistlen;
                break;
                case 'five':
                    $words_in_list  = $fiveletterwordlistlen;
                break;
                case 'custom':
                    $words_in_list  = $customwordlistlen;
                break;
            }
            
            switch ($CFG->block_ekg_footer) {
                case 'words':
                    if ($words_in_list != 0 && $words_in_list != '') {
                        $footer_result = '<hr />'.get_string('pre-result', 'block_ekg').$words_in_list.get_string('post-result', 'block_ekg')."\n";
                    } else {
                        $footer_result = '';
                    }
                break;
                case 'refresh':
                    if ($this->config->block_ekg_number_of_keys == 1) { 
                        // singular: this is an easy way of doing it.
                        $footer_result = '<hr /><a href="#" onClick="window.location.reload()">'.get_string('footer-s', 'block_ekg').'</a>'."\n";
                    } else { 
                        // plural
                        $footer_result = '<hr /><a href="#" onClick="window.location.reload()">'.get_string('footer-p', 'block_ekg').'</a>'."\n";
                    }
                break;
                case 'both':
                    /**
                     * I really should write this bit better :(
                     */
                    // words
                    if ($words_in_list != 0 && $words_in_list != '') {
                        $footer_result = '<hr />'.get_string('pre-result', 'block_ekg').$words_in_list.get_string('post-result', 'block_ekg').'<br />'."\n";
                    } else {
                        $footer_result = '';
                    }
                    // 'refresh'
                    if ($this->config->block_ekg_number_of_keys == 1) { 
                        // singular: this is an easy way of doing it.
                        $footer_result .= '<a href="#" onClick="window.location.reload()">'.get_string('footer-s', 'block_ekg').'</a>'."\n";
                    } else { 
                        // plural
                        $footer_result .= '<a href="#" onClick="window.location.reload()">'.get_string('footer-p', 'block_ekg').'</a>'."\n";
                    }
                break;
                case 'none':
                    $footer_result = '';
                break;
                default:
                    $footer_result = get_string('footer-error', 'block_ekg');
                break;
            }
          
            /**
             * This section sorts out the output to screen.
             */
            $this->content = new stdClass;
            $this->content->text = '<div class="info">'.$result.'</div>';
            $this->content->footer = $footer_result;

            // Leave this in, its vital!!
            return $this->content;

        } // end of if (isloggedin() && !isguestuser()) statement

    } // end of get_content() function

} // end of block_ekg class
?>