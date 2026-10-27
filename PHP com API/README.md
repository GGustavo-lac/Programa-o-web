# Consulta de CEP

Aplicação web em PHP que recebe um CEP, consulta a API pública [ViaCEP](https://viacep.com.br), interpreta o JSON retornado e mostra o endereço na página.

## Como funciona

1. O usuário digita o CEP e clica em **Consultar**.
2. O PHP valida a entrada: remove tudo que não for número e exige 8 dígitos.
3. O PHP faz uma requisição `GET https://viacep.com.br/ws/{cep}/json/` usando cURL.
4. A API devolve um JSON, que o PHP converte com `json_decode()`.
5. A página exibe CEP, logradouro, bairro, cidade e estado, ou uma mensagem de erro.

## Exemplo

Entrada: `01001000`

```
CEP:        01001-000
Logradouro: Praça da Sé
Bairro:     Sé
Cidade:     São Paulo
Estado:     SP
```

## Tecnologias

- PHP 8+ (extensão cURL)
- HTML5 e CSS3
- API ViaCEP

## Estrutura

```
.
├── index.php   # formulário, requisição à API e exibição do resultado
├── style.css   # estilos da página
└── README.md
```



## Vídeo de demonstração

[Assistir no YouTube](COLE-AQUI-O-LINK-DO-VIDEO)

## Autor

Gustavo Lacerda
