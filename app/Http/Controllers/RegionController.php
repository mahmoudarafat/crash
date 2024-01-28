<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Region;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Traits\RepositoryTrait;

class RegionController extends AppBaseController
{
    use RepositoryTrait;

    public $model;
    public function __construct(Region $model)
    {
        $this->model = $model;
    }

    /** with this one
     * Display a listing of the Region.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var Region $regions */
        $regions = Region::paginate(20);

        return view('regions.index')
            ->with('regions', $regions);
    }

    /**
     * Show the form for creating a new Region.
     *
     * @return Response
     */
    public function create()
    {
        return view('regions.create');
    }

    /**
     * Store a newly created Region in storage.
     *
     * @param CreateRegionRequest $request
     *
     * @return Response
     */
    public function store(CreateRegionRequest $request)
    {
        $input = $request->all();

        $newInput = $this->updatePasswords($input, 'create', $this->model);
        $newInput = $this->setFiles($newInput, $this->model);

        /** @var Region $region */
        $region = Region::create($newInput);

        Flash::success(__('messages.saved', ['model' => __('models/regions.singular')]));

        return redirect(route('regions.index'));
    }

    /**
     * Display the specified Region.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Region $region */
        $region = Region::find($id);

        if (empty($region)) {
            Flash::error(__('models/regions.singular').' '.__('messages.not_found'));

            return redirect(route('regions.index'));
        }

        return view('regions.show')->with('region', $region);
    }

    /**
     * Show the form for editing the specified Region.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Region $region */
        $region = Region::find($id);

        if (empty($region)) {
            Flash::error(__('messages.not_found', ['model' => __('models/regions.singular')]));

            return redirect(route('regions.index'));
        }

        return view('regions.edit')->with('region', $region);
    }

    /**
     * Update the specified Region in storage.
     *
     * @param int $id
     * @param UpdateRegionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRegionRequest $request)
    {
        /** @var Region $region */
        $region = Region::find($id);

        if (empty($region)) {
            Flash::error(__('messages.not_found', ['model' => __('models/regions.singular')]));

            return redirect(route('regions.index'));
        }

        $input = $request->all();

        $newInput = $this->updatePasswords($input, 'update', $ramadan);
        $newInput = $this->setFiles($newInput, $ramadan);
        $region->fill($newInput);

        $region->save();

        Flash::success(__('messages.updated', ['model' => __('models/regions.singular')]));

        return redirect(route('regions.index'));
    }

    /**
     * Remove the specified Region from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Region $region */
        $region = Region::find($id);

        if (empty($region)) {
            Flash::error(__('messages.not_found', ['model' => __('models/regions.singular')]));

            return redirect(route('regions.index'));
        }

        $region->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/regions.singular')]));

        return redirect(route('regions.index'));
    }
}
