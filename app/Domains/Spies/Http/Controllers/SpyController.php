<?php

namespace App\Domains\Spies\Http\Controllers;

use App\Domains\Spies\Commands\CreateSpyCommand;
use App\Domains\Spies\Http\Requests\GetApiSpyRequest;
use App\Domains\Spies\Http\Requests\StoreApiSpyRequest;
use App\Domains\Spies\Services\SpyService;
use App\Http\Controllers\Controller;
use Exception;

class SpyController extends Controller
{

    public function __construct(protected SpyService $spyService) {
    }

    public function get(GetApiSpyRequest $request) {
        $spies = $this->spyService->get();

        return response()->json([
            'message' => 'Random spies fetched successfully!',
            'spies' => $spies
        ], 200);
    }

    public function listSpies(GetApiSpyRequest $request) {

        $filters = $request->all();
        try{
            $spies = $this->spyService->paginated($filters);
            return response()->json([
                'message' => 'Random spies fetched successfully!',
                'spies' => $spies
            ]);
        }catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }

    }

    public function store(StoreApiSpyRequest $request)
    {
        $spyDTO = new CreateSpyCommand(
            $request->input('name'),
            $request->input('surname'),
            $request->input('agency'),
            $request->input('country_of_operation'),
            $request->input('birthday'),
            $request->input('deathday')
        );

        $spyDTO = $this->spyService->store($spyDTO);

        if(!$spyDTO){
            return response()->json([
                'error' => 'Ο κατάσκοπος δεν δημιουργήθηκε!',
            ], 400);
        }

        return response()->json([
            'success' => 'Ο κατάσκοπος δημιουργήθηκε με επιτυχία!',
            'name' => $spyDTO?->name,
            'surname' => $spyDTO?->surname,
        ], 200);

    }
}
