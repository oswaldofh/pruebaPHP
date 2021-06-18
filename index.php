<?php
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set("America/Bogota");
session_start();

// Función de comparación
function cmp($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}

if (!empty($_POST['nombre']) && !empty($_POST['boton'])) {

    $nombre = $_POST['nombre'];
    $btn = $_POST['boton'];

    if ($btn == "iniciar") {
        $_SESSION['fecha'] = date('h:i:s');
    }

    if ($btn == "comprar") {

        $productos = [];
        if (intval($_POST['cantidad1'])  != 0) {
            $p1 = $_POST['producto1'];
            $v1 = $_POST['precio1'];
            $c1 = $_POST['cantidad1'];
            $productos[] = array("Articulo" => $p1, "Precio" => $v1,  "Cantidad" => $c1);
        }
        if (intval($_POST['cantidad2']) != 0) {
            $p2 = $_POST['producto2'];
            $v2 = $_POST['precio2'];
            $c2 = $_POST['cantidad2'];
            $productos[] = array("Articulo" => $p2, "Precio" => $v2,  "Cantidad" => $c2);
        }
        if (intval($_POST['cantidad3']) != 0) {
            $p3 = $_POST['producto3'];
            $v3 = $_POST['precio3'];
            $c3 = $_POST['cantidad3'];
            $productos[] = array("Articulo" => $p3, "Precio" => $v3,  "Cantidad" => $c3);
        }
        if (!empty($productos)) {
            usort($productos, "cmp");
        }
        $cantAr = 0;
        $totalCompra = 0;

        $fecha = ($_SESSION['fecha']);
        $fecha2 = date('h:i:s');
        $horainicio = new DateTime($fecha);
        $horaFin = new DateTime($fecha2);
        $intervalo = date_diff($horainicio, $horaFin);
        $tiempo = $intervalo->format('%H:%i:%s');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- ALERTAS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js"></script>
</head>

<body>
    <?php if (isset($productos) && empty($productos)) { ?>
        <script>
            alerta();

            function alerta() {
                swal({
                    title: "Oops...",
                    text: "No se realizaron compras!",
                    type: "warning",
                });
            }
        </script>
    <?php } ?>
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div></div>
            <div class="col-sm-9">
                <div class="card-header text-center">
                    <strong>Formulario de Compra</strong>
                </div>
                <br>
                <form action="indeX.php" method="POST">

                    <?php if ($btn == "iniciar") { ?>
                        <div class="form-group col-sm-4">
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre ?>" readonly>
                        </div>
                        <hr>
                        <div class="row">

                            <div class="col">
                                <label for="producto">Producto</label>
                            </div>

                            <div class="col">
                                <label for="producto">precio</label>
                            </div>

                            <div class="col">
                                <label for="producto">Cantidad</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <input type="text" name="producto1" class="form-control" id="producto1" value="Nevera" readonly>
                            </div>

                            <div class="col">
                                <input type="number" name="precio1" class="form-control" id="precio1" value="500000" readonly>
                            </div>

                            <div class="col">
                                <input type="number" name="cantidad1" class="form-control" id="cantidad1" min="0" value="0">
                            </div>
                        </div> <br>

                        <div class="row">
                            <div class="col">
                                <input type="text" name="producto2" class="form-control" id="producto2" value="Estufa" readonly>
                            </div>

                            <div class="col">
                                <input type="number" name="precio2" class="form-control" id="precio2" value="250000" readonly>
                            </div>

                            <div class="col">
                                <input type="number" name="cantidad2" class="form-control" id="cantidad2" min="0" value="0">
                            </div>
                        </div> <br>

                        <div class="row">
                            <div class="col">
                                <input type="text" name="producto3" class="form-control" id="producto3" value="Lavadora" readonly>
                            </div>

                            <div class="col">
                                <input type="number" name="precio3" class="form-control" id="precio3" value="300000" readonly>
                            </div>

                            <div class="col">
                                <input type="number" name="cantidad3" class="form-control" id="cantidad3" min="0" value="0">
                            </div>
                        </div> <br>

                        <div class="col">
                            <button type="submit" class="btn btn-success" name="boton" value="comprar" id="boton">Comprar</button>
                        </div>
                    <?php } elseif (empty($productos)) { ?>
                        <div class="form-group col-sm-4">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Digite nombre" required>
                        </div>
                        <hr>
                        <div class="col">
                            <button type="submit" class="btn btn-success" name="boton" value="iniciar" id="boton">Ingresar</button>
                        </div>
                    <?php } ?>
                </form>

                <?php if ($btn == "comprar" && !empty($productos)) { ?>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" value="<?php echo $nombre ?>" readonly>
                        </div>
                        <div class="col">
                            <label>Duracion compra:  <span> <?php echo  $tiempo ?></span></label>
                        </div>
                    </div><br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Articulo</th>
                                <th scope="col">Precio Unitario</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $valor) { ?>
                                <tr>
                                    <th><?php echo $valor['Articulo'] ?></th>
                                    <td><?php echo $valor['Precio'] ?></td>
                                    <td><?php echo $valor['Cantidad'] ?></td>
                                    <td><?php echo ($valor['Cantidad'] * $valor['Precio']) ?></td>
                                </tr>
                            <?php
                                $totalCompra += ($valor['Cantidad'] * $valor['Precio']);
                                $cantAr += $valor['Cantidad'];
                            } ?>
                            <br>
                            <tr>
                                <td class="table-active">Cantida de articulos: <?php echo $cantAr ?></td>
                                <td class="table-active">Valor de la compra: <?php echo $totalCompra ?></td>
                            </tr>
                        </tbody>

                    </table>
                    <p><span>
                            <h4>Gracias por su compra</h4>
                        </span></p>
                    <div class="col">
                    <a class="btn btn-success btn-sm" href="index.php" role="button">Volver a comprar</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>