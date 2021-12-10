Instruções de uso da API

1- Utilizar comando "composer install"
2- Criar banco usando o script.sql que se encontra na pasta raiz do projeto
3- Renomear o arquivo ".envexample" para ".env" e fazer as alterações necessárias de acordo com seu banco de dados
4- Iniciar seu banco de dados
5- Utilizar comando "php artisan migrate"
6- Utilizar comando "php artisan serve"
7- Importar no Insomnia o arquivo "rotasDeConsulta" para testes, o qual se encontra na raiz do projeto
8- Depois da importação, devem aparecer várias request's diferentes, as quais devem ser executadas na ordem
9- Após executar a request de login, é necessário copiar o token retornado, pressionar "CTRL+E" para abrir o Environment, onde o token deve ser colado em userToken1
10- Executar as demais request's