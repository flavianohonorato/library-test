# Library

[Este material faz parte da playlist que estou ensinando no meu canla](https://youtube.com/emtudo)

- Documentação com swagger http://localhost:8000/api/documentation
- Foi criado apenas um controller, já que é apenas para avaliação do conhecimento.
- Devido ao projeto ser tão pequeno não achei necessário criar domínios
- O Serviço AuthorCreateService contém um DB::transaction, desnecessário por ter apenas uma ação e já que estou deixando a exception explodir e confiando no handle exception, mas deixei para mostrar o conhecimento.
- O serviço BookCreateFromISBNService foi testado utilizando o Bypass, pacote open-source que criei para simular o consumo de APIs em ambientes de teste. Esta estratégia me permite desenvolver mais rápido e eliminar dependências externas, uma vez que não foi necessário criar uma conta na BookCreateFromISBNService, apenas verificar a documentação desta.
- Não adotei o uso de chaves estrangeiras visando uma possível demanda no crescimento da aplicação para torná-la em microserviços. Por esta razão books uso apenas um index em author_id.
- Ainda sobre o serviço BookCreateFromISBNService está fixado o uuid do autor (aleatório), uma vez que não seria possível criar o author sem os demais dados visto que são obrigatórios.
- Não há authenticação na aplicação.
- Como não há controle de versão, mantive o changelog vazio apenas para demonstrar que ele deve existir em um projeto bem estruturado
- A ideia final é fazer o que está no Gravar.txt de acordo com o que eu falo no canal, mas para este teste creio ser suficiente o que tem aqui.

```Estou disponível para uma seção de pair programing em caso de interesse ou dúvida nas estratégias adotadas. Obrigado ;)```
