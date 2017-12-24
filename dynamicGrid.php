<?php
/**
 * Created by PhpStorm.
 * User: swaja
 * Date: 12/24/2017
 * Time: 12:28 PM
 */
include_once 'database.php';
$relative_data = db_select("select * from identity");
echo $relative_data[0]['name'];
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
        var colomns=[];
        $(document).ready(function(){
                $.post('jquery-process.php',{},function(data){
                    var info = JSON.parse(data);
                    for(var key in info[0]) {
                        colomns.push(key);
                    }
                    for(var i=0;i<info.length;i++){
                        console.log(info[i]);
                    }

                })
            console.log(colomns);
            }
        );

        function editName(obj){
            console.log(obj);
            //var nameLabel = $('#nameLabel'+rowId);
            //var nameInput = $('#nameInput'+rowId);
            //nameLabel.css({"display":"none"});
            //nameInput.css({"display":"block"});
            //nameInput.focus();
            //var temp = nameInput.val();
            //nameInput.val('');
            //nameInput.val(temp);
            //console.log(temp);

        }

        function dox(rowId){
            console.log("avav");
        }
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
        .myTable th,td{
            padding: 8px;
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
    </style>
</head>
    <body>

        <table class="myTable">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Contact</th>
            </tr>

            <tr>
                <td id="primary1"><input value="1"></td>
                <td ondblclick="editName({row:1,col:1})"><span id="nameLabel1">Swajan</span><input id="nameInput1" focusout="dox(1)" value="Swajan" hidden></td>
                <td id="address1">Khulna</td>
                <td id="contact1">01571777609</td>
            </tr>

            <tr>
                <td>2</td>
                <td>Swadhin</td>
                <td>Barisal</td>
                <td>01999626776</td>
            </tr>

            <tr>
                <td>3</td>
                <td>Protoy</td>
                <td>Dhaka</td>
                <td>01747611697</td>
            </tr>

        </table>

    </body>
</html>
