<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Candidate\StoreRequest as CandidateStoreRequest;
use App\Http\Requests\API\V1\Candidate\UpdateRequest as CandidateUpdateRequest;
use App\Repositories\API\V1\Candidate\CandidateRepoImpl;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    private $candidateRepo = NULL;

    public function __construct()
    {
        $this->candidateRepo = new CandidateRepoImpl();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $candidateList = $this->candidateRepo->getCandidate($request);
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
        $storedCandidate = $this->candidateRepo->storeCandidate($request);
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
        $candidate = $this->candidateRepo->findCandidate($id);
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
        $updatedCandidate = $this->candidateRepo->updateCandidate($request, $id);
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
        $deletedCandidate = $this->candidateRepo->deleteCandidate($id);
        return $deletedCandidate->json();
    }
}
