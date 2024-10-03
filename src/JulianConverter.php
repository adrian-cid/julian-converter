<?php

namespace AdrianCid\Calendar;

class JulianConverter {

  /**
   * Convert a Gregorian date with time to Julian date.
   *
   * @param \DateTime $gregorian_date
   *   The DateTime object representing the Gregorian date and time.
   *
   * @return float
   *   The Julian date, including the fractional day for time.
   */
  public function convertGregorianToJulianDate(\DateTime $gregorian_date): float {
    // Extract year, month, day, hour, minute, and second from the DateTime object.
    $gregorian_year = (int) $gregorian_date->format('Y');
    $gregorian_month = (int) $gregorian_date->format('m');
    $gregorian_day = (int) $gregorian_date->format('d');
    $gregorian_hour = (int) $gregorian_date->format('H');
    $gregorian_minute = (int) $gregorian_date->format('i');
    $gregorian_second = (int) $gregorian_date->format('s');

    // Adjust for January and February being considered the 13th and 14th months of the previous year.
    if ($gregorian_month <= 2) {
      $gregorian_year--;
      $gregorian_month += 12;
    }

    // Calculate the century for the Gregorian calendar reform.
    $century = floor($gregorian_year / 100);
    $leap_year_correction = 2 - $century + floor($century / 4);

    // Calculate the Julian Day Number.
    $julian_day = floor(365.25 * ($gregorian_year + 4716)) + floor(30.6001 * ($gregorian_month + 1)) + $gregorian_day + $leap_year_correction - 1524.5;

    // Calculate the fractional day based on the time (hours, minutes, seconds).
    $fractional_day = ($gregorian_hour + ($gregorian_minute / 60) + ($gregorian_second / 3600)) / 24;

    // Add the fractional day to the Julian Day Number.
    return $julian_day + $fractional_day;
  }

  /**
   * Convert a Julian date to a Gregorian date with time and return a DateTime object.
   *
   * @param float $julian_date
   *   The Julian date to convert.
   *
   * @return \DateTime
   *   A DateTime object representing the equivalent Gregorian date and time.
   */
  public function convertJulianToGregorianDate(float $julian_date): \DateTime {
    // Adjust Julian date to start from midnight.
    $julian_date += 0.5;
    $julian_day_integer = (int) $julian_date;
    $fractional_day = $julian_date - $julian_day_integer;

    // Handle Gregorian calendar reform: If the Julian day is before October 15, 1582, use the Julian calendar.
    if ($julian_day_integer < 2299161) {
      $adjusted_julian_day = $julian_day_integer;
    } else {
      $century_adjustment = (int) (($julian_day_integer - 1867216.25) / 36524.25);
      $adjusted_julian_day = $julian_day_integer + 1 + $century_adjustment - (int)($century_adjustment / 4);
    }

    $intermediate_day_number = $adjusted_julian_day + 1524;
    $gregorian_year_calculated = (int) (($intermediate_day_number - 122.1) / 365.25);
    $days_in_year = (int) (365.25 * $gregorian_year_calculated);
    $month_day_number = (int) (($intermediate_day_number - $days_in_year) / 30.6001);

    // Calculate the day, month, and year.
    $gregorian_day = $intermediate_day_number - $days_in_year - (int) (30.6001 * $month_day_number);
    $gregorian_month = ($month_day_number < 14) ? $month_day_number - 1 : $month_day_number - 13;
    $gregorian_year = ($gregorian_month > 2) ? $gregorian_year_calculated - 4716 : $gregorian_year_calculated - 4715;

    // Convert the fractional day to hours, minutes, and seconds.
    $hours_in_day = $fractional_day * 24;
    $gregorian_hour = (int) $hours_in_day;
    $minutes_in_hour = ($hours_in_day - $gregorian_hour) * 60;
    $gregorian_minute = (int) $minutes_in_hour;
    $gregorian_second = (int) (($minutes_in_hour - $gregorian_minute) * 60);

    // Create and return the DateTime object.
    $gregorian_date_time = new \DateTime();
    $gregorian_date_time->setDate($gregorian_year, $gregorian_month, (int) $gregorian_day);
    $gregorian_date_time->setTime($gregorian_hour, $gregorian_minute, $gregorian_second);

    return $gregorian_date_time;
  }
}
