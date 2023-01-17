# distributori-benzina

Test per ricerca distributore più economico usando cronjob ttamite actions di github come spiegato qui:  https://theanshuman.dev/articles/free-cron-jobs-with-github-actions-31d6

Portale carburanti MISE: https://carburanti.mise.gov.it/ospzSearch/home

## API queries

Base url: https://carburanti.mise.gov.it/ospzApi/registry/

### Elenco province

- Endpoint: registry/province
- https://carburanti.mise.gov.it/ospzSearch/home/registry/registry/province?regionId=9

Risultato:

```
{
  "results": [
    {
      "id": "FR",
      "description": "Frosinone"
    },
    {
      "id": "LT",
      "description": "Latina"
    },
    {
      "id": "RI",
      "description": "Rieti"
    },
    {
      "id": "RM",
      "description": "Roma"
    },
    {
      "id": "VT",
      "description": "Viterbo"
    }
  ]
}
```

### Elenco comuni di data provincia

 - Endpoint: registry/town
 - Test link:  https://carburanti.mise.gov.it/ospzSearch/home/registry/town?province=RM

Risultato:

```
{
  "results": [
    {
      "id": "Affile",
      "description": "Affile"
    },
    {
      "id": "Agosta",
      "description": "Agosta"
    },
    .....
    ]
}
```

### Elenco autostrade d'italia ([fonte](https://github.com/Pater999/osservaprezzi-carburanti-node/blob/master/src/methods/registry.ts))

- Endpoint: registry/highway
- Test link:  https://carburanti.mise.gov.it/ospzSearch/home/registry/highway

### Elenco marchi:

- Endpoint: registry/brands
- Test link:  https://carburanti.mise.gov.it/ospzSearch/home/registry/brands

### Elenco loghi

- Endpoint: registry/alllogos
- Test link:  https://carburanti.mise.gov.it/ospzSearch/home/registry/alllogos

------------------

Dati odierni (tutta italia in singolo file):

- Prezzo alle 08:00: https://www.mise.gov.it/images/exportCSV/prezzo_alle_8.csv
- Anagrafica impianti attivi: https://www.mise.gov.it/images/exportCSV/anagrafica_impianti_attivi.csv

------------------

Archivio anni precedenti: https://www.mise.gov.it/it/open-data/elenco-dataset/carburanti-archivio-prezzi
