<?php
// livros.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once 'livros_data.php';

$livros = getLivros();

// --- Filtro de busca ---
$search = isset($_GET['search']) ? mb_strtolower(trim($_GET['search']), 'UTF-8') : '';

if ($search !== '') {
    $livros = array_filter($livros, function($livro) use ($search) {
        return strpos(mb_strtolower($livro['nome'], 'UTF-8'), $search) !== false;
    });

    // Reindexa o array
    $livros = array_values($livros);
}

// --- Ordenação por preço ---
$sort = $_GET['sort'] ?? '';

if ($sort === 'price_asc') {
    usort($livros, fn($a, $b) => $a['preco'] <=> $b['preco']);
} elseif ($sort === 'price_desc') {
    usort($livros, fn($a, $b) => $b['preco'] <=> $a['preco']);
}

echo json_encode($livros);
