# Spain Gas
Spain Gas is a PHP client that act as a wrapper around Spain's Geoportal Gasolineras API. It has the following main features:

- Compatible with **PHP 7.4 onwards**.
- Statically typed with the latest PHP typing features. 
- Beautifully designed using patterns like the Builder pattern.
- Tested with coverage higher than 80%.

## Installation
To install this package be sure to have `composer` installed and run the following command in your project's directory:

```
composer require flerex/spain-gas
```
 
## Usage
All the API's endpoints are available by using the GasApi class. Currently, there are only two endpoints for the API:

- **`gasStations`**: This is the most useful endpoint. With it, you can find gas stations by different filters such as province or availability.  
- **`towns`**: Returns a list of `Town` objects. Useful to obtain the ID of a specific town to use as filter in other endpoints.  
- **`locateGasStations`**: This endpoint provides the geographical location of gas stations. The only difference with the previous endpoint is that provides a ranking of the gas station according to the price of the fuel (if specified as a filter).

**NOTE:** All the aforementioned endpoints will provide the price of the fuel if specified by using the query filter `fuel`. Otherwise, it will always return `null`.
  
## Example

### Obtain Stations by Fuel
Here is an example where we are retrieving all CNG gas stations in Spain:

```php
use Flerex\SpainGas\Enums\Fuel;
use Flerex\SpainGas\GasApi;

$stations = GasApi::gasStations()
    ->fuel(Fuel::CNG())
    ->get();
```

### Get all gas stations in A Coruña

```php
use Flerex\SpainGas\Dtos\Town;
use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\GasApi;

$towns = GasApi::towns()
    ->province(Province::A_CORUNHA())
    ->get();
    
$townId = array_filter($towns, fn(Town $town) => stripos($town->name, 'Coruña') !== false)[0];

// Everything up to this point could be done once and then be replaced with the obtained ID to avoid unnecessary API calls. 

$stations = GasApi::gasStations()
    ->town($townId)
    ->get();
```
