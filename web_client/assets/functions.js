/**
 * Рассчет следующего id для нового
 * элемента диграммы
 * @returns {number}
 */
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

/**
 * Добавление нового блока в диаграмму
 * @param object
 */
function add(object) {
    var nextId = getNextId();
    var data = go.Model.fromJson(document.getElementById("mySavedModel").value);
    data.nodeDataArray.push({
        type: object,
        key: object + '::' + nextId,
        name: object + '::' + nextId,
        arguments: []
    });
    myDiagramLink.model = data;
    save();
    load();
    argumentsVue.$forceUpdate();
}

/**
 * Сохранение алгоритма
 */
function save() {
    document.getElementById("mySavedModel").value = myDiagram.model.toJson();
    myDiagramLink.isModified = false;
}

/**
 * Загрузка алгоритма
 */
function load() {
    var data = go.Model.fromJson(document.getElementById("mySavedModel").value);
    var max = data.nodeDataArray.length;

    for (var i = 0; i < max; i++) {
        if (data.nodeDataArray[i] && data.nodeDataArray[i]['type'] === 'Comment') {
            if (data.nodeDataArray[i]['arguments'].length > 0) {
                data.nodeDataArray[i]['name'] = data.nodeDataArray[i]['arguments'][0];
            }
        }
    }
    myDiagramLink.model =  data;
}