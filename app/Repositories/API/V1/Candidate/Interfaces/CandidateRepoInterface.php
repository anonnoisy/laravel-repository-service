<?php

namespace App\Repositories\API\V1\Candidate\Interfaces;

use App\Libraries\API\V1\Response\Response;
use Illuminate\Http\Request;

interface CandidateRepoInterface
{
	public function getCandidate(Request $request): Response;
	public function findCandidate(int $id): Response;
	public function storeCandidate(Request $request): Response;
	public function updateCandidate(Request $request, int $id): Response;
	public function deleteCandidate(int $id): Response;
	public function uploadResumeCandidate(Request $request): Response;
}
