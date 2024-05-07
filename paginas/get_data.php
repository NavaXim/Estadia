<?php

    try {
        $conn = new PDO('mysql:host=localhost;dbname=u815293024_sistema','u815293024_estr','C3c@t3p3x1');
    } catch (PDOException $exception) {
        die($exception->getMessage());
    }

    $query = "SELECT no_inventario, nombre, desc_bien, area, oficina FROM `tbl_inventario` ORDER BY no_inventario";
    $select = $conn->query($query);

    if ($select) {
        $response = $select->fetchAll(PDO::FETCH_FUNC, fn($no_inventario, $nombre, $desc_bien, $area,$oficina) => [$no_inventario, $nombre, $desc_bien, $area,$oficina] );

        echo json_encode([
            'data' => $response,
        ]);
    } else {
        var_dump($conn->errorInfo());
        die;
    }

?>