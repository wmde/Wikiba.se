<?php

use PHPUnit\Framework\TestCase;

/**
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SmokeTest extends TestCase {
	private static $PAGE_PATH;

	public static function setUpBeforeClass() : void {
		self::$PAGE_PATH = __DIR__ . '/../output_test/';
		// In this particular case exec is needed to generate the static site output
		// phpcs:disable MediaWiki.Usage.ForbiddenFunctions.exec
		exec( 'composer build-test' );
		// phpcs:enable MediaWiki.Usage.ForbiddenFunctions.exec
	}

	/**
	 * @coversNothing
	 */
	public function testMainPageContainsIntroText() {
		$this->assertPageContains(
			'Wikibase is an open-source software suite for creating',
			'index.html'
		);
	}

	/**
	 * @coversNothing
	 */
	public function testLibrariesPageContainsLibraries() {
		$this->assertPageContains(
			'Libraries',
			'libraries/index.html'
		);
	}

	/**
	 * @coversNothing
	 */
	public function testBootstrapCssIsWhereExpected() {
		$this->assertRelativeFileExists( 'components/bootstrap/dist/css/bootstrap.min.css' );
	}

	private function assertRelativeFileExists( $fileName ) {
		$this->assertFileExists( self::$PAGE_PATH . $fileName );
	}

	private function assertPageContains( $expected, $fileName ) {
		$this->assertRelativeFileExists( $fileName );

		$page = file_get_contents( self::$PAGE_PATH . $fileName );

		$this->assertStringContainsString(
			$expected,
			$page
		);
	}

}
