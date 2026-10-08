# Cookie, o que é?

Um cookie é basicamente um arquivo com dado que pode ser armazenado no navegador.

---

## Caso de uso

O cookie pode ser utilizado para diferentes contextos, dentre os contextos estão:

<p>

`Autenticação` (Guardar para depois poder entrar logado)

<p>

`Preferência` (Dark mode, cores, etc...)

<p>

`Ads` (Mais usado em grandes empresas, que pega seus movimentos, cliques para fazer anúncios
e te entregar mais)

<p>

O caso da autenticação tem a opção de permanência do login, caso alguém saia do site, quando voltar novamente ainda estará logado.

---

## Segurança

Cookie usa algumas opções para garantir segurança, como por exemplo `HttpOnly` e `samesite`, que impedem `CSRF` (Cross-Site Request Forgery).

### O que é Cross-Site Request Forgery?

O CSRF é um ataque malicioso que visa enviar métodos HTTP com origem de outros sites para um site confiável pelo usuário, geralmente acontece quando o usuário é redirecionado de um site externo para um confiável e nesse caminho acontece a inserção de cookies no navegador.

<p>
FONTE:

[mdn - CSRF](https://developer.mozilla.org/en-US/docs/Web/Security/Attacks/CSRF)

---

## Como utilizar no PHP

- A sintaxe para utilizar no php é bem simples:

```php
setcookies('nomedocookie', 'valor', 'expiracao(em segundos, com time unix)', 'caminho', 'dominio', 'secure', 'httponly'  )

```

ou o terceiro parâmetro sendo um array com as opções:

```php

  $opcoesCookie = [
            'expires' => time() + strtotime('+1 day'),
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'lax'
    ];

setcookie('sessao', '1', $opcoesCookie);

```

### O que cada parâmetro faz

> `expires` (quando expira em segundos desde o UNIX Epoch)

<p>

> `path` (o caminho/pagina que esse cookie poderá ser chamado)

<p>

> `domain` (o domínio aceito, esse parâmetro pode ser utilizado quando há subdomínios como por exemplo: site.web e pagina.web, o domínio é o web)

<p>

> `secure` (garante que o cookie será repassado por meios https)

<p>

> `httponly` (garante que nada do javascript pode acessar ou alterar esse cookie)

<p>

> `samesite` (evita o ataque CSRF com segurança ao navegar)

Para funcionar no frontend e enviar os cookies é necessário configurar o cors:

```php
<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('OPTIONS')) {
            return response()->json('', 200)
                ->header('Access-Control-Allow-Origin', ['http://localhost:5173', 'http://localhost:3000'])
                ->header('Access-Control-Allow-Headers', 'Authorization, Content-Type')
                ->header('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, PATCH, DELETE')
                ->header('Access-Control-Allow-Credentials', true);
        }

        $reponse = $next($request);

        return $reponse
            ->header('Access-Control-Allow-Origin', ['http://localhost:5173', 'http://localhost:3000']) // Necessário listar origems permitidas ao invés de usar * quando tiver utilizando cookies.
            ->header('Access-Control-Allow-Headers', 'Authorization, Content-Type')
            ->header('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, PATCH, DELETE')
            ->header('Access-Control-Allow-Credentials', true); // Permite enviar cookies
    }
}


```
