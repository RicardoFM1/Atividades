# API2

O exercício consiste em criar reservas, deletar e lista-las com base em regras de negócio.

## Como Rodar:

Abra o terminal e digite:

```cmd
cd API2
php -S localhost:3001 -t public

```

Assim é possível iniciar o servidor e acessar as rotas

## Rotas:

| Rota                                                  | Método | Status Esperado |
| ----------------------------------------------------- | ------ | --------------- |
| /equipamentos                                               | GET    | 200             |
| /reservas?equipamento_id=1                                     | GET    | 200             |
| /reservas | POST    | 201           |
| /reservas/{reservaId} | DELETE    | 204           |