Instruções de uso da API

1- Mudar configuracoes do banco no arquivo ".env" com base no arquivo ".envexample"
2- Criar banco usando o script.sql que se encontra na pasta raiz do projeto
3- Utilizar comando "composer install"
4- Utilizar comando "php artisan migrate"
5- Utilizar comando "php artisan serve"
6- Importar no Insomnia o arquivo "rotasDeConsulta" para testes, o qual se encontra na raiz do projeto
7- Depois da importação, devem aparecer várias request's diferentes, as quais devem ser executadas na ordem
8- Após executar a request de login, é necessário copiar o token retornado, pressionar "CTRL+E" para abrir o Environment, onde o token deve ser colado em userToken1
9- Executar as demais request's