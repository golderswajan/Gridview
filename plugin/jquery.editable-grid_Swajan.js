(function () {

    $.fn.editableGrid = function (options) {
        this.on('click','td a span',doDeleteFunction);
        this.on('dblclick','td',editCell)
        //this.on('keyup','#searchInput',filtering);

        var settings =  $.extend({
            primaryTable:'',
            selectQuery:'select * from ',
            columns:'',
            editMethods:''

        },options);
        if(settings.selectQuery=="select * from ")settings.selectQuery += settings.primaryTable;

        console.log(settings.selectQuery);

        var columns,myTable=this;
        var clickControl=false;
        var primaryKey='';
        var primaryColumn;
        var primaryValue;
        var updateColumn;
        var updateValue;

        showData();
        function showData(){
            columns = [];

            var rowHtml = "<tr>";
            $.post('j-process.php',{generalSelect:settings.selectQuery},function(data){
                var info = JSON.parse(data);
                for(var key in info[0]) {
                    columns.push(key);
                }

                var tempColumns;
                if(settings.columns.length!=0){
                    tempColumns = settings.columns;
                }else{
                    tempColumns = columns.slice();
                    tempColumns.splice(0,1);
                    $.each(tempColumns,function (index,value) {
                        tempColumns[index] =
                            jsUcFirst(value);
                    });
                }

                var tempColumnsLength = tempColumns.length,columnsLength=columns.length,infoLength=info.length;
                //rowHtml = "<tr><td colspan='"+tempColumnsLength+"'></td><td><input id=\"searchInput\"  size=\"7%\"></td></tr>";
                var colWidth= Math.round(93/(tempColumnsLength));
                for(var i=0;i<tempColumnsLength;i++){
                    rowHtml += "<th width='"+colWidth+"%'>"+tempColumns[i]+"</th>";
                }
                rowHtml +="<th>"+"Delete"+"</th>";
                rowHtml +="</tr>";


                for(var i=0;i<infoLength;i++){
                    rowHtml += "<tr>";
                    for(var j=1;j<columnsLength;j++){
                        rowHtml += "<td id='"+columns[j]+"Td"+info[i][columns[0]]+"'><span id=\""+columns[j]+"Label"+info[i][columns[0]]+"\">"+info[i][columns[j]]+"</span><textarea id=\""+columns[j]+"Input"+info[i][columns[0]]+"\"  class=\"myTextArea\" rows='1' style='display: none;overflow: hidden'>"+info[i][columns[j]]+"</textarea></td>";
                    }
                    rowHtml += "<td><a href=\"#\"><span id='"+info[i][columns[0]]+"' class=\"glyphicon glyphicon-remove\"></span></a></td>";
                    rowHtml += "</tr>";
                }


                myTable.html(rowHtml);

                //editMethod.address=true;

            })


        }


        function jsUcFirst(string)
        {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }


        function editCell(e){
            var temp = e.target.id.split(/Label|Td/);
           if(temp.length==2){
               primaryKey = {
                   row:temp[1],
                   col:temp[0]
               };

               var label = $('#'+primaryKey.col+"Label"+primaryKey.row);
               var input = $('#'+primaryKey.col+"Input"+primaryKey.row);
               label.css({"display":"none"});
               input.css({"display":"block"});
               input.focus();
               var tempValue = input.val();
               input.val('');
               input.val(tempValue);
               clickControl = true;
           }
        }


        function doDeleteFunction(primaryIdEvent){
            if(confirm('Are you sure to delete ?')){
                var query = "delete from identity where "+columns[0]+"="+primaryIdEvent.target.id;
                $.post('j-process.php',{
                    generalDelete:query
                },function(data){
                    showData();
                })
            }

        }

        $(window).click(function (event) {

            if (clickControl) {
                if (event.target.id != (primaryKey.col+"Input"+primaryKey.row)) {
                    doEditFunction();
                }
            }
        });

        $(document).keypress(function (e) {
            if (clickControl) {
                if (e.which == 13) {
                    doEditFunction();
                }

            }
        });

        function doEditFunction(){
            var label = $('#'+primaryKey.col+"Label"+primaryKey.row);
            var input = $('#'+primaryKey.col+"Input"+primaryKey.row);

            label.css({"display": "block"});
            input.css({"display": "none"});

            primaryColumn = columns[0];
            primaryValue = primaryKey.row;
            updateColumn = primaryKey.col;
            updateValue = input.val();

            var query='';
            if(settings.editMethods[updateColumn]!=null){
                var splittedQuery = settings.editMethods[updateColumn].split('*');
                query = splittedQuery[0]+updateValue+splittedQuery[1]+primaryValue+splittedQuery[2];
            }else{
                query = "UPDATE "+settings.primaryTable+" SET "+ updateColumn +" = '"+ updateValue +"' WHERE "+ primaryColumn +" = '"+ primaryValue +"'";
            }



            $.post('j-process.php', {
                generalUpdate : query
            }, function (data) {
                //label.html(input.val());
                showData();
            });

            clickControl = false;

        }

        function filtering() {
            var filterValue, table, tr, td, i;
            filterValue = $('#searchInput').val().toUpperCase();
            tr = $('table tr');
            td = tr[2].getElementsByTagName("td")[0];
            var x = $("tr:contains(j)");
            console.log(x);
            x.style.display="none";


            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filterValue) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }

        }

    }





}(jQuery));