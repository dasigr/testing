<?php

/**
 * Created by PhpStorm.
 * User: das
 * Date: 27/11/2017
 * Time: 2:43 AM
 */
class PageTest extends TrueApexTestCase {

  /**
   * Test loading the homepage.
   */
  public function testHomepage() {
    // Open url.
    self::$driver->get(SITE_URL);

    // Get window handles.
    $window_handles = self::$driver->getWindowHandles();

    // Confirm authentication.
    if (isset($window_handles[0]) && $window_handles[0] == 2147483649) {
      self::$driver->switchTo()->alert()->accept();
    }

    // Maximize screen.
    self::$driver->manage()->window()->maximize();

    // Wait for page to load.
    self::$driver->wait(200, 500)->until(function($driver) {
      $elements = $driver->findElement(WebDriverBy::cssSelector('#block-views-recent-works-block .has-title .title-1'));
      return count($elements) > 0;
    });

    $this->assertEquals('Catalog | DUNIWAY', self::$driver->getTitle());
  }

}
