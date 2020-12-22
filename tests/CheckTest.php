<?php

class CheckTest extends TestCase {
	public function testExample(): void {
		$this->get('/api');

		$this->assertEquals(
			env('APP_NAME') . ' is available', $this->response->getContent()
		);
	}
}
