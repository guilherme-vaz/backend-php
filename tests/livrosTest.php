<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../livros_data.php';

class LivrosTest extends TestCase {

    public function testLivroTemCamposObrigatorios() {
        $livros = getLivros();

        foreach ($livros as $livro) {
            $this->assertArrayHasKey('nome', $livro);
            $this->assertArrayHasKey('descricao', $livro);
            $this->assertArrayHasKey('preco', $livro);
            $this->assertArrayHasKey('imagem', $livro);
        }
    }

    public function testOrdenacaoPrecoAscendente() {
        $livros = getLivros();
        usort($livros, fn($a, $b) => $a['preco'] <=> $b['preco']);

        for ($i = 0; $i < count($livros) - 1; $i++) {
            $this->assertLessThanOrEqual($livros[$i + 1]['preco'], $livros[$i]['preco']);
        }
    }

    public function testOrdenacaoPrecoDescendente() {
        $livros = getLivros();
        usort($livros, fn($a, $b) => $b['preco'] <=> $a['preco']);

        for ($i = 0; $i < count($livros) - 1; $i++) {
            $this->assertGreaterThanOrEqual($livros[$i + 1]['preco'], $livros[$i]['preco']);
        }
    }

    public function testBuscaPorNome() {
        $livros = getLivros();
        $busca = 'olimpiano';

        $filtrados = array_filter($livros, function($livro) use ($busca) {
            return stripos($livro['nome'], $busca) !== false;
        });

        foreach ($filtrados as $livro) {
            $this->assertStringContainsStringIgnoringCase($busca, $livro['nome']);
        }

        $this->assertGreaterThan(0, count($filtrados), 'Nenhum livro encontrado na busca.');
    }

}
