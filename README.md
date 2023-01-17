# distributori-benzina

Test per ricerca distributore più economico usando cronjob tramite actions di github come spiegato qui:  https://theanshuman.dev/articles/free-cron-jobs-with-github-actions-31d6

Portale carburanti MISE: https://carburanti.mise.gov.it/ospzSearch/home

Libreria usata per chiamate al server nelle actions: https://github.com/Satak/webrequest-action

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

## Ricerche ## 

Criteri di base per tutter le query da mettere nell'header del POST:


- fuelType: v. sotto
- refuelingMode: v. sotto
- priceOrder: "asc" oppure "desc"

  
### Ricerca per zona

- Base url:  https://carburanti.mise.gov.it/ospzApi/
- Endpoint:  search/zone
- Url: https://carburanti.mise.gov.it/ospzApi/search/zone
- Criteri aggiuntivi in header: 

region: ([numero](https://carburanti.mise.gov.it/ospzApi/registry/region)),
      
province: ([sigla della provincia](https://carburanti.mise.gov.it/ospzApi/registry/province?regionId=9) oppure null; il link di esempio fornisce l'elenco delle province della regione 9  (Lazio)),
      
town: ([nome del coumne](https://carburanti.mise.gov.it/ospzApi/registry/town?province=RM) oppure null; il link di esempio fornisce la lista dei comuni della provincia di Roma),

priceOrder: "asc" o "desc",
      
fuelType: "FuelType-RefuelingMode"  (FuelType e RefuelingMode sono numeri (v. sotto))
      
- Esempio di header completo:

```
{
fuelType: 1,
refuelingMode: 1,
priceOrder: "asc",
region:9,      
province: "RM",
town: "Affile"
}
```



*refuelingMode* e *fuelTpye* sono definiti in https://github.com/Pater999/osservaprezzi-carburanti-node/blob/master/src/types/enums.ts:

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



Esempio:
```
{ "region" : 9, 
 "province" : "RM", 
 "town" :  "Affile", 
 "priceOrder" : "desc",
 "fuelType":  "1-1"
}
```

Risultato (probabilmente il centro dell'area di ricerca, da usare per una successiva query):
```
{
    "success": false,
    "center": {
        "lat": 41.890546,
        "lng": 41.890546
    },
    "results": []
}

```
### Ricerca per area

- Base url:  https://carburanti.mise.gov.it/ospzApi/
- Endpoint:  search/area
- Url: https://carburanti.mise.gov.it/ospzApi/search/area
- Header: 
```
{
      region: criteria.region,
      province: criteria.province ?? null,
      town: criteria.town ?? null,
      priceOrder: criteria.priceOrder ?? 'desc',
      fuelType: `${criteria.fuelType ?? FuelType.ALL}-${
        criteria.refuelingMode ?? RefuelingMode.ALL
      }
```



search/area
###

- Endpoint: 
- Test link: https://carburanti.mise.gov.it/ospzApi/

------------------

Dati odierni (tutta italia in singolo file):

- Prezzo alle 08:00: https://www.mise.gov.it/images/exportCSV/prezzo_alle_8.csv
- Anagrafica impianti attivi: https://www.mise.gov.it/images/exportCSV/anagrafica_impianti_attivi.csv

------------------

Archivio anni precedenti: https://www.mise.gov.it/it/open-data/elenco-dataset/carburanti-archivio-prezzi
