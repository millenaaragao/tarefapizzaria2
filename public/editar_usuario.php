<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pizzaria";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (empty($nome) || empty($email) || empty($senha)) {
        echo "Todos os campos são obrigatórios.";
        exit;
    }

    $sql = "SELECT id FROM usuarios WHERE email = ? AND id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Este email já está em uso.";
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

    $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nome, $email, $senhaHash, $id);

    if ($stmt->execute()) {
        echo "Usuário atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o usuário: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
