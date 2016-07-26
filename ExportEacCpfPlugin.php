<?php
 
class ExportEacCpfPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_filters = array('action_contexts', 'response_contexts');

    public function filterActionContexts($contexts, $args){
        $controller = $args['controller'];
        $params = $controller->getAllParams();
        if($params['controller'] == 'items') {
                // checks if the given key or index exists in the array
            if(array_key_exists('id', $params)) {
                $item = get_record_by_id("item",$params['id']);
                if(!is_null($item)) {
                    // exclude Bibliography collection
                    $collection = get_record_by_id("collection", $item['collection_id']);
                    $collectionName = metadata($collection, array('Dublin Core', 'Title'));
                    if($collectionName != 'Bibliographie'){// && $collectionName != '*'){
                        $contexts['show'][] = 'eaccpf';
                    }
                }
            }
        }

        return $contexts;
    }

    public function filterResponseContexts($contexts)
    {
        $contexts['eaccpf'] = array('suffix' => 'eaccpf','headers' => array('Content-Type' => 'application/xml'));
        return $contexts;
    }
}

?>