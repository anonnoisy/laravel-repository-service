<?php

namespace App\Repositories\API\V1\Candidate\Interfaces;

use App\Libraries\API\V1\Response\Response;
use App\Models\Candidate;
use App\Models\CandidateFile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface CandidateRepoInterface
{
	public function getCandidate(Request $request): Collection|array;
	public function findCandidate(int $id): Candidate|null;
	public function storeCandidate(Request $request): Candidate|null;
	public function updateCandidate(Request $request, int $id): Candidate|null;
	public function deleteCandidate(int $id): bool|null;
	public function uploadResumeCandidate(Request $request): CandidateFile|null;
}
