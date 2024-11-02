public function register() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // ... (Lógica de registro)
        
        if ($this->user->register(...)) { // Registro exitoso
            $_SESSION['user'] = $userData; // Autenticación del usuario
            header('Location: templates/welcome.php');
            exit();
        } else {
            // Mostrar error si el registro falla
            include BASE_PATH . 'templates/register.php';
        }
    } else {
        include BASE_PATH . 'templates/register.php';
    }
}
