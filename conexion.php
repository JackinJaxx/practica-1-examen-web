<?php
class Database
{
    // Definimos las constantes para los detalles de la conexión
    private const DB_HOST = 'localhost';
    private const DB_USER = 'root';
    private const DB_PASS = 'Alejandro1807*';
    private const DB_NAME = 'miempresa';

    // Variable para almacenar el enlace a la conexión
    private $connection;

    // Constructor para inicializar la conexión automáticamente al crear una instancia
    public function __construct()
    {
        $this->connect();
    }

    // Método para conectar a la base de datos
    private function connect()
    {
        // Intentamos conectar con la base de datos
        $this->connection = @mysqli_connect(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);

        if (!$this->connection) {
            // Si hay un error, lo manejamos de forma controlada
            die("Error: No se pudo conectar a la base de datos. " . mysqli_connect_error());
        }
    }

    // Método para obtener la conexión
    public function getConnection()
    {
        return $this->connection;
    }

    // Método para cerrar la conexión (buena práctica)
    public function closeConnection()
    {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }
}
?>
