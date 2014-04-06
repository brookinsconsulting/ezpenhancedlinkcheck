<?php
/**
 * File containing the urllist.php module view
 *
 * @copyright Copyright (C) 1999 - 2014 Brookins Consulting. All rights reserved.
 * @copyright Copyright (C) 2013 - 2014 Think Creative. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2 (or any later version)
 * @version //autogentag//
 * @package ezpenhancedlinkcheck
 */

header('Content-Type: application/json');

$SiteAccessList = eZINI::instance('site.ini')->variable('SiteSettings', 'SiteList');

$RootNodeIDList = array();
$RootNodeList = array();
foreach($SiteAccessList as $SiteAccess) {
    $ContentINI = eZINI::instance('content.ini', "settings/siteaccess/$SiteAccess", false, false, false, true);
    if($ContentINI->hasGroup('NodeSettings') && $ContentINI->hasVariable('NodeSettings', 'RootNode')) {
        $RootNodeID = $ContentINI->variable('NodeSettings', 'RootNode');
        if(!in_array($RootNodeID, $RootNodeIDList)) {
            $RootNodeIDList[] = $RootNodeID;
            $RootNodeList[] = eZContentObjectTreeNode::fetch($RootNodeID);
        }
    }
}

$Database = eZDB::instance();

$cObjAttrVersionColumn = eZPersistentObject::getShortAttributeName(
    $Database, eZURLObjectLink::definition(), 'contentobject_attribute_version'
);

$Offset = $_REQUEST['iDisplayStart'];
$Limit = $_REQUEST['iDisplayLength'];
$sSearch = (isset($_REQUEST['sSearch'])) ? $_REQUEST['sSearch'] : false;

$sortcol = (isset($_REQUEST['iSortCol_0'])) ? $_REQUEST['iSortCol_0'] : false;
$sortdir = (isset($_REQUEST['sSortDir_0'])) ? $_REQUEST['sSortDir_0'] : false;

$sort_map = array('x.icon', 'x.region', 'x.stat', 'x.valid', 'x.chkdate', 'x.moddate', 'x.editme');


