<?php

namespace Avtomat\Adapter;

class GoJSAdapter
{
    /**
     * Адаптация внутреннего алгоритма ядра
     * к формату алгоритма GOJS
     * @param $data
     * @return mixed
     */
    public function adapt($data)
    {
        $data['class'] = 'go.GraphLinksModel';
        $data['nodeCategoryProperty'] = 'type';
        $data['linkFromPortIdProperty'] = 'frompid';
        $data['linkToPortIdProperty'] = 'topid';

        $nodeDataArray = [];
        foreach ($data['objects'] as $object) {
            $split = explode('::', $object['name']);
            $type = $split[0];
            $nodeDataArray[] = [
                'type' => $type,
                'key' => $object['name'],
                'name' => $object['name'],
                'arguments' => $object['arguments']
            ];
        }

        $data['nodeDataArray'] = $nodeDataArray;
        unset($data['objects']);

        $linkDataArray = [];
        foreach ($data['relations'] as $fromInput => $toInput) {
            $fromSplit = explode('_', $fromInput);
            $fromPid = $fromSplit[1];
            $from = $fromSplit[0];

            $toSplit = explode('_', $toInput);
            $toPid = $toSplit[1];
            $to = $toSplit[0];

            $linkDataArray[] = [
                'from' => $from,
                'frompid' => $fromPid,
                'to' => $to,
                'topid' => $toPid
            ];
        }

        $data['linkDataArray'] = $linkDataArray;
        unset($data['relations']);

        return $data;
    }

    /**
     * Восстановление алгоритма ядра
     * из алгоритма GOJS
     * @param $data
     */
    public function restore($data)
    {
        $result = ['objects'=> [], 'relations'=> []];

        foreach ($data['nodeDataArray'] as $object) {
            $result['objects'][] = [
                'name' => $object['key'],
                'arguments' => $object['arguments']
            ];
        }

        foreach ($data['linkDataArray'] as $relation) {
            $result['relations'][$relation['from'].'_'.$relation['frompid']] = $relation['to'].'_'.$relation['topid'];
        }
//
//        echo '<pre>';
//        print_r($result);
//        echo '</pre>';

        return $result;
    }
}