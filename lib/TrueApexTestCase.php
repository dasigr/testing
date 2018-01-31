<?php
// Copyright 2004-present Facebook. All Rights Reserved.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

/**
 * The base class for test cases.
 */
class TrueApexTestCase extends PHPUnit_Framework_TestCase {

  /** @var RemoteWebDriver $driver */
  protected static $driver;

  protected function setUp() {
    self::$driver = RemoteWebDriver::create(
      SELENIUM_SERVER,
      array(
        WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::FIREFOX,
        'acceptInsecureCerts' => true,
      )
    );
  }

  protected function tearDown() {
    self::$driver->quit();
  }

  /**
   * Login to website.
   *
   * @param $account
   */
  protected function login($account) {
    $username = $account['username'];
    $password = $account['password'];

    // Open page and wait for 2 seconds to load.
    self::$driver->get(SITE_URL . '/user');
    sleep(3);

    // Get window handles.
    $window_handles = self::$driver->getWindowHandles();

    // Confirm authentication.
    if (isset($window_handles[1]) && $window_handles[1] == 11) {
      self::$driver->switchTo()->alert()->accept();
    }

    // Maximize screen.
    self::$driver->manage()->window()->maximize();

    // Wait for page to load.
//    self::$driver->wait(20, 500)->until(function($driver) {
//      $elements = $driver->findElement(WebDriverBy::cssSelector('h2.page-title'));
//      return count($elements) > 0;
//    });

    // Verify that you're in user login page.
//    $this->assertEquals('User account', $this->driver->findElement(WebDriverBy::cssSelector('h2.page-title'))->getText());

    // Login.
    self::$driver->findElement(WebDriverBy::cssSelector('form#user-login input[name="name"]'))->sendKeys($username);
    self::$driver->findElement(WebDriverBy::cssSelector('form#user-login input[name="pass"]'))->sendKeys($password);
    self::$driver->findElement(WebDriverBy::cssSelector('form#user-login input[value="Log in"]'))->click();
    sleep(5);

    // Wait for page to load.
//    self::$driver->wait(20, 500)->until(function($driver) {
//      $elements = $driver->findElement(WebDriverBy::cssSelector('h2.page-title'));
//      return count($elements) > 0;
//    });

    // Verify that you're in logged in.
    $this->assertContains(SITE_NAME, self::$driver->getTitle());
  }

  /**
   * Generate a random string.
   *
   * @param int $length
   * @return string
   */
  protected function randomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
}
