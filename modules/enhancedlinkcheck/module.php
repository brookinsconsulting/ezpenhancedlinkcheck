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
    // 'default_navigation_part'=>'ezenhancedlinkchecknavigationpart'
    'default_navigation_part'=>'ezsetupnavigationpart'
);

// Define 'urllist' module view parameters
$ViewList['urllist'] = array(
    'name'=>'Site URL List',
    'script'=>'urllist.php',
);

// Define 'updates' modure view parameters
$ViewList['updates'] = array(
    'name'=>'Recent Site Updates',
    'script'=>'updates.php',
    'params'=>array('SortBy','Class'),
    'unordered_params'=>array('offset'=>'Offset')
);

// Define 'edit' module view parameters
$ViewList['edit'] = array(
    'script' => 'edit.php',
    'ui_context' => 'edit',
    'default_navigation_part' => 'ezsetupnavigationpart',
    'single_post_actions' => array( 'Cancel' => 'Cancel',
                                    'Store' => 'Store' ),
    'params' => array( 'ID' ) );

// Define 'urlview' module view parameters
$ViewList['urlview'] = array(
    'script' => 'urlview.php',
    'default_navigation_part' => 'ezsetupnavigationpart',
    'single_post_actions' => array( 'EditObject' => 'EditObject' ),
    'params' => array( 'ID' ),
    'unordered_params'=> array( 'offset' => 'Offset' ) );

// Define 'listsubitems' module view parameters
$ViewList['listsubitems'] = array(
    'name'=>'Site URLs',
    'script'=>'listsubitems.php',
    'params'=>array(''),
    'unordered_params'=>array('page'=>'page', 'header'=>'header', 'children_view'=>'children_view', 'limit'=>'limit', 'stylize'=>'stylize', 'main_node'=>'main_node', 'alltext'=>'alltext'),
    'default_navigation_part'=>'ezenhancedlinkchecknavigationpart'
);

?>