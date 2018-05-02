<?php
class TimeManager {
  public static function setTimezone($timezone) {
    date_default_timezone_set($timezone);
  }

  public static function getTimezone() {
    return date_default_timezone_get();
  }
}