$RecordsCountSQL = "SELECT count(x.id) as count, x.* from (SELECT DISTINCT ezurl.*, ezcontentobject.remote_id,
    CONCAT (' ', CASE
    WHEN is_valid = 0
    THEN  'Invalid'
    WHEN is_valid = 1
    THEN  'Valid'
    ELSE  'N/A'
    END , ' ',
    replace(SUBSTR(path_identification_string,1,LOCATE('/', path_identification_string) -1), '_', ' ') , ' ',
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

$RecordsSQL = "SELECT x.icon, x.region, x.stat, x.valid, x.chkdate, x.moddate, x.editme from (SELECT DISTINCT";

if( $sSearch != '' )
{

$RecordsSQL .= "

    CONCAT(
    '<img width=\"16\" height=\"16\" title=\"URL\" alt=\"URL\" src=\"/share/icons/crystal-admin/16x16_indexed/apps/package_network.png\"> <a title=\"View information about URL.\" target=\"_blank\" href=\"/enhancedlinkcheck/urlview/' ,ezurl.id, '?offset=$Offset&limit=$Limit&sSearch=$sSearch', '\">',SUBSTRING(url,1,70), CASE WHEN CHAR_LENGTH(url) > 70 THEN  '...' ELSE '' END, '</a> (<a title=\"Open URL in new window.\" target=\"_blank\" href=\"' ,url, '\">open</a>)') as icon,
";

}
else
{

$RecordsSQL .= "

    CONCAT(
    '<img width=\"16\" height=\"16\" title=\"URL\" alt=\"URL\" src=\"/share/icons/crystal-admin/16x16_indexed/apps/package_network.png\"> <a title=\"View information about URL.\" target=\"_blank\" href=\"/enhancedlinkcheck/urlview/' ,ezurl.id, '?offset=$Offset&limit=$Limit', '\">',SUBSTRING(url,1,70), CASE WHEN CHAR_LENGTH(url) > 70 THEN  '...' ELSE '' END, '</a> (<a title=\"Open URL in new window.\" target=\"_blank\" href=\"' ,url, '\">open</a>)') as icon,
";

}

$RecordsSQL .= "
    replace(SUBSTR(path_identification_string,1,LOCATE('/', path_identification_string) -1), '_', ' ') as region,

    CASE
    WHEN v.status = 0
    THEN  'Draft'
    WHEN v.status = 1
    THEN  'Published'
    ELSE  'Pending'
    END as stat,

    CASE
    WHEN is_valid = 0
    THEN  'Invalid'
    WHEN is_valid = 1
    THEN  'Valid'
    ELSE  'N/A'
    END as valid,

    CASE
    WHEN last_checked = 0
    THEN  'Never'
    ELSE  DATE_FORMAT( FROM_UNIXTIME( last_checked ) ,  '%m/%e/%Y %l:%i %p' )
    END as chkdate,

    CASE
    WHEN ezurl.modified = 0
    THEN  '?'
    ELSE  DATE_FORMAT( FROM_UNIXTIME( ezurl.modified ) ,  '%m/%e/%Y %l:%i %p' )
    END as moddate,
";
if( $sSearch != '' )
{
    $RecordsSQL .=" concat('<a href=\"/enhancedlinkcheck/edit/',ezurl.id, '?offset=$Offset&limit=$Limit&sSearch=$sSearch','\"><img title=\"Edit URL.\" alt=\"Edit\" src=\"/design/standard/images/edit.gif\"></a>') as editme";
}
else
{
    $RecordsSQL .=" concat('<a href=\"/enhancedlinkcheck/edit/',ezurl.id, '?offset=$Offset&limit=$Limit','\"><img title=\"Edit URL.\" alt=\"Edit\" src=\"/design/standard/images/edit.gif\"></a>') as editme";
}
    $RecordsSQL .="
    ,
    CONCAT (' ',CASE
    WHEN is_valid = 0
    THEN  'Invalid'
    WHEN is_valid = 1
    THEN  'Valid'
    ELSE  'N/A'
    END , ' ',
    replace(SUBSTR(path_identification_string,1,LOCATE('/', path_identification_string) -1), '_', ' '), ' ',
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
    WHEN v.status = 2
    THEN  'Pending'
    WHEN v.status = 3
    THEN  'Archived'
    WHEN v.status = 4
    THEN  'Rejected'
    WHEN v.status = 5
    THEN  'Internal'
    WHEN v.status = 6
    THEN  'Repeat'
    ELSE  'Queued'
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
) x LIMIT $Offset, $Limit
";

if ($sSearch) {

    $RecordsSQL = str_replace(" LIMIT ", " WHERE x.matchme like '%$sSearch%' LIMIT ", $RecordsSQL);
    $RecordsCountSQL .= " WHERE x.matchme like '%$sSearch%'";
}

if ($sortcol !== false) {

    $sorval = $sort_map[$sortcol];
    $RecordsSQL = str_replace(" LIMIT ", " ORDER BY $sorval $sortdir  LIMIT ", $RecordsSQL);

}

$RecordsCount = (int) current(
    $Database->arrayQuery(
        $RecordsCountSQL,
        array(
            'column' => 'count',
        )
    )
);

$RecordsView = $Database->query(
    $RecordsSQL
);

$out = array();
while ($row = mysql_fetch_assoc($RecordsView)) {
    $out[] = array(
        $row['icon'], ucwords($row['region']), $row['stat'], $row['valid'], $row['chkdate'], $row['moddate'], $row['editme']
    );
}

$RecordsView = $out;


echo json_encode(
    array(
        'sEcho' => (int) $_REQUEST['sEcho'],
        'iTotalRecords' => $RecordsCount,
        'iTotalDisplayRecords' => $RecordsCount,
        'aaDataCount' => count($RecordsView),
        'aaData' => $RecordsView,
    )
);

eZExecution::cleanExit();

?>