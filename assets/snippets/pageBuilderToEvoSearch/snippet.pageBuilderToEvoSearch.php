<?php
require_once __DIR__.'/pageBuilderToEvoSearch.php';

$docId = $params['data']['id'];
$pageInfo = $modx->getPageInfo($docId,'','template');
$content = $params['data']['content'];
$templates = !empty($params['templates'])?explode(',',$params['templates']):[];

//не нужно индексировать этот шаблон
if(!empty($templates) && !in_array($pageInfo['template'],$templates)){
    return $content;
}

$pageBuilderToEvoSearch = new  pageBuilderToEvoSearch($modx,$params['index_only_allowed']);
$pbContent = $pageBuilderToEvoSearch->getDataForIndex($docId);
return ['content'=>$content.' '.$pbContent];
