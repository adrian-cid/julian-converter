
# Julian Date Converter

[![Latest Stable Version](https://poser.pugx.org/adrian-cid/julian-converter/v/stable)](https://packagist.org/packages/adrian-cid/julian-converter)
[![Total Downloads](https://poser.pugx.org/adrian-cid/julian-converter/downloads)](https://packagist.org/packages/adrian-cid/julian-converter)
[![License](https://poser.pugx.org/adrian-cid/julian-converter/license)](https://packagist.org/packages/adrian-cid/julian-converter)

**Julian Date Converter** is a simple PHP library for converting dates between the **Gregorian** calendar and **Julian** dates, with precision down to seconds. It handles both conversions, taking into account the fractional day for exact time calculations.

## Installation

You can install this package using [Composer](https://getcomposer.org/).

```bash
composer require adrian-cid/julian-converter
```

## Requirements

- PHP 8.2 or higher.

## Usage

### 1. Convert Gregorian Date to Julian Date

You can convert any `DateTime` object from the Gregorian calendar to its equivalent Julian Date. The result will be a `float` representing the Julian Date, including the fractional day for hours, minutes, and seconds.

```php
use AdrianCid\Calendar\JulianConverter;

// Create a DateTime object with the desired date and time.
$gregorian_date = new \DateTime('2024-10-02 15:30:00');

// Instantiate the converter and convert the Gregorian date to Julian date.
$converter = new JulianConverter();
$julian_date = $converter->convertGregorianToJulianDate($gregorian_date);

echo "The Julian Date is: " . $julian_date; // Output: The Julian Date is: 2460111.145833
```

### 2. Convert Julian Date to Gregorian Date

To convert a Julian Date back to the Gregorian calendar, use the `convertJulianToGregorianDate()` method. The result will be a `DateTime` object representing the equivalent Gregorian date and time.

```php
use AdrianCid\Calendar\JulianConverter;

// Example Julian date.
$julian_date = 2460111.145833;

// Convert the Julian date back to a Gregorian DateTime object.
$gregorian_date = $converter->convertJulianToGregorianDate($julian_date);

echo "The Gregorian Date is: " . $gregorian_date->format('Y-m-d H:i:s');
// Output: The Gregorian Date is: 2024-10-02 15:30:00
```

## Methods

### `convertGregorianToJulianDate(\DateTime $gregorian_date): float`

Converts a `DateTime` object (Gregorian date) into a Julian Date as a `float`. The fractional part of the Julian Date reflects the time of day.

- **Parameters**:
  - `\DateTime $gregorian_date`: The date to be converted (Gregorian).

- **Returns**:
  - `float`: The Julian Date with the fractional day included.

### `convertJulianToGregorianDate(float $julian_date): \DateTime`

Converts a Julian Date to a `DateTime` object (Gregorian date).

- **Parameters**:
  - `float $julian_date`: The Julian date to be converted.

- **Returns**:
  - `\DateTime`: The equivalent Gregorian date and time.

## License

This package is licensed under the GPL-3.0 License. See the [LICENSE](LICENSE) file for more details.
