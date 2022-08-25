GrupoA Educação - Full Stack Web Developer - Laravel
===================

# Especificações técnicas
- Frontend: VueJS + Vuetify
- Backend: Laravel + DingoApi
- Banco de dados: AWS Aurora RDS (mySQL based)
- Deploy: Amazon Web Services (AWS)
- Idioma do código: Inglês

# Acessos
Devido ao fato de que se passaram 3 semanas e não recebi feedback algum, estarei me desfazendo da estrutura na AWS. Irei deletar a máquina na EC2 e deletar a estrutura no S3 e CloudFront, os links acima a partir de hoje 25/08/2022 não irão mais funcionar.
- Frontend: d2hwz5auiqhiry.cloudfront.net:80
- Backend: 107.20.127.63:8080/api

# Decisão da arquitetura

- Backend: Decidi utilizar `Dingo` no Laravel para ficar mais limpo a estrutura da API, além disso, achei importante criar uma camada de validação (`AbstractRequest`) para o Controller e camada de transformação (`AbstractTransformer`) para o Model `Student`. Apesar de inicialmente ter decidido criar um endpoint para filtrar estudantes por nome, acabei não utilizando, acabei fazendo algo mais simples no frontend.

- Frontend: Não há muito mistério, como não tenho 'muita' experiência com Vue decidi pegar um projeto pré estabelecido ao invés de montar tudo do zero assim como fiz com o Laravel. Tentei seguir o máximo da referência que foi oferecida na pasta `mockups`, criando um menu lateral e uma tabela listando os estudantes, sendo que em cada linha há opção de editar ou remover. Também foi reproduzida a barra superior, com o campo de pesquisa e botão de cadastro.

- Infraestrutura: Decidi por hospedar o backend numa AWS EC2 por conta da praticidade, o servidor está rodando com artisan serve na porta 8080. Uma pequena observação, esse servidor não foi escalado com Load Balancer. Já o frontend, decidi armazenar na AWS S3 e rotea-lo utilizando CloudFront, facilitando assim o processo de inclusão de SSL e atribuição de dominio via CName no Route53 no futuro.

# Lista de bibliotecas de terceiro
- Backend: `Dingo API`
- Frontend: `Vuetify`, `Material Design Icons`, `V-textfield`, `Roboto fontface`, `EsLint`

# O que há pra melhorar
Claramente há muito para melhorar, esse foi um projeto rápido desenvolvido em cerca de 8 horas, apenas para demonstrar conhecimento básico em cada parte. Abaixo listo o que me vem na cabeça inicialmente, mas acredito que tenha muito mais coisa pra melhorar.

## Backend:
- Colocaria esse server em um container na AWS ECS, criaria um processo de rollout ou bluegreen ligado à um Application Load Balancer (Network), e acionaria esse processo de deploy de forma automatizada (CI/CD) utilizando AWS CodePipeline. Inclusive, deixei uma pasta chamada `scripts` com o processo de deploy na EC2. Quando fosse o caso de levar para AWS ECS, esses processos estariam inclusos no Dockerfile da imagem na AWS ECR.
- Adicionaria um processo de autenticação, talvez olhando para algo mais básico sendo Laravel Passport, ou iria para algo mais flexível como por exemplo Keycloak.
- Implementaria um middleware para tratar erros inesperados (error handling)
- Implementaria um middleware para garantir segurança das rotas, comunicando diretamente com o servidor de autenticação (Keycloak, ou outro).
- Implementaria testes unitários utilizando PhpUnit
- Implementaria testes de integração caso o sistema se torne em uma estrutura de micro serviços

## Frontend:
- Acredito que o sistema rode muito bem via S3, mas talvez para manter um padrão, seria interessante joga-lo para um container na AWS ECS também, executando os processos de deploy automatizado (CI/CD) assim como no backend.
- Implementaria toast notification, dessa forma não precisaria utilizar aqueles alerts, pois eles não são tão bonitos.. rs
- Implementaria VueRouter, pois o app cresceria um dia, e precisariamos de rotas provavelmente.
- Implementaria um middleware para garantir segurança das rotas, comunicando diretamente com o servidor de autenticação (Keycloak, ou outro).
- Implementaria testes unitários utilizando Jest, e testes E2E utilizando Cypress

## Infraestrutura:
- Manteria o processo de CI/CD na AWS CodePipeline ao invés de utilizar Github Actions
- Conforme dito anteriormente, levaria para mesa de discussão a possibilidade de levar a estrutura para containers, e faria a arquitetura voltada para microserviços