<?php


class pageBuilderToEvoSearch
{
    private $modx;
    private $pageBuilderPath;
    private $indexFieldTypes = ['text','textarea','richtext'];
    private $indexOnlyAllowed;


    public function __construct(\DocumentParser $modx,$indexOnlyAllowed = 'no')
    {
        $this->modx = $modx;
        $this->pageBuilderPath = MODX_BASE_PATH . 'assets/plugins/pagebuilder/config/';
        $this->indexOnlyAllowed = $indexOnlyAllowed == 'yes'?true:false;
    }


    private function getData($config, $values,$content )
    {


        foreach ($values as $key => $value) {
            if (is_array($value)) {
                $cfg = isset($config[$key])?$config[$key]['fields']:$config;
                $content = $this->getData($cfg, $value,$content);
            } else {
                $fieldType = $config[$key]['type'];

                $index = isset($config[$key]['evoSearchIndex']) ? $config[$key]['evoSearchIndex'] : false;
                if(
                    !in_array($fieldType,$this->indexFieldTypes) ||
                    ($this->indexOnlyAllowed === true && $index === false)
                ){
                    continue;
                }

                $value = $this->modx->stripTags($value);
                if(!empty($value)){
                    $content .= ' '.$value;
                }
            }
        }

        return $content;
    }


    public function getDataForIndex($docId){
        $blocks = $this->getBlocks($docId);
        $content = '';
        foreach ($blocks as $block) {

            $configFile = $this->pageBuilderPath . $block['config'] . '.php';

            if (!file_exists($configFile)) {
                continue;
            }
            $config = require $configFile;

            $fields = $config['fields'];
            $values = json_decode($block['values'], true);

            $content = $this->getData($fields,$values,$content);
        }
        return $content;
    }

    public function getBlocks($docId){
        $table = $this->modx->getFullTableName('pagebuilder');
        return $this->modx->db->makeArray($this->modx->db->select('*', $table, 'document_id = '.intval($docId)));
    }
}