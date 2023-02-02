**Distributori benzina**

Pagina di interrogazione per il [Portale carburanti MISE]( https://carburanti.mise.gov.it/ospzSearch/home).

# API queries

## Interrogazione dati statici ([fonte](https://github.com/Pater999/osservaprezzi-carburanti-node/blob/master/src/methods/registry.ts))

Base url: https://carburanti.mise.gov.it/ospzApi/registry/

### Elenco regioni:

- Endpoint: /region
- Test link: https://carburanti.mise.gov.it/ospzApi/registry/region

### Elenco province

- Endpoint: /province
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

 - Endpoint: /town
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

### Elenco autostrade d'italia 

- Endpoint: /highway
- Test link:  https://carburanti.mise.gov.it/ospzApi/registry/highway

### Elenco marchi:

- Endpoint: /brands
- Test link:  https://carburanti.mise.gov.it/ospzApi/registry/brands

### Elenco loghi

- Endpoint: /alllogos
- Test link:  https://carburanti.mise.gov.it/ospzApi/registry/alllogos

### Dettagli area di servizio

Una volta ottenuto tramite ricerca l'id di una stazione di servizio, con questa query se ne possono ottenere i dettagli:

- Endpoint: /servicearea
- Test link: https://carburanti.mise.gov.it/ospzApi/registry/servicearea/52621


## Interrogazioni per dati dinamici (prezzi) ## 

Criteri di base per tutter le query da mettere nell'header del POST:

- Base url:  https://carburanti.mise.gov.it/ospzApi

- fuelType: v. sotto
- refuelingMode: v. sotto
- priceOrder: "asc" oppure "desc"

  
### Ricerca per nome

- Endpoint:  /search/area
- Url: https://carburanti.mise.gov.it/ospzApi/search/area
- Header: vuoto
- Payload: 

    - region: ([numero](https://carburanti.mise.gov.it/ospzApi/registry/region)),     
    - province: ([sigla della provincia](https://carburanti.mise.gov.it/ospzApi/registry/province?regionId=9) oppure null; il link di esempio fornisce l'elenco delle province della regione 9  (Lazio)),     
    - town: ([nome del coumne](https://carburanti.mise.gov.it/ospzApi/registry/town?province=RM) oppure null; il link di esempio fornisce la lista dei comuni della provincia di Roma),
    - priceOrder: "asc" o "desc",      
    - fuelType: "FuelType-RefuelingMode"  (FuelType e RefuelingMode sono numeri (v. sotto))
      


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


- Esempio di header completo:

```
{ 
 "region" : 9, 
 "province" : "RM", 
 "town" :  "Monterotondo", 
 "priceOrder" : "desc",
 "fuelType":  "1-1",
 "refuelingMode" : 1
}
```

Risultato:


```
{
    "success": true,
    "center": {
        "lat": xxxxxxxxxx,
        "lng": yyyyyyyyyyyyyyy
    },
    "results": []
}  
```

Formato delle singole stazioni di servizio nell'array "results":

```
{
        "id": zzzzzzzzzzzz,
        "name": "nnnnnnnnnnnnnnnnn",
        "fuels": [{
            "id": ffffffffffffffffffff,
            "price": ppppppppppppp,
            "name": "nnnnnnnnnnnnnnnnnn",
            "fuelId": 1,
            "isSelf": false
        }
 ```
 


### Ricerca per zona  (poligono o cerchio+distanza)

- Endpoint:  search/zone
- Url: https://carburanti.mise.gov.it/ospzApi/search/zone
- Header: vuoto
- Payload:
```
{
      points: v.sotto,
      radius: se il punto è uno solo, "radius" indica il raggio del cerchio centrato su quel punto
      priceOrder:"asc" oppure "desc",
      fuelType: FuelType-refuelingMode
      }
```

points: array di punti
```
points: [
      { lat: 42.32843626674558, lng: 12.188716303785915 },
      { lat: 42.389322963743865, lng: 12.37136400886404 },
      { lat: 42.31726730642802, lng: 12.44277514167654 }
      ]

```


Esempio di payload:

```
{
      "points": [
        { "lat": 42.32843626674558,  "lng": 12.188716303785915 },
        { "lat": 42.389322963743865, "lng": 12.37136400886404 },
        { "lat": 42.31726730642802,  "lng": 12.44277514167654 }
      ],
      "priceOrder":"asc",
      "fuelType": "1-1"
      }
```

Risultato:

```
{
    "success": true,
    "center": {
        "lat": xxxxxxxxxx,
        "lng": yyyyyyyyyy
    },
    "results": []
}  
```

Formato delle singole stazioni di servizio nell'array "results":

```
{
        "id": zzzzzzzzzzzz,
        "name": "nnnnnnnnnnnnnnnnn",
        "fuels": [{
            "id": ffffffffffffffffffff,
            "price": ppppppppppppp,
            "name": "nnnnnnnnnnnnnnnnnn",
            "fuelId": 1,
            "isSelf": false
        }
 ```
 
 Risultato di esempio:
        
```
{
    "success": true,
    "center": {
        "lat": 42.33088458461678,
        "lng": 12.367447844979438
    },
    "results": [{
        "id": 35947,
        "name": "ROSSI VINCENZO",
        "fuels": [{
            "id": 47697237,
            "price": 1.969,
            "name": "Benzina",
            "fuelId": 1,
            "isSelf": false
        }, {
            "id": 47697236,
            "price": 1.819,
            "name": "Benzina",
            "fuelId": 1,
            "isSelf": true
        }, {
            "id": 47697239,
            "price": 2.029,
            "name": "Gasolio",
            "fuelId": 2,
            "isSelf": false
        }, {
            "id": 47697238,
            "price": 1.879,
            "name": "Gasolio",
            "fuelId": 2,
            "isSelf": true
        }],
        "location": {
            "lat": 42.32184123834649,
            "lng": 12.435450553894043
        },
        "insertDate": "2023-01-16T16:37:55+01:00",
        "address": "VIA FLAMINIA KM56,60 01030 - CIVITA CASTELLANA VT",
        "brand": "Esso"
    }, {
        "id": 36318,
        "name": "G.P.OIL",
        "fuels": [{
            "id": 47689250,
            "price": 1.849,
            "name": "Benzina",
            "fuelId": 1,
            "isSelf": true
        }, {
            "id": 47689251,
            "price": 1.889,
            "name": "Gasolio",
            "fuelId": 2,
            "isSelf": true
        }],
        "location": {
            "lat": 42.34173739391245,
            "lng": 12.357730430653419
        },
        "insertDate": "2023-01-16T12:24:55+01:00",
        "address": "VIA PER CIVITACASTELLANA 64 01030 - CORCHIANO VT",
        "brand": "PompeBianche"
    }
    ]
}
```

### Link google centrato su coordinate LAT, LON: https://www.google.it/maps/@LAT,LON,17z


------------------

Dati odierni (tutta italia in singolo file):

- Prezzo alle 08:00: https://www.mise.gov.it/images/exportCSV/prezzo_alle_8.csv
- Anagrafica impianti attivi: https://www.mise.gov.it/images/exportCSV/anagrafica_impianti_attivi.csv
- Archivio anni precedenti: https://www.mise.gov.it/it/open-data/elenco-dataset/carburanti-archivio-prezzi
