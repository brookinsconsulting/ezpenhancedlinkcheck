<?php
/**
 * File containing the enhancedlinkcheck module configuration file, module.php
 *
 * @copyright Copyright (C) 1999 - 2014 Brookins Consulting. All rights reserved.
 * @copyright Copyright (C) 2013 - 2014 Think Creative. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2 (or any later version)
 * @version //autogentag//
 * @package ezpenhancedlinkcheck
 */

// Define module name
$Module=array(
    'name'=>'Enhanced Link Check',
    'variable_params'=>true
    );

// Define module view and parameters
$ViewList = array();

// Define 'urls' module view parameters
$ViewList['urls'] = array(
    'name'=>'Site URLs',
    'script'=>'urls.php',
    'params'=>array('ViewMode'),
    'unordered_params'=>array('offset'=>'Offset','limit'=>'Limit'),
    'default_navigation_part'=>'ezenhancedlinkchecknavigationpart'
);

// Define 'urllist' module view parameters
$ViewList['urllist'] = array(
    'name'=>'Site URL List',
    'script'=>'urllist.php',
);

// Define 'listsubitems' module view parameters
$ViewList['listsubitems'] = array(
        'name'=>'Site URLs',
        'script'=>'listsubitems.php',
        'params'=>array(''),
        'unordered_params'=>array('page'=>'page', 'header'=>'header', 'children_view'=>'children_view', 'limit'=>'limit', 'stylize'=>'stylize', 'main_node'=>'main_node', 'alltext'=>'alltext'),
        'default_navigation_part'=>'ezenhancedlinkchecknavigationpart'
);

?>