# Requisitos entregues

#### Obrigatórios:
- O sistema deverá gerenciar os usuários, permitindo-os se cadastrar e editar seu cadastro.
**Explicação:** O gerenciamento de usuários é feito através das rotas:
GET     /api/user/{id} - Consulta as informações do usuário e requer autenticação
POST    /api/user - Cadastra um novo usuário e não requer autenticação
PUT     /api/user/{id} - Edita um usuário requer autenticação
DELETE  /api/user/{id} - Deleta um usuário requer autenticação;

- O sistema poderá autenticar o usuário através do e-mail e senha do usuário e, nas outras requisições, utilizar apenas um token de identificação.
**Explicação:** Foi criada uma rota para login, a mesma utiliza funcionaldiades nativa de autenticação do Laravel Sanctum:
POST    /api/login - Faz o login do usuário requer email e senha e não requer autenticação;
Todas as outras rotas são protegidas via middleware e qualquer tentativa de acesso de um usuário não autenticado ou usuário tentar acessar recurso não autorizado retorna o erro http 401. Caso a requisição tenha no header o Bearer Token gerado ao realizar o login o usuário irá conseguir ter acesso a funcionalidade.

- O sistema deverá retornar comentários a todos que o acessarem, porém deverá permitir inserir comentários apenas a usuários autenticados
**Explicação:** Existem duas rotas principais na área de comentários
GET     /api/comment - Rota que não requer autenticação e retorna de forma paginada todos os comentários cadastrados no sistema, hoário de criação e atualização, usuário que criou o comentário.

POST    /api/comment/post - Rota autenticada que permite que o usuário cadastre um novo comentário;

- O sistema deverá retornar qual é o autor do comentário e dia e horário da postagem
**Explicação:**;
Já na rota de consulta de comentários é retornado no json de respota as informações do usuário e os horários de postagem e última atualização do comentário.
#### Desejáveis:

- O sistema deverá permitir o usuário editar os próprios comentários (exibindo a data de criação do comentário e data da última edição)
**Explicação:**
Ao acessar a rota abaixo o usuário conseguirá realizar a alteração do conteúdo do seu comentário

PUT /api/comment/{id} - Rota autenticada que permite o usuário alterar o conteúdo do seu comentário, caso o usuário tente alterar o comentário que não pertence a si próprio retornará um erro 401 com a mensagem de "user mismatch";

- O sistema deverá possuir histórico de edições do comentário (Não atendido);

- O sistema deverá permitir o usuário excluir os próprios comentários
**Explicação:**
A seguinte rota permite ao usuário excluir seu próprio comentário:

DELETE /api/comment/{id} - Rota autenticada que permite o usuário deletar o seu comentário, caso o usuário tente deletar um comentário que não pertence a si próprio retornará um erro 401 com a mensagem de "user mismatch";;

- O sistema deverá possuir um usuário administrador que pode excluir todos os comentários (Não atendido);

- O sistema deverá criptografar a senha do usuário
**Explicação:**
Todas as senhas são armazenadas em banco de dados de forma criptografada utilizando hash;

- Implementação de testes automatizados utilizando phpunit
**Explicação:**
Foi implementado testes de funcionalidade para a api, ao executar o comando php artisan test o sistema testará todas as rotas da API.

# Selecao-Back-End

Você deverá forkar este repositório para fazer o seu exercício. Para entregar envie o link do seu repositório por e-mail.

O exercício deve ser feito apenas pelo candidato e tem como objetivo medir o seu nível de conhecimento para melhor alocação dentro da Betalabs. Existem as seguintes exigências técnicas:
- Linguagem do lado servidor: PHP 8.0;
- Linguagem cliente: JSON;
- Banco de dados: MySQL.

Para instalar o PHP/Laravel no local é recomendado usar o [Homestead](https://laravel.com/docs/8.x/homestead) pela facilidade na instalação porém qualquer instalação é válida. Entretanto a avaliação do exercício será feito usando o Homestead mais atualizado.

O exercício deve ser feito necessariamente utilizando a framework Laravel 8.0. A quantidade e qualidade da implementação dos requisitos são usadas para a avaliação do candidato.
Na seção de requisitos do sistema os requisitos são divididos em dois grupos:
- Obrigatório: o requisito deve ser implementado;
- Desejável: é interessante se o requisito for implementado, porém não é obrigatório.

## Cenário
A empresa solicitou o desenvolvimento de um sistema de comentários para um novo produto que estão lançando. Como trata-se de um sistema que será utilizado por outros agentes, então deve ser feito obrigatoriamente via API com entradas e saídas no formato JSON. Esse sistema deve manter os dados dos usuários que comentarem.

### Requisitos do sistema
#### Obrigatórios:
- O sistema deverá gerenciar os usuários, permitindo-os se cadastrar e editar seu cadastro;
- O sistema poderá autenticar o usuário através do e-mail e senha do usuário e, nas outras requisições, utilizar apenas um token de identificação;
- O sistema deverá retornar comentários a todos que o acessarem, porém deverá permitir inserir comentários apenas a usuários autenticados;
- O sistema deverá retornar qual é o autor do comentário e dia e horário da postagem;
- O Readme.md do projeto deverá conter de forma curta e objetiva uma breve explicação de onde e como cada um dos critérios (obrigatórios e desejaveis) busca ser atendido.
#### Desejáveis:
- O sistema deverá permitir o usuário editar os próprios comentários (exibindo a data de criação do comentário e data da última edição);
- O sistema deverá possuir histórico de edições do comentário;
- O sistema deverá permitir o usuário excluir os próprios comentários;
- O sistema deverá possuir um usuário administrador que pode excluir todos os comentários;
- O sistema deverá criptografar a senha do usuário;
- Implementação de testes automatizados utilizando phpunit