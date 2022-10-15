<?php

namespace App\Repositories\API\V1\Candidate;

use App\Libraries\API\V1\Response\ErrorResponse;
use App\Repositories\API\V1\Candidate\Interfaces\CandidateRepoInterface;
use App\Libraries\API\V1\Response\Response;
use App\Libraries\API\V1\Response\StatusCode;
use App\Libraries\API\V1\Response\SuccessResponse;
use App\Models\Candidate;
use App\Models\CandidateFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CandidateRepoImpl implements CandidateRepoInterface
{
	public function getCandidate(Request $request): Response
	{
		$candidateList = Candidate::orderBy('updated_at')->get();

		if ($candidateList->count() < 1) {
			return ErrorResponse::setup([], StatusCode::NO_CONTENT);
		}

		return SuccessResponse::setup([
			'message' => 'successfully get candidate list',
			'data' => $candidateList
		], StatusCode::OK);
	}

	public function findCandidate(int $id): Response
	{
		$candidate = Candidate::find($id);
		$candidate = $this->populateCandidateWithFiles($candidate);

		if (!empty($candidate)) {
			return Response::setup([
				'message' => 'successfully find candidate',
				'data' => $candidate
			], StatusCode::OK);
		}

		return Response::setup([
			'message' => 'candidate not found.'
		], StatusCode::NOT_FOUND);
	}

	public function storeCandidate(Request $request): Response
	{
		try {
			$createdCandidate = Candidate::create($this->setupCandidateDataStore($request));
			$createdCandidate->skills()->sync($request->skill_ids);
			$candidate = $this->populateCandidateWithFiles($createdCandidate);

			return Response::setup([
				'message' => 'successfully added new candidate',
				'data' => $candidate,
			], StatusCode::OK);
		} catch (Exception $e) {
			return Response::setup([
				'message' => 'something went wrong.',
			], StatusCode::ERROR_CODE);
		}
	}

	public function updateCandidate(Request $request, int $id): Response
	{
		$candidate = Candidate::where('id', $id)->first();

		if (!empty($candidate)) {
			$candidate->update($this->setupCandidateDataStore($request));
			$candidate->skills()->sync($request->skill_ids);
			$candidate = $this->populateCandidateWithFiles($candidate);

			return Response::setup([
				'success' => true,
				'message' => 'successfully updated candidate.',
				'data' => $candidate
			], StatusCode::OK);
			try {
			} catch (Exception $e) {
				return Response::setup([
					'success' => false,
					'message' => 'something went wrong.',
				], StatusCode::ERROR_CODE);
			}
		}

		return Response::setup([
			'success' => false,
			'message' => 'candidate not found.'
		], StatusCode::NOT_FOUND);
	}

	public function deleteCandidate(int $id): Response
	{
		$candidate = Candidate::find($id);
		if (!empty($candidate)) {
			$candidate->delete();

			return Response::setup([], StatusCode::NO_CONTENT);
		}

		return Response::setup([
			'success' => false,
			'message' => 'candidate not found.'
		], StatusCode::NOT_FOUND);
	}

	/**
	 * Method used for upload candidate resume file
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \App\Libraries\API\V1\Response\Response
	 * @author Rifky Sultan Karisma A <rifkysultanka@gmail.com>
	 */
	public function uploadResumeCandidate(Request $request): Response
	{
		try {
			if ($file = $request->file('resume_file')) {
				$randStrAsDir = Uuid::uuid4()->toString();
				$name = $randStrAsDir . "-" . date('Ymdhis') . "." . $file->getClientOriginalExtension();
				$path = $file->storeAs("/files/resumes", $name);

				$uploadedResume = CandidateFile::create([
					'candidate_email' => $request->candidate_email,
					'file_name' => $name,
					'path' => $path,
				]);

				return Response::setup([
					'success' => true,
					'message' => 'successfully uploaded candidate resume file.',
					'data' => $uploadedResume
				], StatusCode::CREATED);
			}
		} catch (Exception $th) {
			return Response::setup([
				'success' => false,
				'message' => 'something went wrong.' . $th->getMessage(),
			], StatusCode::ERROR_CODE);
		}
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
