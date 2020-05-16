<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Http\Resources\GameResource;
use App\Repositories\GameRepository;
use App\Services\Game\StartGameService;
use App\Http\Resources\GameCollectionResource;

class GameController extends Controller
{
    /**
     * GameRepository
     *
     * @var GameRepository
     */
    protected $repository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->repository = $gameRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GameCollectionResource::collection($this->repository->getListForUser(auth()->user()->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GameRequest $request, StartGameService $startGameService)
    {
        $game = $this->repository->create([
            'owner_id' => $request->user()->id
        ]);

        /**
         * The creator of the game will always be a player and make sure that all ids are unique
         */
        $users = collect($request->players)->push($request->user()->id)->unique()->toArray();
        
        $game->addPlayers($users);

        $startGameService->setGame($game)->start();

        $game->fresh();
        
        $game->loadCount(['players','turns', 'pool']);

        $game->load(['players', 'turns']);

        return new GameResource($game);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = $this->repository->find($id);

        $game->loadCount(['players','turns', 'pool']);

        $game->load(['players', 'turns',]);

        return new GameResource($game);
    }
}
