# distributori-benzina

Test per ricerca distributore più economico usando cronjob ttamite actions di github come spiegato qui:  https://theanshuman.dev/articles/free-cron-jobs-with-github-actions-31d6

Portale carburanti MISE: https://carburanti.mise.gov.it/ospzSearch/home

## API queries

Elenco province: https://carburanti.mise.gov.it/ospzApi/registry/province?regionId=9

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

Elenco comuni di data provincia: https://carburanti.mise.gov.it/ospzApi/registry/town?province=RM

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



Archivio anni precedenti: https://www.mise.gov.it/it/open-data/elenco-dataset/carburanti-archivio-prezzi
