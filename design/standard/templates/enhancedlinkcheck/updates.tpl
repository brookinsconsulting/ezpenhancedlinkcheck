{*  *}
<div class="content-view-full">
<header><h1>Recent Updates</h1></header>
<div class="content-view-children">
{include name=navigator
    uri='design:navigator/google.tpl'
    page_uri=$url_alias
    item_count=$nodes_count
    view_parameters=$view_parameters
    item_limit=$limit
}

{foreach $nodes as $node}
{node_view_gui view='line' content_node=$node}
{delimiter}{include uri="design:content/datatype/view/ezxmltags/separator.tpl"}{/delimiter}
{/foreach}

{include name=navigator
    uri='design:navigator/google.tpl'
    page_uri=$url_alias
    item_count=$nodes_count
    view_parameters=$view_parameters
    item_limit=$limit
}
</div>
</div>