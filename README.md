# Crawling-search-engine
The package is supposed to be a library for crawling search engine results and extracting metadata for a set of keywords for the first 5 pages.

## Installation

### Requirements

The latest version of the SDK requires PHP version 7.1 or higher.



To use Composer:

- First, install Composer if you don't have it already

    ```shell
    curl -sS https://getcomposer.org/installer | php
    ```

- Create a `composer.json` file and add the following:

    ```json
    {
        "require": {
			"search-engine/crawling-search-engine": "^2.3"
        }
    }
    ```
- OR 
  ```
  composer require search-engine/crawling-search-engine

  ```
- Install `crawling-search-engine` package via Composer

    ```shell
    php composer.phar install
    ```

- Include the library in your script

    ```php
    require_once 'vendor/autoload.php';

    use SearchEngine\SearchEngine;
    ```
- See below for how to configure your Client class.

### Sample Usage

```php
use SearchEngine\SearchEngine;

$client = new SearchEngine();

$client->setEngine("google.ae");

$results = $client->search(["Mustafa Abbas","Bashar Rahal"]);

echo '<pre>';

print_r($results);
```
