#!/bin/bash

# File containing the runcronjobpart-ezpenhancedlinkcheck.sh script.
#
# @copyright Copyright (C) 1999 - 2014 Brookins Consulting. All rights reserved.
# @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2 (or any later version)
# @version //autogentag//
# @package ezpenhancedlinkcheck

# php ./runcronjobs.php -dall ezpenhancedlinkcheck;
# php ./runcronjobs.php -dall ezpenhancedlinkcheck | tee var/log/cie.log;

php ./runcronjobs.php -dall ezpenhancedlinkcheck | tee var/log/cie.log
