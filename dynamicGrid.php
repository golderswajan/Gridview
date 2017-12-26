<?php
/**
 * Created by PhpStorm.
 * User: swaja
 * Date: 12/24/2017
 * Time: 12:28 PM
 */
include_once 'database.php';
echo "";
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        var colomns;
        var editMethod;
        var primaryColomn;
        var primaryValue;
        var updateColomn;
        var updateValue;
        $(document).ready(function(){
            loadData();
            }
        );

        function loadData(){
            colomns = [];
            editMethod = {};

            var myTable = $('.myTable');
            var rowHtml = "<tr>";
            $.post('jquery-process.php',{},function(data){
                var info = JSON.parse(data);
                for(var key in info[0]) {
                    colomns.push(key);
                    editMethod[key] = false;
                }
                var colWidth= Math.round(93/(colomns.length-1));
                console.log(colWidth);
                for(var i=1;i<colomns.length;i++){
                    rowHtml += "<th width='"+colWidth+"%'>"+jsUcFirst(colomns[i])+"</th>";
                }
                rowHtml +="<th>"+"Delete"+"</th>";
                rowHtml +="</tr>";

                for(var i=0;i<info.length;i++){
                    rowHtml += "<tr>";
                    for(var j=1;j<colomns.length;j++){
                        rowHtml += "<td ondblclick=\"editCell({row:'"+info[i][colomns[0]]+"',col:'"+colomns[j]+"'})\"><span id=\""+colomns[j]+"Label"+info[i][colomns[0]]+"\">"+info[i][colomns[j]]+"</span><textarea id=\""+colomns[j]+"Input"+info[i][colomns[0]]+"\"  class=\"myTextArea\" rows='1'>"+info[i][colomns[j]]+"</textarea></td>";
                    }
                    rowHtml += "<td><a href=\"#\" onclick=\"doDeleteFunction("+info[i][colomns[0]]+")\"><span class=\"glyphicon glyphicon-remove\"></span></a></td>";
                    rowHtml += "</tr>";
                }


               myTable.html(rowHtml);
                console.log(editMethod);
                //editMethod.address=true;

            })
            //console.log(colomns);

        }

        var clickControl=false;
        var primaryKey='';

        function editCell(obj){
            console.log(obj);
            primaryKey = obj;
            var label = $('#'+obj.col+"Label"+obj.row);
            var input = $('#'+obj.col+"Input"+obj.row);
            label.css({"display":"none"});
            input.css({"display":"block"});
            input.focus();
            var temp = input.val();
            input.val('');
            input.val(temp);
            clickControl = true;

        }

        function jsUcFirst(string)
        {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

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
            primaryColomn = colomns[0];
            primaryValue = primaryKey.row;
            updateColomn = primaryKey.col;
            updateValue = input.val();

            if(editMethod[primaryKey.col]){
                eval(primaryKey.col+"Edit"+"()");
            }else{
                var query = "UPDATE identity SET "+ updateColomn +" = '"+ updateValue +"' WHERE "+ primaryColomn +" = '"+ primaryValue +"'";
                $.post('jquery-process.php', {
                    generalUpdate : query
                }, function (data) {
                     //label.html(input.val());
                     loadData();
                });
            }

            clickControl = false;
        }

        function doDeleteFunction(primaryId){
            if(confirm('Are you sure to delete ?')){
                var query = "delete from identity where "+colomns[0]+"="+primaryId;
                $.post('jquery-process.php',{
                    generalDelete:query
                },function(data){
                    loadData();
                })
            }

        }

//        function addressEdit(){
//            $.post('jquery-process.php',{
//                generalUpdate : "UPDATE `identity` SET `address` = 'abcd' WHERE `identity`.`id` = 1;"
//            },function(data){});
//        }

        $(window).click(function (event) {
            if (clickControl) {
                if (event.target.id != (primaryKey.col+"Input"+primaryKey.row)) {
                         doEditFunction();
                    }
            }
        });
    </script>

    <style>
        .myTable{
            width: 95%;
            margin: 2%;
        }
        .myTable table,th,td{
            border:1px solid black;
            border-collapse: collapse;
        }
        .myTable textarea,span{
            padding: 6px;
            text-align: left;
        }
        .myTable th{
            background: black;
            color:white;
        }
        table.myTable tr:nth-child(even){
            background-color: #eeeeee;
        }
        table.myTable tr:nth-child(odd){
            background-color: #ffffff;
        }
        .myTextArea
        {
            display: none;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
    <body>

        <table class="myTable">
<!--            <tr>-->
<!--                <th width="31%">Name</th>-->
<!--                <th width="31%">Address</th>-->
<!--                <th width="31%">Contact</th>-->
<!--                <th>Delete</th>-->
<!--            </tr>-->
<!---->
<!--            <tr>-->
<!--                <td ondblclick="editCell({row:'1',col:'name'})"><span id="nameLabel1">Swajan</span><textarea class="myTextarea" id="nameInput1"   rows="1" >Swajan</textarea></td>-->
<!--                <td ondblclick="editCell({row:'1',col:'address'})"><span id="addressLabel1">Khulna</span><input id="addressInput1"  value="Khulna" hidden></td>-->
<!--                <td id="contact1">01571777609</td>-->
<!--                <td><a href="#" onclick="doDeleteFunction(1)"><span class="glyphicon glyphicon-remove"></span></a></td>-->
<!--            </tr>-->
<!---->
<!--            <tr>-->
<!--                <td>Swadhin</td>-->
<!--                <td>Barisal</td>-->
<!--                <td>01999626776</td>-->
<!--                <td>Delete</td>-->
<!--            </tr>-->
<!---->
<!--            <tr>-->
<!--                <td>Protoy</td>-->
<!--                <td>Dhaka</td>-->
<!--                <td>01747611697</td>-->
<!--                <td><a href="#" onclick="doDeleteFunction(3)"><span class="glyphicon glyphicon-remove"></span></a></td>-->
<!--            </tr>-->

        </table>

    </body>
</html>
