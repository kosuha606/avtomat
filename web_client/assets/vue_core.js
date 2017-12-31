$(function () {
    var common = new Vue({
        el: "#common",
        data: {
            title: 'Algo Redactor v1'
        }
    });

    argumentsVue = new Vue({
        el: "#arguments",
        data: {
            test: ['1'],
            diagramData: myDiagramLink.model.nodeDataArray,
            diagram: myDiagramLink
        },
        computed: {
            arguments: function () {
                console.log('compute arguments');
                var args = [];
                var len = myDiagramLink.model.nodeDataArray.length;
                for (var i = 0; i < len; i++) {
                    args.push({
                        class: myDiagramLink.model.nodeDataArray[i]['name'],
                        arguments: myDiagramLink.model.nodeDataArray[i]['arguments']
                    })
                }

                return args;
            }
        },
        watch: {
            argumentchange: function(val, oldVal) {
                // change of userinput, do something
            }
        },
        methods: {
            findByClass: function (className) {
                return _.find(myDiagramLink.model.nodeDataArray, function (arr) {
                    return arr['name'] === className;
                });
            },
            add: function (className) {
                console.log(className);
                var index = this.findByClass(className);
                console.log(index);
                index.arguments.push('');
                // this.test.push('1');
                save();
                // load();
                this.$forceUpdate();
            },
            change: function (event) {
                var self = $(event.target);
                var val = self.val();
                var className = self.parent().find('.class_name').val();
                var index = self.parent().find('.index').val();
                var obj = this.findByClass(className);
                obj.arguments[index] = val;
                save();
                this.$forceUpdate();
            },
            remove: function (event) {
                var self = $(event.target);
                var className = self.parent().find('.class_name').val();
                var index = self.parent().find('.index').val();
                var obj = this.findByClass(className);
                obj.arguments.splice(index, 1);
                console.log('removing');
                save();
            }
        }
    });
});