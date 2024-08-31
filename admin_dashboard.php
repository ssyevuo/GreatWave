<?
$hashedPassword = password_hash('Love12ss_', PASSWORD_DEFAULT);
$sql = "INSERT INTO users (name, email, password, role) VALUES ('Shakira Mutisya', 'smutisya@gmail.com', '$hashedPassword', 'admin')";
