<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car21</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/c3c1353c4c.js" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #e5e5e5;
        }

        .search button {
            border-radius: 5px;
            background-color: white;
            border-style: solid;
            float: right;

        }

        nav {
            background-color: #b4bac4;
            width: 100%;
            height: 100px;
        }

        input {
            /* margin-left: 100%; */
            border-radius: 5px;
            border-color: black;
            border-style: solid;
            margin-right: 15px;
            width: 1145px;
        }
    </style>
</head>

<body>
    <!-- Connector untuk menghubungkan PHP dan SPARQL -->
    <?php
        require_once("sparqllib.php");
        $test = "";
        if (isset($_POST['search'])) {
            $test = $_POST['search'];
            $data = sparql_get(
            "http://localhost:3030/car21",
            "
            PREFIX info: <http://car21.com/ns/data#> 
            PREFIX data: <http://car21.com/> 
            PREFIX rdf:  <http://www.w3.org/1999/02/22-rdf-syntax-ns#> 
            SELECT ?Merk ?Kelompok_Model ?Model ?Tipe_Bodi ?CC ?Transmisi ?Asal_Pembuatan 
            WHERE
            { 
                ?infos
                    info:Merk                   ?Merk ;
                    info:Kelompok_Model         ?Kelompok_Model ;
                    info:Model                  ?Model;
                    info:Tipe_Bodi              ?Tipe_Bodi ;
                    info:CC                     ?CC ;
                    info:Transmisi              ?Transmisi ;
                    info:Asal_Pembuatan         ?Asal_Pembuatan .

                    FILTER 
                    (regex (?Merk, '$test', 'i') 
                    || regex (?Kelompok_Model, '$test', 'i') 
                    || regex (?Model, '$test', 'i') 
                    || regex (?Tipe_Bodi, '$test', 'i') 
                    || regex (?CC, '$test', 'i') 
                    || regex (?Transmisi, '$test', 'i') 
                    || regex (?Asal_Pembuatan, '$test', 'i'))
                    }"
            );
        } else {
            $data = sparql_get(
            "http://localhost:3030/car21",
            "
                PREFIX info: <http://car21.com/ns/data#> 
                PREFIX data: <http://car21.com/> 
                PREFIX rdf:  <http://www.w3.org/1999/02/22-rdf-syntax-ns#> 
                SELECT ?Merk ?Kelompok_Model ?Model ?Tipe_Bodi ?CC ?Transmisi ?Asal_Pembuatan 
                WHERE
                { 
                    ?infos
                        info:Merk                   ?Merk ;
                        info:Kelompok_Model         ?Kelompok_Model ;
                        info:Model                  ?Model;
                        info:Tipe_Bodi              ?Tipe_Bodi ;
                        info:CC                     ?CC ;
                        info:Transmisi              ?Transmisi ;
                        info:Asal_Pembuatan         ?Asal_Pembuatan .
                }
            "
            );
        }

        if (!isset($data)) {
            print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
        }
    ?>


    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg ">
        <img style="width: 70px; margin-left:5%; " src="src/img/pngegg.png">
        <div class="container container-fluid ">
            <div class="collapse navbar-collapse">
                <form class="d-flex search" role="search" action="" method="post" id="nameform">
                    <input class="form" type="search" placeholder="Ketik keyword disini" aria-label="Search"
                        name="search">
                    <button class="button " type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container container-fluid mt-3  ">
        <i class="fa-solid fa-magnifying-glass"></i><span>Menampilkan hasil pencarian untuk
            "<?php echo $test; ?>"</span>
        <table class="table table-hover text-center">
            <thead class="table" style="background-color:#b4bac4; color:white; ">
                <tr>
                    <th>Merk</th>
                    <th>Kelompok Model</th>
                    <th>Model</th>
                    <th>Tipe Bodi</th>
                    <th>CC</th>
                    <th>Transmisi</th>
                    <th>Asal Pembuatan</th>
                </tr>
            </thead>
            <tbody class="table-group-divider ">
                <?php $i = 0; ?>
                <?php foreach ($data as $dat) : ?>
                <tr>
                    <td><?= $dat['Merk'] ?></td>
                    <td><?= $dat['Kelompok_Model'] ?></td>
                    <td><?= $dat['Model'] ?></td>
                    <td><?= $dat['Tipe_Bodi'] ?></td>
                    <td><?= $dat['CC'] ?></td>
                    <td><?= $dat['Transmisi'] ?></td>
                    <td><?= $dat['Asal_Pembuatan'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>