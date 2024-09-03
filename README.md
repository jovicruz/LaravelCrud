## API para Gerenciar Produtos

<h4>Implementada com o framework PHP Laravel, esta API permite a criação, leitura, atualização e exclusão de produtos.</h4>

<h2> Endpoints:</h2>

- GET /products - Lista todos os produtos.
- GET /products{id} - Lista um produto específico.
- POST /products - Cria um novo produto.
- PUT /products/{id} - Atualiza um produto existente.
- DELETE /products/{id} - Exclui um produto.

<h2>Instalação:</h2>

1. Clone o repositório: git clone https://github.com/jovicruz/LaravelCrud.git

2. Navegue até o diretório do projeto: cd <nome do diretório>
3. Instale as dependências: composer install
4. Crie e configure o arquivo .env com as credenciais do seu banco de dados (Dica: você pode usar o arquivo '.env.example' como base).
5. Execute as migrações: php artisan migrate
6. Inicie o servidor: php artisan serve