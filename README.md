# Spain Gas
Spain Gas is a PHP client that act as a wrapper around Spain's Geoportal Gasolineras API. It has the following main features:

- Obtain **data about all gas stations** in Spain: addresses, geolocation, provided services, schedules and much more!
- Exact **prices of fuel** for every gas station in the country, updated multiple times every day.
- Beautifully designed interface using design patterns like the builder pattern.
- Statically typed with the latest PHP typing features. 
- Properly tested with coverage higher than 80%.

## Requirements
- You need `composer` to be installed, either globally or locally in your project.
- Compatible with **PHP 7.4 or higher**.
- PHP's extensions needed: `ext-json`.

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

Every endpoint returns an instance of a Builder class, which provides methods to filter the request to be made. Once you selected your filtering parameters, a call to method `get` is required to actually run the request and retrieve the data.

In case you need more information about what filters are available check the Documentation.
  
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

### Get specific town ID
Let us suppose we needed to obtain all gas stations in A Coruña (city). To be able to filter by town in the `gasStations` endpoint, we will first need to retrieve the ID of the town.

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

### Get the price ranking
Price rankings are used to categorize the price of some fuel in a gas station comparing it to their competitors. The algorithm used by the API is unknown.

Unfortunately, rankings are only available in the `locateGasStations` endpoints.

In the following example we are going to retrieve the cheapest self-service gas stations.

```php
use Flerex\SpainGas\Dtos\GasStationLocation;
use Flerex\SpainGas\Enums\Rank;
use Flerex\SpainGas\Enums\Fuel;
use Flerex\SpainGas\Enums\ServiceType;
use Flerex\SpainGas\GasApi;

$stations = GasApi::locateGasStations()
    ->serviceType(ServiceType::SELF_SERVICE())
    ->fuel(Fuel::DIESEL_A())
    ->get();

$cheapest = array_filter($stations, fn(GasStationLocation $station) => $station->rank->equals(Rank::CHEAP()));
```
**NOTE:** We need to specify a fuel so that rankings are provided in return.