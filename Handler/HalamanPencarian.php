<?php
    session_start();
    if (isset($_GET["keyword"])){
        $key = $_GET["keyword"];
        try {
            $db = new PDO('sqlite:../Databases/dorayakuy.db');
        } catch(PDOException $e){
            die("Error!" . $e->getMessage());   
        }

        $sql= "SELECT * from DORAYAKI where name like '%$key%'";
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
                <th id='gambar'> <h2>Gambar</h2> </th>
                <th id='info'> <h2>Informasi</h2> </th>
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
                            <td class="gambar">
                            <a href = "detailVariant.php?id=`+data_row_column[5]+`">
                                <img class= "gambar" src=`+data_row_column[0]+` alt ="GambarDorayaki">
                            </a>
                                
                            </td>
                            <td class="data">
                                <a href = "detailVariant.php?id=`+data_row_column[5]+`">
                                    <h3>`+data_row_column[1]+`</h3>
                                </a>
                                
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
                    controls.innerHTML += ' <h5 id= "nhalaman">Halaman '+pn+' dari '+ last+ '</h5> \n';
                    if (pn < last){
                        controls.innerHTML += ' <button onclick= "request_page('+(pn+1)+')"> Next </button> \n';
                    }

                }
            }
        }
    </script>
    


</head>
<body>
<div class = "navbar">
        <div class="logo">
                <a class="brand" href="dashboard.php">Dorayakuy!</a>
        </div>
        <div class = "user-type">
            <div class="tombol">
                <?php
                    if($_COOKIE["is_admin"] == 1){
                        echo '<a href="TambahVarian.html">Tambah varian</a>';
                    }
                    else{
                        echo'<a href="RiwayatPembelian.php"> Riwayat pembelian</a>';
                    }
                ?>

            </div>
            <div>
                |
            </div>

            <div class="tombol">
                <a href="login.html"> logout </a>
            </div> 
        </div>    
    </div>
    <div class = content>
        <h1>Halaman Pencarian</h1>
        <form class = "box-input" method="GET" action="">
            <input type="text" id="search" name = "keyword" placeholder="Cari dorayaki berdasarkan nama">
            <input type="submit" value="search">
        </form>
        
        <div id="keterangan"><h2>Hasil Pencarian Dorayakuy</h2></div>
        <table id="hasil">
        

        </table>
        <div id="controls"></div>
        <div id='cek'></div>
    </div>
    
    
</body>
<script> request_page(1)</script>
</html>
