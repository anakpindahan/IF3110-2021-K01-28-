<?php
    session_start();
    if (isset($_GET["keyword"])){
        $key = $_GET["keyword"];
        try {
            $db = new PDO('sqlite:Databases/database.db');
        } catch(PDOException $e){
            die("Error!" . $e->getMessage());   
        }

        $sql= "SELECT * from dorayaki where name like '%$key%'";
        $res = $db->query($sql);
        $data = $res->fetchAll();
        $n_data = count($data);
        $n_data_perhalaman = 2;

        $last= ceil($n_data/$n_data_perhalaman);

        if ($last < 1){
            $last = 1;
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian</title>
    <link rel="stylesheet" href="HalamanPencarian.css">

    <script>
        function request_page(pn){
            var result = document.getElementById("hasil");
            var controls = document.getElementById("controls");
            result.innerHTML = `
            <tr id='headerTabel'>
                <th id='gambar'> Gambar </th>
                <th id='info'> Informasi </th>
            </tr>`

            var req = new XMLHttpRequest();
            req.open("GET", "paginationParser.php?pn="+pn+"&rpp=<?php echo $n_data_perhalaman;?>&last=<?php echo $last;?>&keyword=<?php echo $key;?>", true);
            req.send();
            req.onreadystatechange = function(){
                
                if (req.readyState==4 && req.status==200){
                    var data_row = req.responseText.split('||');
                    for (i=0; i<data_row.length -1; i++){
                        var data_row_column = data_row[i].split("|");
                        result.innerHTML += `
                        <tr>
                            <td>
                                <img scr=`+data_row_column[0]+`alt ="GambarDorayaki">
                            </td>
                            <td>
                                <h3>`+data_row_column[1]+`</h3>
                                <p> deskripsi : `+ data_row_column[2]+`</p>
                                <br>
                                <p> harga : `+data_row_column[3]+`</p>
                                <p> stok  : `+data_row_column[4]+ `</p>
                            </td>
                        </tr>
                        `;
                    }
                    
                }
                var last = <?php echo $last; ?>;
                
                controls.innerHTML = '';
                if(last >= 1){
                    if(pn > 1){
                        controls.innerHTML += '<button onclick= "request_page('+(pn-1)+')"> Prev </button> \n';
                    }
                    controls.innerHTML += ' <h3 id= "nhalaman">Halaman '+pn+' dari '+ last+ '</h3> \n';
                    if (pn < last){
                        controls.innerHTML += ' <button onclick= "request_page('+(pn+1)+')"> Next </button> \n';
                    }

                }
            }
        }
    </script>


</head>
<body>
    <form method="GET" action="">
        <input type="text" id="search" name = "keyword" placeholder="Cari dorayaki berdasarkan nama">
        <input type="submit" value="search">
    </form>
    
    <div id="keterangan">Hasil Pencarian Dorayakuy</div>
    <table id="hasil">
    

    </table>
    <div id="controls"></div>
    <div id='cek'></div>
    
</body>
<script> request_page(1)</script>
</html>