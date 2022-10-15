<?php

namespace App\Repositories\API\V1\Candidate;

use App\Repositories\API\V1\Candidate\Interfaces\CandidateRepoInterface;
use App\Models\Candidate;
use App\Models\CandidateFile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CandidateRepoImpl implements CandidateRepoInterface
{
	public function getCandidate(Request $request): Collection
	{
		$candidateList = Candidate::orderBy('updated_at')->get();
		return $candidateList;
	}

	public function findCandidate(int $id): Candidate|null
	{
		$candidate = Candidate::find($id);
		return $this->populateCandidateWithFiles($candidate);
	}

	public function storeCandidate(Request $request): Candidate|null
	{
		$createdCandidate = Candidate::create($this->setupCandidateDataStore($request));
		$createdCandidate->skills()->sync($request->skill_ids);
		return $this->populateCandidateWithFiles($createdCandidate);
	}

	public function updateCandidate(Request $request, int $id): Candidate|null
	{
		$candidate = Candidate::where('id', $id)->first();

		if (!empty($candidate)) {
			$candidate->update($this->setupCandidateDataStore($request));
			$candidate->skills()->sync($request->skill_ids);
			$candidate = $this->populateCandidateWithFiles($candidate);
		}

		return $candidate;
	}

	public function deleteCandidate(int $id): bool|null
	{
		$candidate = Candidate::find($id);
		if (!empty($candidate)) {
			$candidate->delete();

			return true;
		}

		return false;
	}

	/**
	 * Method used for upload candidate resume file
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \App\Libraries\API\V1\Response\Response
	 * @author Rifky Sultan Karisma A <rifkysultanka@gmail.com>
	 */
	public function uploadResumeCandidate(Request $request): CandidateFile|null
	{
		if ($file = $request->file('resume_file')) {
			$randStrAsDir = Uuid::uuid4()->toString();
			$name = $randStrAsDir . "-" . date('Ymdhis') . "." . $file->getClientOriginalExtension();
			$path = $file->storeAs("/files/resumes", $name);

			$uploadedResume = CandidateFile::create([
				'candidate_email' => $request->candidate_email,
				'file_name' => $name,
				'path' => $path,
			]);

			return $uploadedResume;
		}

		return null;
	}

	private function setupCandidateDataStore(Request $request): array
	{
		return [
			'first_name' => $request->first_name,
			'last_name' => $request->last_name ?? NULL,
			'email' => $request->email,
			'phone_number' => $request->phone_number,
			'birth_date' => $request->birth_date,
			'education_id' => $request->education_id,
			'applied_position_id' => $request->applied_position_id,
			'last_position_id' => $request->last_position_id,
			'experience' => $this->getExperience($request->experience),
		];
	}

	private function populateCandidateWithFiles(Candidate $candidate): Candidate
	{
		DB::table('candidate_files')
			->where('candidate_email', $candidate->email)
			->where('candidate_id', NULL)
			->update(['candidate_id' => $candidate->id]);

		return $candidate->first();
	}

	/**
	 * This method to manipulate experience information from request
	 *
	 * @param Request $experienceRequest
	 * @return int $experience
	 */
	private function getExperience($experienceRequest): int
	{
		$experienceMonths = (object) $experienceRequest;

		$experience = $experienceMonths->time;
		if ($experienceMonths->time_type == 'year') {
			$experience = $experienceMonths->time * 12;
		}

		return $experience;
	}
}
