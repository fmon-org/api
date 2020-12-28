<?php

use Faker\Factory as Faker;
use Firebase\JWT\JWT;

class UserTest extends TestCase {
	private \Faker\Generator $faker;

	public function __construct(?string $name = null, array $data = [], $dataName = '') {
		parent::__construct($name, $data, $dataName);

		$this->faker = Faker::create();
	}

	public function testReadAllUsers() {
		$response = $this->get('/api/users');

		$response->seeJsonStructure([
			'current_page',
			'data'
		]);
	}

	public function testReadOneUsers() {
		$response = $this->get('/api/users/1');

		$response->seeJsonStructure([
			'user'
		]);
	}

	public function testRegisterWithoutData() {
		$response = $this->post('api/register');
		$response->seeStatusCode(422);
		$response->seeJsonStructure([
			'username', 'email', 'password'
		]);
	}

	public function testRegisterWithDataDuplicatedData() {
		$data = [
			"username" => "test",
			"email" => "test@gmail.com"
		];

		$response = $this->post('api/register', $data);
		$response->seeStatusCode(422);
		$response->seeJsonStructure([
			'username', 'email'
		]);
	}

	public function testRegisterWithInvalidPassword() {
		$data = [
			"username" => $this->faker->name,
			"email" => $this->faker->email,
		];

		$response = $this->post('api/register', $data);
		$response->seeStatusCode(422);
		$response->seeJsonStructure([
			'password'
		]);

		$data['password'] = '123456';
		$response = $this->post('api/register', $data);
		$response->seeStatusCode(422);
		$response->seeJsonStructure([
			'password'
		]);

		$data['password_confirmation'] = '1234564';
		$response = $this->post('api/register', $data);
		$response->seeStatusCode(422);
		$response->seeJsonStructure([
			'password'
		]);
	}

	public function testRegisterUser() {
		$data = [
			"username" => $this->faker->name,
			"email" => $this->faker->email,
			"password" => "123456",
			"password_confirmation" => "123456"
		];

		$response = $this->post('api/register', $data);
		$response->seeStatusCode(200);
		$response->seeJsonStructure([
			'user'
		]);
	}

	public function testLogin() {
		$data = [
			"username" => "test",
			"password" => "123456",
		];

		$response = $this->post('api/login', $data);
		$response->seeStatusCode(200);
		$response->seeJsonStructure([
			'user', 'token'
		]);
	}

	public function testLoginWithDisabledUser() {
		$data = [
			"username" => "disabled",
			"password" => "123456",
		];

		$response = $this->post('api/login', $data);
		$response->seeStatusCode(401);
		$response->seeJsonStructure([
			'user'
		]);
	}

	public function testLoginWithInvalidUser() {
		$data = [
			"username" => "ab",
			"password" => "123",
		];

		$response = $this->post('api/login', $data);
		$response->seeStatusCode(401);
		$response->seeJsonStructure([
			'username'
		]);
	}

	public function testLoginWithInvalidPassword() {
		$data = [
			"username" => "test",
			"password" => "123",
		];

		$response = $this->post('api/login', $data);
		$response->seeStatusCode(401);
		$response->seeJsonStructure([
			'password'
		]);
	}

	public function testGetMyUser() {
		$token = JWT::encode(
			['id' => 1],
			env('JWT_KEY')
		);

		$headers = [
			"Authorization" => "Bearer ".$token
		];

		$response = $this->get('api/me', $headers);

		$response->seeStatusCode(200);
		$response->seeJsonStructure([
			'user'
		]);
	}
}
