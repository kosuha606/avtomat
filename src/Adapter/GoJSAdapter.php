<?php

namespace Avtomat\Adapter;

class GoJSAdapter
{
    public function adapt($data)
    {
        $data['class'] = 'go.GraphLinksModel';
        $data['nodeCategoryProperty'] = 'type';
        $data['linkFromPortIdProperty'] = 'frompid';
        $data['linkToPortIdProperty'] = 'topid';

        $nodeDataArray = [];
        foreach ($data['objects'] as $object) {
            $split = explode('::', $object['name']);
            $nodeDataArray[] = [
                'type' => $split[0],
                'key' => $object['name'],
                'name' => $split[0]
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

//        echo '<pre>';
//        var_dump($data);
//        echo '</pre>';
        return $data;
    }
}