# API1

O exercício consiste em listar livros com base em ordenação, filtros e paginação.

## Como Rodar:

Abra o terminal e digite:

```cmd
cd API1
php -S localhost:3000 -t public

```

Assim é possível iniciar o servidor e acessar as rotas

## Rotas:

| Rota                                                  | Método | Status Esperado |
| ----------------------------------------------------- | ------ | --------------- |
| /livros                                               | GET    | 200             |
| /livros/{livroId}                                     | GET    | 200             |
| /livros?titulo=titulo&categoria=categoria&autor=autor | GET    | 200             |
