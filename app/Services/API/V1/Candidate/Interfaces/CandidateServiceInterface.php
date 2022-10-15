<?php

namespace App\Services\API\V1\Candidate\Interfaces;

use App\Libraries\API\V1\Response\Response;
use Illuminate\Http\Request;

interface CandidateServiceInterface
{
	public function index(Request $request): Response;
	public function store(Request $request): Response;
	public function show(int $id): Response;
	public function update(Request $request, int $id): Response;
	public function delete(int $id): Response;
	public function upload(Request $request): Response;
}
