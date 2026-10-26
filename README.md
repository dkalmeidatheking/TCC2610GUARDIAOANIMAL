# Guardião Animal, versão apresentação

Site demonstrativo em PHP + HTML + CSS + JavaScript, pensado para rodar direto no XAMPP.

## O que foi melhorado

A homepage foi refeita com uma linguagem mais editorial e menos "template": navegação curta, hierarquia forte, fotos grandes, textos específicos, cards com detalhes e caminhos claros para adoção, denúncia e parceria.

A área **ONGs** agora tem 8 organizações fictícias. Cada ONG possui uma página própria em `ong.php?id=...`, com ano de criação, cidade, bairro, foco, história, contatos e os animais ligados à organização. Cada animal possui sua própria ficha em `animal.php?id=...`, com idade, sexo, porte, local e data encontrados, temperamento, história do resgate e ONG responsável.

Também há formulários funcionais para denúncia, doação, adoção, apadrinhamento e contato. Os registros são salvos em JSON na pasta `storage`, o que permite testar o site sem configurar MySQL.

## XAMPP

Coloque a pasta em `C:\xampp\htdocs\guardiao_animal_v3` e abra `http://localhost/guardiao_animal_v3/setup.php`.

Painel: `http://localhost/guardiao_animal_v3/admin/login.php`

Login: `admin@guardiaoanimal.local`
Senha: `admin123`

## Observação

As ONGs, pessoas, animais, números e registros já inseridos são fictícios e servem apenas para a demonstração acadêmica. As fotos usadas nos cards são carregadas de URLs públicas do Unsplash; conexão com a internet é necessária para elas aparecerem.

## Mapa de denúncias de Ourinhos

A página `mapa.php` mostra os registros por bairro. Verde = 0 a 2, laranja = 3 a 5 e vermelho = 6 ou mais. O mapa consulta `api/map_data.php` a cada 5 segundos, então uma nova denúncia aparece sem precisar recarregar a página do mapa.

### Gemini
A denúncia tenta usar a API Gemini no servidor para normalizar o bairro a partir do texto do local. O modelo configurado é `gemini-2.5-flash`. Defina `GEMINI_API_KEY` como variável de ambiente do PHP/Apache. Se a chave não estiver configurada ou a chamada falhar, o sistema usa o bairro selecionado no formulário e continua funcionando.

A chave não deve ser colocada no JavaScript do navegador. A documentação oficial do Google recomenda manter a chave no lado do servidor/ambiente e não expô-la ao cliente.
