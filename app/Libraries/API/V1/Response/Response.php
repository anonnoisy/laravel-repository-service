<?php

namespace App\Libraries\API\V1\Response;

use Illuminate\Container\Container;

class Response
{
	private string $message;
	private $data;
	private int $statusCode;

	public function __construct(string $message = "", $data = [], int $statusCode = 200)
	{
		$this->message = $message;
		$this->data = $data;
		$this->statusCode = $statusCode;
	}

	public static function setup($response = [], int $statusCode = 200): Response
	{
		$response = (object) $response;
		return new Response($response->message ?? '', $response->data ?? [], $statusCode);
	}

	public function message(): string
	{
		return $this->message;
	}

	public function data(): array
	{
		return $this->data;
	}

	public function statusCode(): int
	{
		return $this->statusCode;
	}

	public function json(): object
	{
		$success = $this->statusCode > 300 ? false : true;
		$data = ($success ? ['data' => $this->data] : []);

		return response()->json([
			'success' => $success,
			'message' => $this->message,
		] + $data, $this->statusCode);
	}
}
