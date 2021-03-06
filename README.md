# BrowserDetector

[![Latest Stable Version](https://poser.pugx.org/mimmi20/browser-detector/v/stable?format=flat-square)](https://packagist.org/packages/mimmi20/browser-detector)
[![Latest Unstable Version](https://poser.pugx.org/mimmi20/browser-detector/v/unstable?format=flat-square)](https://packagist.org/packages/mimmi20/browser-detector)
[![License](https://poser.pugx.org/mimmi20/browser-detector/license?format=flat-square)](https://packagist.org/packages/mimmi20/browser-detector)

## Code Status

[![codecov](https://codecov.io/gh/mimmi20/BrowserDetector/branch/master/graph/badge.svg)](https://codecov.io/gh/mimmi20/BrowserDetector)
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/mimmi20/BrowserDetector.svg)](http://isitmaintained.com/project/mimmi20/BrowserDetector "Average time to resolve an issue")
[![Percentage of issues still open](http://isitmaintained.com/badge/open/mimmi20/BrowserDetector.svg)](http://isitmaintained.com/project/mimmi20/BrowserDetector "Percentage of issues still open")

## Requirements

This library requires PHP 7.4+.
Also a PSR-3 compatible logger and a PSR-16 compatible cache are required.

## Installation

Run the command below to install via Composer

```shell
composer require mimmi20/browser-detector
```

## Usage

```php
$detectorFactory = new \BrowserDetector\DetectorFactory($cache, $logger);
$detector        = $detectorFactory();

// get the result
$result = $detector->getBrowser($request); // (deprecated)
$result = $detector($request);
```

The request parameter may be a string, an array or a PSR-7 compatible message.

## Usage Examples

### Taking the user agent from the global $_SERVER variable

```php
$detectorFactory = new \BrowserDetector\DetectorFactory($cache, $logger);
$detector        = $detectorFactory();

$result = $detector($_SERVER);
```

### Using a sample useragent

```php
$detectorFactory = new \BrowserDetector\DetectorFactory($cache, $logger);
$detector        = $detectorFactory();

$result = $detector($the_user_agent);
```

## The result

The `getBrowser` function and the `__invoke` function return a [ua-result](https://github.com/mimmi20/ua-result) object.

## Issues and feature requests

Please report your issues and ask for new features on the GitHub Issue Tracker
at https://github.com/mimmi20/BrowserDetector/issues
