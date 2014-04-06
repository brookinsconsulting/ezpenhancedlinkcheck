<?php
$ModuleTools = ModuleTools::instance($Module);
$RootNodeID=SiteUtils::configSetting('NodeSettings','RootNode','content.ini');
$Limit=10;
$Parameters=array(
    'SortBy'=>array($SortBy?$SortBy:'modified',false),
    'Depth'=>100,
    'Limit'=>$Limit
);
$ViewParameters=array(
    'offset'=>isset($Params['Offset'])?$Params['Offset']:null
    );

if($Class){
    $Parameters=array_merge($Parameters,array('ClassFilterType'=>'include','ClassFilterArray'=>explode(',',$Class)));
}
if(isset($Params['Offset'])){
    $Parameters=array_merge($Parameters,array('Offset'=>$Params['Offset']));
}

$Nodes=eZContentObjectTreeNode::subTreeByNodeID($Parameters,$RootNodeID);
$Params['Limit']=null;
$NodesCount=eZContentObjectTreeNode::subTreeCountByNodeID($Parameters,$RootNodeID);

$ModuleTools->setTemplateVariable('nodes',$Nodes);
$ModuleTools->setTemplateVariable('nodes_count',$NodesCount);
$ModuleTools->setTemplateVariable('view_parameters',$ViewParameters);
$ModuleTools->setTemplateVariable('limit',$Limit);
$ModuleTools->setTemplateVariable('url_alias','/enhancedlinkcheck/updates'.($SortBy?"/$SortBy":'').($Class?"/$Class":''));

return $ModuleTools->result();

?>