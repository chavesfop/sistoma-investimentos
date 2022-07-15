# Sistoma Investimentos 

Sistema para auxilio de visibilidade e gestão de carteiras de investimentos multimercados.

## Objetivo do projeto

 - Ajudar investidores iniciantes a gerar renda passiva.
 - Trazer acessibilidade ao acompanhamento dos investimentos.
 - Ensinar fluxos necessários na vida do investidor.
 - Possibilitar novas SAs a tornar publico seus dados (informativos, no formato RSS).

## Instalação 

Realize a clonagem do repositorio:
```
git clone git@github.com:chavesfop/sistoma-investimentos.git
```

Dependencias.
Para rodar o projeto da forma mais simples, precisamos do PHP e sqlite.
```
apt install php php-sqlite sqlite3
```

Instale o composer (gerenciador de pacotes da pasta vendor)
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

Execute o composer 
```
composer install
```

Crie seu arquivo .env
```
cp .env.sample .env
```

Inicialize o projeto com:
```
php artisan migrate #roda as migrations
php artisan serve   #inicia uma instancia de servidor pra acesso
```
