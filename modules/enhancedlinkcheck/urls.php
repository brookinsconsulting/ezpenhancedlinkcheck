<?php
/**
 * File containing the urls.php module view
 *
 * @copyright Copyright (C) 1999 - 2014 Brookins Consulting. All rights reserved.
 * @copyright Copyright (C) 2013 - 2014 Think Creative. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2 (or any later version)
 * @version //autogentag//
 * @package ezpenhancedlinkcheck
 */

$ModuleTools = ModuleTools::initialize( $Params );

$Database = eZDB::instance();

$cObjAttrVersionColumn = eZPersistentObject::getShortAttributeName(
    $Database, eZURLObjectLink::definition(), 'contentobject_attribute_version'
);

$RecordsCountSQL = "SELECT count(x.id) as count, x.* from (SELECT DISTINCT ezurl.*, ezcontentobject.remote_id,
    CONCAT (CASE
    WHEN is_valid = 0
    THEN  'Invalid'
    WHEN is_valid = 1
    THEN  'Valid'
    ELSE  'N/A'
    END , ' ',
    CASE
    WHEN path_string REGEXP  '/99/'
    THEN  'SARE Nationwide'
    WHEN path_string REGEXP  '/100/'
    THEN  'North Central SARE'
    WHEN path_string REGEXP  '/101/'
    THEN  'Southern SARE'
    WHEN path_string REGEXP  '/102/'
    THEN  'Western SARE'
    WHEN path_string REGEXP  '/295/'
    THEN  'Northeast SARE'
    ELSE  'Unknown'
    END , ' ',
    CASE
    WHEN last_checked = 0
    THEN  'Never'
    ELSE  DATE_FORMAT( FROM_UNIXTIME( last_checked ) ,  '%m/%e/%Y %l:%i %p' )
    END, ' ',
    CASE
    WHEN ezurl.modified = 0
    THEN  '?'
    ELSE  DATE_FORMAT( FROM_UNIXTIME( ezurl.modified ) ,  '%m/%e/%Y %l:%i %p' )
    END, ' ',
    CASE
    WHEN v.status = 0
    THEN  'Draft'
    WHEN v.status = 1
    THEN  'Published'
    ELSE  'Pending'
    END, ' ',
    url) as matchme
    FROM
        ezurl,
        ezurl_object_link,
        ezcontentobject_attribute,
        ezcontentobject_version v,
        ezcontentobject_tree,
        ezcontentobject
    WHERE ezurl.id = ezurl_object_link.url_id
    AND v.status < 3
    AND ezcontentobject.id = ezcontentobject_tree.contentobject_id
    AND ezurl_object_link.contentobject_attribute_id = ezcontentobject_attribute.id
    AND ezurl_object_link.$cObjAttrVersionColumn = ezcontentobject_attribute.version
    AND ezcontentobject_attribute.contentobject_id = v.contentobject_id
    AND ezcontentobject_attribute.version = ezcontentobject.current_version
    AND v.contentobject_id = ezcontentobject_tree.contentobject_id
    AND ezcontentobject_tree.is_invisible = 0
) x
";

$RecordsCount = (int) current(
    $Database->arrayQuery(
        $RecordsCountSQL,
        array(
            'column' => 'count',
        )
    )
);

return $ModuleTools->fetchResult( array(
    'list_count' => $RecordsCount,
));

?>