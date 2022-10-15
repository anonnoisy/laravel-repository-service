<?php

namespace App\Services\API\V1\Candidate;

use App\Libraries\API\V1\Response\ErrorResponse;
use App\Libraries\API\V1\Response\Response;
use App\Libraries\API\V1\Response\StatusCode;
use App\Libraries\API\V1\Response\SuccessResponse;
use App\Repositories\API\V1\Candidate\CandidateRepoImpl;
use App\Services\API\V1\Candidate\Interfaces\CandidateServiceInterface;
use Exception;
use Illuminate\Http\Request;

class CandidateServiceImpl implements CandidateServiceInterface
{
  private CandidateRepoImpl $candidateRepository;

  public function __construct(CandidateRepoImpl $candidateRepository)
  {
    $this->candidateRepository = $candidateRepository;
  }


  public function index(Request $request): Response
  {
    $candidates = $this->candidateRepository->getCandidate($request);

    if ($candidates->count() < 1) {
      return ErrorResponse::setup([], StatusCode::NO_CONTENT);
    }

    return SuccessResponse::setup([
      'message' => 'successfully get candidate list',
      'data' => $candidates
    ], StatusCode::OK);
  }

  public function store(Request $request): Response
  {
    try {
      $candidate = $this->candidateRepository->storeCandidate($request);

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

  public function show(int $id): Response
  {
    $candidate = $this->candidateRepository->findCandidate($id);

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

  public function update(Request $request, int $id): Response
  {
    try {
      $candidate = $this->candidateRepository->updateCandidate($request, $id);

      return Response::setup([
        'success' => true,
        'message' => 'successfully updated candidate.',
        'data' => $candidate
      ], StatusCode::OK);
    } catch (Exception $e) {
      return Response::setup([
        'success' => false,
        'message' => 'something went wrong.',
      ], StatusCode::ERROR_CODE);
    }

    return Response::setup([
      'success' => false,
      'message' => 'candidate not found.'
    ], StatusCode::NOT_FOUND);
  }

  public function delete(int $id): Response
  {
    if ($this->candidateRepository->deleteCandidate($id)) {
      return Response::setup([], StatusCode::NO_CONTENT);
    }

    return Response::setup([
      'success' => false,
      'message' => 'candidate not found.'
    ], StatusCode::NOT_FOUND);
  }

  public function upload(Request $request): Response
  {
    try {
      $uploadedResume = $this->candidateRepository->uploadResumeCandidate($request);

      return Response::setup([
        'success' => true,
        'message' => 'successfully uploaded candidate resume file.',
        'data' => $uploadedResume
      ], StatusCode::CREATED);
    } catch (Exception $th) {
      return Response::setup([
        'success' => false,
        'message' => 'something went wrong.' . $th->getMessage(),
      ], StatusCode::ERROR_CODE);
    }
  }
}
