Product Importer Demo
---------------------

Demo application for showcasing Symfony 4 with Flex. This application simulates
a CLI command for importing products. This is somewhat representational for a
data ingest via cron jobs.

Known issues
------------

This project is a sample for using Symfony recipes like the orm-pack and
contrib-recipes like ramsey/uuid-doctrine. It is not meant to be used as a
template for a real product importer.

There is almost no validation and no duplicate detection for products.
In a real life scenario you would also use something like [Doctrine BatchUtils](https://github.com/Ocramius/DoctrineBatchUtils)
to better handle large files and to prevent exceeding the memory limit. 

Requirements
------------

- PHP 7.2+
- Database supported by Doctrine (tested with SQLite)

Installation
------------

1. Clone project

    ```
    git clone https://github.com/dbrumann/product-importer.git
    ```

2. Install dependencies
    ```
    composer install
    ```

3. Run the console command
    ```
    php bin/console products:import var/sample.csv
    ```
    
    You can replace `var/sample.csv` with the location of any csv file matching
    the requirements for the product import.

Example output
--------------

```
$ bin/console products:import var/sample.csv

Product Importer
================

 Reads a CSV file and imports the contained products into our database.
 This command will alter your database! Please be careful when using it in production.

.....


 [OK] Finished importing products.

```
