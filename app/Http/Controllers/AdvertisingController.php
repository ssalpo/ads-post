<?php

namespace App\Http\Controllers;

use App\Advertising;
use App\Http\Requests\AdvertisingRequest;
use App\Http\Resources\AdvertisingResource;

class AdvertisingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return AdvertisingResource::collection(
            Advertising::with('images')
                ->sortByFields(request('sort', []))
                ->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdvertisingRequest $request)
    {
        try {
            $advertising = Advertising::create($request->validated());

            return response()->json(['status' => true, 'data' => ['id' => $advertising->id]]);
        } catch (\Exception $exception) {
            return response()->json(['status' => false], $exception->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Advertising $advertising
     * @return AdvertisingResource
     */
    public function show(Advertising $advertising)
    {
        return new AdvertisingResource($advertising);
    }
}
