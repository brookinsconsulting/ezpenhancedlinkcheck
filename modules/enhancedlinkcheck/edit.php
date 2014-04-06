<?php
/**
 * File containing the edit.php module view
 *
 * @copyright Copyright (C) 1999 - 2014 Brookins Consulting. All rights reserved.
 * @copyright Copyright (C) 2013 - 2014 Think Creative. All rights reserved.
 * @copyright Copyright (C) 1999 - 2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2 (or any later version)
 * @version //autogentag//
 * @package ezpenhancedlinkcheck
 */

$Module = $Params['Module'];
$urlID = null;
if ( isset( $Params["ID"] ) )
    $urlID = $Params["ID"];

if ( is_numeric( $urlID ) )
{
    $url = eZURL::fetch( $urlID );
    if ( !$url )
    {
        return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
    }
}
else
{
    return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
}

$http = eZHTTPTool::instance();
if ( $Module->isCurrentAction( 'Cancel' ) )
{
    if( isset( $_REQUEST['offset'] ) or isset( $_REQUEST['limit'] ) or isset( $_REQUEST['sSearch'] ) )
    {
        if( isset( $_REQUEST['sSearch'] ) && $_REQUEST['sSearch'] != '' )
        {
            $Module->redirectTo('/enhancedlinkcheck/urls?offset=' . $_REQUEST['offset'] . '&limit=' . $_REQUEST['limit'] . '&sSearch=' . $_REQUEST['sSearch'] );
        }
        else
        {
            $Module->redirectTo('/enhancedlinkcheck/urls?offset=' . $_REQUEST['offset'] . '&limit=' . $_REQUEST['limit']);
        }
    }
    else
    {
        $Module->redirectToView( 'urls' );
    }
    return;
}

if ( $Module->isCurrentAction( 'Store' ) )
{
    if ( $http->hasPostVariable( 'link' ) )
    {
        $link = $http->postVariable( 'link' );
        $url->setAttribute( 'url', $link );

        /* Reset Last Modified Date */
        $url->setModified();

        $url->store();

        /* Reset Last Checked Date */
        eZURL::setLastChecked( $urlID, false );

        eZURLObjectLink::clearCacheForObjectLink( $urlID );
    }

    if( isset( $_REQUEST['offset'] ) or isset( $_REQUEST['limit'] ) or isset( $_REQUEST['sSearch'] ) )
    {
        if( isset( $_REQUEST['sSearch'] ) && $_REQUEST['sSearch'] != '' )
        {
            $Module->redirectTo('/enhancedlinkcheck/urls?offset=' . $_REQUEST['offset'] . '&limit=' . $_REQUEST['limit'] . '&sSearch=' . $_REQUEST['sSearch'] );
        }
        else
        {
            $Module->redirectTo('/enhancedlinkcheck/urls?offset=' . $_REQUEST['offset'] . '&limit=' . $_REQUEST['limit']);
        }
    }
    else
    {
        $Module->redirectToView( 'urls' );
    }
    return;
}

$Module->setTitle( "Edit link " . $url->attribute( "id" ) );

// Template handling

$tpl = eZTemplate::factory();

$tpl->setVariable( "Module", $Module );
$tpl->setVariable( "url", $url );

$Result = array();
$Result['content'] = $tpl->fetch( "design:enhancedlinkcheck/edit.tpl" );
$Result['path'] = array( array( 'url' => '/enhancedlinkcheck/edit/',
                                'text' => ezpI18n::tr( 'kernel/url', 'URL edit' ) ) );

?>