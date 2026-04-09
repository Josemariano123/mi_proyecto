<?php 
class cconexion {

    function conexionBD() {
        $host = "localhost";
        $dbname = "escuela";
        $username = "root";
        $password = "";

        $conn = null;

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "Se conectó a la base de datos  conexion.php:10 - cinexion.php:16";

        } catch (PDOException $exp) {
            echo "No se logró conectar con la base de datos: - cinexion.php:19" . $exp->getMessage();
        }

        return $conn;
    }
}
?>