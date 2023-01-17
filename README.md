# distributori-benzina

Test per ricerca distributore più economico usando cronjob tramite actions di github come spiegato qui:  https://theanshuman.dev/articles/free-cron-jobs-with-github-actions-31d6

Portale carburanti MISE: https://carburanti.mise.gov.it/ospzSearch/home

## API queries

Base url: https://carburanti.mise.gov.it/ospzApi/registry/


### Elenco regioni:

- Endpoint: 
- Test link: https://carburanti.mise.gov.it/ospzApi/registry/region

### Elenco province

- Endpoint: registry/province
- https://carburanti.mise.gov.it/ospzApi/registry/province?regionId=9

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
 - Test link:  https://carburanti.mise.gov.it/ospzApi/registry/town?province=RM

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
- Test link:  https://carburanti.mise.gov.it/ospzApi/registry/highway

### Elenco marchi:

- Endpoint: registry/brands
- Test link:  https://carburanti.mise.gov.it/ospzApi/registry/brands

### Elenco loghi

- Endpoint: registry/alllogos
- Test link:  https://carburanti.mise.gov.it/ospzApi/registry/alllogos

### Dettagli area di servizio

Una volta ottenuto tramite ricerca l'id di una stazione di servizio, con questa query se ne possono ottenere i dettagli:

- Endpoint: registry/servicearea/
- Test link: https://carburanti.mise.gov.it/ospzApi/registry/servicearea/52621

### Ricerca per zona

- Url: https://carburanti.mise.gov.it/ospzApi/search/zone
- Header: body = {
      region: criteria.region,
      province: criteria.province ?? null,
      town: criteria.town ?? null,
      priceOrder: criteria.priceOrder ?? 'desc',
      fuelType: `${criteria.fuelType ?? FuelType.ALL}-${
        criteria.refuelingMode ?? RefuelingMode.ALL
      }

refuelingMode e fuelTpye sono definiti in https://github.com/Pater999/osservaprezzi-carburanti-node/blob/master/src/types/enums.ts:

```
export enum RefuelingMode {
  SELF = '1',
  SERVED = '0',
  ALL = 'x',
}

export enum FuelType {
  ALL = '0',
  PETROL = '1', // Benzina
  DIESEL = '2', // Gasolio
  METHANE = '3', // Metano
  GPL = '4',
  GCN = '323',
  GNL = '324',
}
```
###

- Endpoint: 
- Test link: https://carburanti.mise.gov.it/ospzApi/

------------------

Dati odierni (tutta italia in singolo file):

- Prezzo alle 08:00: https://www.mise.gov.it/images/exportCSV/prezzo_alle_8.csv
- Anagrafica impianti attivi: https://www.mise.gov.it/images/exportCSV/anagrafica_impianti_attivi.csv

------------------

Archivio anni precedenti: https://www.mise.gov.it/it/open-data/elenco-dataset/carburanti-archivio-prezzi
