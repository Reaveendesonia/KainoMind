<?php
// Abre ou cria o banco de dados SQLite
$db = new SQLite3('meu_banco.sqlite');

// Cria a tabela se não existir, com os campos do seu formulário
$db->exec("CREATE TABLE IF NOT EXISTS empreendedores (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL,
    telefone TEXT NOT NULL,
    empresa TEXT NOT NULL,
    area TEXT,
    objetivo TEXT
)");

// Pega os dados do formulário (use o operador null coalescente para evitar erros caso não enviem)
$email = $_POST['email'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$empresa = $_POST['empresa'] ?? '';
$area = $_POST['area'] ?? '';
$objetivo = $_POST['objetivo'] ?? '';

// Prepara a inserção para evitar SQL Injection
$stmt = $db->prepare('INSERT INTO empreendedores (email, telefone, empresa, area, objetivo) VALUES (:email, :telefone, :empresa, :area, :objetivo)');
$stmt->bindValue(':email', $email, SQLITE3_TEXT);
$stmt->bindValue(':telefone', $telefone, SQLITE3_TEXT);
$stmt->bindValue(':empresa', $empresa, SQLITE3_TEXT);
$stmt->bindValue(':area', $area, SQLITE3_TEXT);
$stmt->bindValue(':objetivo', $objetivo, SQLITE3_TEXT);

// Executa a inserção
$result = $stmt->execute();

if ($result) {
    echo "Cadastro enviado com sucesso! Obrigado por se inscrever.";
} else {
    echo "Ocorreu um erro ao enviar seu cadastro. Por favor, tente novamente.";
}
?>
