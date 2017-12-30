<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$algoName = 'TestAlgo';
define('ALGO_ROOT', 'test/algorithms/');

require 'vendor/autoload.php';

if ($_GET) {
    if (isset($_GET['algorithm_name'])) {
        $algoName = $_GET['algorithm_name'];
    }
}

$objects = \Avtomat\Api\Avtomat::getAvailableObjects();

try {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data Flow Diagram</title>
        <meta name="description"
              content="Directed acyclic graph of nodes with varying input and output ports with labels, oriented horizontally."/>
        <!-- Copyright 1998-2017 by Northwoods Software Corporation. -->
        <meta charset="UTF-8">
        <script src="../node_modules/gojs/release/go.js"></script>
        <script src="../node_modules/jquery/dist/jquery.min.js"></script>
        <link rel="stylesheet" href="assets/main.css">
        <!--<script src="../node_modules/gojs/assets/js/goSamples.js"></script>  &lt;!&ndash; this is only for the GoJS Samples framework &ndash;&gt;-->
        <script id="code">

            function init() {
                if (window.goSamples) goSamples();  // init for these samples -- you don't need to call this
                var $ = go.GraphObject.make;

                myDiagram =
                    $(go.Diagram, "myDiagramDiv",
                        {
                            initialContentAlignment: go.Spot.Left,
                            initialAutoScale: go.Diagram.UniformToFill,
                            layout: $(go.LayeredDigraphLayout,
                                {direction: 0}),
                            "undoManager.isEnabled": true
                        }
                    );

                // when the document is modified, add a "*" to the title and enable the "Save" button
                myDiagram.addDiagramListener("Modified", function (e) {
                    var button = document.getElementById("SaveButton");
                    if (button) button.disabled = !myDiagram.isModified;
                    var idx = document.title.indexOf("*");
                    if (myDiagram.isModified) {
                        if (idx < 0) document.title += "*";
                    } else {
                        if (idx >= 0) document.title = document.title.substr(0, idx);
                    }
                });

                function makePort(name, leftside) {
                    var port = $(go.Shape, "Rectangle",
                        {
                            fill: "gray", stroke: null,
                            desiredSize: new go.Size(8, 8),
                            portId: name,  // declare this object to be a "port"
                            toMaxLinks: 1,  // don't allow more than one link into a port
                            cursor: "pointer"  // show a different cursor to indicate potential link point
                        });

                    var lab = $(go.TextBlock, name,  // the name of the port
                        {font: "7pt sans-serif"});

                    var panel = $(go.Panel, "Horizontal",
                        {margin: new go.Margin(2, 0)});

                    // set up the port/panel based on which side of the node it will be on
                    if (leftside) {
                        port.toSpot = go.Spot.Left;
                        port.toLinkable = true;
                        lab.margin = new go.Margin(1, 0, 0, 1);
                        panel.alignment = go.Spot.TopLeft;
                        panel.add(port);
                        panel.add(lab);
                    } else {
                        port.fromSpot = go.Spot.Right;
                        port.fromLinkable = true;
                        lab.margin = new go.Margin(1, 1, 0, 0);
                        panel.alignment = go.Spot.TopRight;
                        panel.add(lab);
                        panel.add(port);
                    }
                    return panel;
                }

                function makeTemplate(typename, icon, background, inports, outports) {
                    var node = $(go.Node, "Spot",
                        $(go.Panel, "Auto",
                            {width: 100, height: 120},
                            $(go.Shape, "Rectangle",
                                {
                                    fill: background, stroke: null, strokeWidth: 0,
                                    spot1: go.Spot.TopLeft, spot2: go.Spot.BottomRight
                                }),
                            $(go.Panel, "Table",
                                $(go.TextBlock, typename,
                                    {
                                        row: 0,
                                        margin: 3,
                                        maxSize: new go.Size(80, NaN),
                                        stroke: "white",
                                        font: "bold 11pt sans-serif"
                                    }),
                                $(go.Picture, icon,
                                    {row: 1, width: 55, height: 55}),
                                $(go.TextBlock,
                                    {
                                        row: 2,
                                        margin: 3,
                                        editable: true,
                                        maxSize: new go.Size(80, 40),
                                        stroke: "white",
                                        font: "bold 9pt sans-serif"
                                    },
                                    new go.Binding("text", "name").makeTwoWay())
                            )
                        ),
                        $(go.Panel, "Vertical",
                            {
                                alignment: go.Spot.Left,
                                alignmentFocus: new go.Spot(0, 0.5, -8, 0)
                            },
                            inports),
                        $(go.Panel, "Vertical",
                            {
                                alignment: go.Spot.Right,
                                alignmentFocus: new go.Spot(1, 0.5, 8, 0)
                            },
                            outports)
                    );
                    myDiagram.nodeTemplateMap.add(typename, node);
                }

                <?php
                foreach ($objects as $object) {
                ?>
                makeTemplate("<?= $object->getTitle() ?>", "", "<?= $object->color ?>",
                    [
                        <?php
                        $points = '';
                        foreach ($object->inputLabels as $label) {
                            $points .= 'makePort("' . $label . '", true),';
                        }
                        $points = rtrim($points, ',');
                        ?>
                        <?= $points ?>
                    ],
                    [
                        <?php
                        $points = '';
                        foreach ($object->outputLabels as $label) {
                            $points .= 'makePort("' . $label . '", false),';
                        }
                        $points = rtrim($points, ',');
                        ?>
                        <?= $points ?>
                    ]);
                <?php
                }
                ?>



                myDiagram.linkTemplate =
                    $(go.Link,
                        {
                            routing: go.Link.Orthogonal, corner: 5,
                            relinkableFrom: true, relinkableTo: true
                        },
                        $(go.Shape, {stroke: "gray", strokeWidth: 2}),
                        $(go.Shape, {stroke: "gray", fill: "gray", toArrow: "Standard"})
                    );

                load();

            }

            // Show the diagram's model in JSON format that the user may edit
            function save() {
                document.getElementById("mySavedModel").value = myDiagram.model.toJson();
                myDiagram.isModified = false;
            }

            function load() {
                myDiagram.model = go.Model.fromJson(document.getElementById("mySavedModel").value);
                updateArgumentsBlock();
            }

            function updateArgumentsBlock() {
                var data = myDiagram.model;
                var html = '';
                var item;
                for (var i in data.nodeDataArray) {
                    if (data.nodeDataArray.hasOwnProperty(i)) {
                        item = data.nodeDataArray[i];
                        html += '<tr><td><div>' + item['name'] + '</div><div class="block_arguments">';
                        for (var i = 0; i < item['arguments'].length; i++) {
                            html += '<input type="text" value="' + item['arguments'][i] + '" />';
                        }
                        html += '</div><button class="add_argument">Добавить +</button><button class="save_argument">Сохранить</button></td></tr>'
                    }
                }
                $('#blocks_arguments').html(html);
            }

            function add(object) {
                console.log(object);
                var nextId = getNextId();
                console.log(nextId);
                var data = go.Model.fromJson(document.getElementById("mySavedModel").value);
                data.nodeDataArray.push({
                    type: object,
                    key: object + '::' + nextId,
                    name: object + '::' + nextId
                });
//            console.log(data.nodeDataArray);
                myDiagram.model = data;
                save();
                load();
            }

            function getNextId() {
                var maxId = 0;
                var id;
                var property;
                for (var i in myDiagram.model.nodeDataArray) {
                    if (myDiagram.model.nodeDataArray.hasOwnProperty(i)) {
                        property = myDiagram.model.nodeDataArray[i];
                        id = property['key'].replace(property['type'] + '::', '');
                        if (id > maxId) {
                            maxId = id;
                        }
                    }
                }

                return maxId * 1 + 1;
            }
        </script>
    </head>
    <body onload="init()">
    <div id="sample">
        <table width="100%">
            <tr>
                <td width="25%" valign="top">
                    <div>
                        <h2>Название алгоритма</h2>
                        <form action="" method="get">
                            <div>
                                <input type="text" name="algorithm_name" value="<?= $algoName ?>"/>
                                <button>Загрузить</button>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <h2>доступные блоки</h2>
                    <div class="blocks_arguments_wrapper">
                        <table>
                            <?php
                            foreach ($objects as $object) {
                                if ($object->isEditable) {
                                    echo '<tr><td>' . $object->getTitle() . '</td><td><button onclick="add(\'' . $object->getTitle() . '\')">Добавить +</button></td></tr>';
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <hr>
                    <h2>Аргументы блоков</h2>
                    <div class="blocks_arguments_wrapper">
                        <table id="blocks_arguments"></table>
                    </div>
                </td>
                <td>
                    <h2>Схема алгоритма</h2>
                    <div id="myDiagramDiv" style="border: solid 1px black; width: 100%; height: 600px"></div>
                </td>
            </tr>
        </table>

        <div>
            <div>
                <button id="SaveButton" onclick="save()">Сохранить</button>
                <button onclick="load()">Загрузить</button>
            </div>

            <?php

            $algorithmJson = \Avtomat\Api\Avtomat::adaptAlgoToGoJS(ALGO_ROOT . $algoName . '.json');
            //        echo $algorithmJson;

            ?>
            <h2>JSON дамп алгоритма</h2>
            <textarea id="mySavedModel" style="width:100%;height:300px">
<?= $algorithmJson ?>
    </textarea>
        </div>
    </div>
    <script>
        $(function() {
            $('.add_argument').on('click', function () {
                var parent = $(this).parent().find('.block_arguments')
                var prevHtml = parent.html();
                parent.html(prevHtml+'<input type="text" value="" />');
                console.log(prevHtml);
            });

            $('.save_argument').on('click', function () {
                alert('saving');
            });
        });
    </script>
    </body>
    </html>

    <?php
} catch (\Exception $e) {
    echo $e->getMessage();
}