<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Candidate\StoreRequest as CandidateStoreRequest;
use App\Http\Requests\API\V1\Candidate\UpdateRequest as CandidateUpdateRequest;
use App\Http\Requests\API\V1\Candidate\UploadRequest as CandidateUploadRequest;
use App\Repositories\API\V1\Candidate\CandidateRepoImpl;
use App\Services\API\V1\Candidate\CandidateServiceImpl;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    private CandidateServiceImpl $candidateService;

    public function __construct()
    {
        $this->candidateService = new CandidateServiceImpl(new CandidateRepoImpl());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $candidateList = $this->candidateService->index($request);
        return $candidateList->json();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CandidateStoreRequest $request)
    {
        $storedCandidate = $this->candidateService->store($request);
        return $storedCandidate->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $candidate = $this->candidateService->show($id);
        return $candidate->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CandidateUpdateRequest $request, $id)
    {
        $updatedCandidate = $this->candidateService->update($request, $id);
        return $updatedCandidate->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $deletedCandidate = $this->candidateService->delete($id);
        return $deletedCandidate->json();
    }

    /**
     * Upload candidate resume file to storage.
     *
     * @param  CandidateUploadRequest $request
     * @return \Illuminate\Http\Response
     */
    public function upload(CandidateUploadRequest $request)
    {
        $deletedCandidate = $this->candidateService->upload($request);
        return $deletedCandidate->json();
    }

    /**
     * View uploaded candidate resume
     *
     * @param string $file
     * @return void
     */
    public function viewUploadedResume($file)
    {
        $path = storage_path("app/files/resumes/$file");
        if (file_exists($path)) {
            return response()->file($path, array('Content-Type' => 'application/pdf'));
        }

        abort(404);
    }
}
