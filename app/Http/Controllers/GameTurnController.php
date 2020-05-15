<?php

namespace App\Http\Controllers;

use App\Http\Requests\DrawRequest;
use App\Http\Requests\TurnRequest;
use App\Http\Resources\TurnResource;
use App\Http\Requests\SkipTurnRequest;
use App\Services\Game\CreateTurnService;
use App\Services\Game\DrawTileService;
use App\Services\Game\SkipTurnService;

class GameTurnController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TurnRequest $request, CreateTurnService $createTurnService, int $gameId)
    {
        $data = $createTurnService->setGameById($gameId)
        ->setUser($request->user())
        ->create($request->only(['side', 'tile_id']));

        return new TurnResource($data);
    }

    /**
     * Draws a card/tile
     *
     * @param DrawRequest $request
     * @param DrawTileService $drawTileService
     * @param int $game
     *
     * @return void
     */
    public function draw(
        DrawRequest $request,
        DrawTileService $drawTileService,
        int $game
    ) {
        $drawTileService->setGameById($game)
        ->setUser($request->user())
        ->draw();

        return \response()->json([
            'draw' => true
        ]);
    }

    /**
     * skips a turn
     *
     * @param SkipTurnRequest $request
     * @param SkipTurnService $skipTurnService
     * @param int $game
     *
     * @return void
     */
    public function skip(
        SkipTurnRequest $request,
        SkipTurnService $skipTurnService,
        int $game
    ) {
        $skipTurnService->setGameById($game)
        ->setUser($request->user())
        ->skip();


        return \response()->json([
            'skipped' => true
        ]);
    }
}
