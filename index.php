<?php
// =========================
// CONFIGURACIÓN
// =========================
class Database {
    private $host = "localhost";
    private $dbname = "escuela";
    private $username = "root";
    private $password = "";

    public function connect() {
        try {
            $conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;

        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}

// =========================
// MODELO
// =========================
class DashboardModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    private function contar($tabla) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM $tabla");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getTotales() {
        return [
            "alumnos" => $this->contar("alumnos"),
            "profesores" => $this->contar("profesor"),
            "inscripciones" => $this->contar("inscripcion"),
            "asignaturas" => $this->contar("asignatura")
        ];
    }
}

// =========================
// CONTROLADOR
// =========================
class DashboardController {
    private $model;

    public function __construct($db) {
        $this->model = new DashboardModel($db);
    }

    public function index() {
        return $this->model->getTotales();
    }
}

// =========================
// EJECUCIÓN
// =========================
$db = (new Database())->connect();
$controller = new DashboardController($db);
$data = $controller->index();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Escuela</title>

<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-yellow-200">

<div class="flex h-screen">

<!-- SIDEBAR -->
<aside class="w-64 bg-yellow-500 text-black flex flex-col">
    <div class="p-6 text-2xl font-bold border-b border-yellow-400">
        Módulos
    </div>

    <nav class="flex-1 p-4 space-y-2">
        <a href="#" class="block px-4 py-2 rounded hover:bg-yellow-300">Alumnos</a>
        <a href="#" class="block px-4 py-2 rounded hover:bg-yellow-300">Asignatura</a>
        <a href="#" class="block px-4 py-2 rounded hover:bg-yellow-300">Inscripción</a>
        <a href="#" class="block px-4 py-2 rounded hover:bg-yellow-300">Profesor</a>
    </nav>
</aside>

<!-- CONTENIDO -->
<div class="flex-1 flex flex-col">

    <!-- HEADER CORRECTO -->
    <header class="bg-amber-200 shadow p-4 flex justify-between items-center">

        <!-- IZQUIERDA -->
        <div class="flex items-center gap-3">

            <!-- LOGO -->
            <svg class="hover:scale-110 transition duration-300" width="60" height="60" viewBox="0 0 200 200">

                <defs>
                    <linearGradient id="fuego" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#ff0000"/>
                        <stop offset="50%" stop-color="#ff9900"/>
                        <stop offset="100%" stop-color="#ffcc00"/>
                    </linearGradient>
                </defs>

                <path d="M100 30 
                         C120 10, 150 40, 130 70
                         C160 60, 170 100, 140 110
                         C170 130, 130 170, 100 140
                         C70 170, 30 130, 60 110
                         C30 100, 40 60, 70 70
                         C50 40, 80 10, 100 30 Z"
                      fill="url(#fuego)"/>

            </svg>

            <!-- NOMBRE -->
            <h1 class="text-xl font-bold text-amber-900">
                Mariano
            </h1>

        </div>

        <!-- DERECHA -->
        <button class="bg-yellow-400 px-4 py-2 rounded hover:bg-yellow-300">
            Nuevo
        </button>

    </header>

    <!-- MAIN -->
    <main class="p-6">

        <!-- TARJETAS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-amber-200 p-6 rounded-xl shadow">
                <h2>Alumnos</h2>
                <p class="text-3xl font-bold text-yellow-600">
                    <?= $data['alumnos'] ?>
                </p>
            </div>

            <div class="bg-amber-200 p-6 rounded-xl shadow">
                <h2>Profesores</h2>
                <p class="text-3xl font-bold text-yellow-600">
                    <?= $data['profesores'] ?>
                </p>
            </div>

            <div class="bg-amber-200 p-6 rounded-xl shadow">
                <h2>Inscripciones</h2>
                <p class="text-3xl font-bold text-yellow-600">
                    <?= $data['inscripciones'] ?>
                </p>
            </div>

            <div class="bg-amber-200 p-6 rounded-xl shadow">
                <h2>Asignaturas</h2>
                <p class="text-3xl font-bold text-yellow-600">
                    <?= $data['asignaturas'] ?>
                </p>
            </div>

        </div>

        <!-- SECCIÓN EXTRA -->
        <div class="mt-8 bg-amber-100 p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold">Promedio</h2>
            <p class="text-gray-600">(Aquí puedes agregar lógica después)</p>
        </div>

    </main>

</div>
</div>

</body>
</html>