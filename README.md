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

- **`gasStations`**: This endpoint provides the geographical location of gas stations, subject to the selected filtering values
such as a province or availability. If stations are queried by fuel type, the price and its price type is also provided.
- **`stationsDetails`**: This endpoint is very handy when you need more details about a gas station apart from its pricing or geographical location.
  
## Example
Here is an example where we are retrieving all CNG gas stations in Spain:

```php
use Flerex\SpainGas\Enums\Fuel;
use Flerex\SpainGas\GasApi;

// ...
$stations = GasApi::gasStations()
    ->fuel(Fuel::CNG())
    ->get();
```
