<?php

namespace App\Http\Controllers;

use App\Interfaces\IOitmRepository;
use App\Models\OITM;
use Illuminate\Http\Request;

class OitmController extends Controller
{
    protected $repository;

    public function __construct(IOitmRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * GET /api/oitm
     */
    public function search(Request $request)
    {
        $itemCode = $request->query('ItemCode');
        return $this->repository->search($itemCode);
    }

    /**
     * GET /api/oitm/{itemCode}
     */
    public function getByKey(string $itemCode)
    {
        return $this->repository->getByKey($itemCode);
    }

    /**
     * POST /api/oitm
     */
    public function add(Request $request)
    {
        $elemento = new Oitm();
        $elemento->ItemCode = $request->input('ItemCode');
        $elemento->ItemName = $request->input('ItemName');
        $elemento->OnHand = $request->input('OnHand', 0);

        return $this->repository->add($elemento);
    }

    /**
     * PUT /api/oitm/{itemCode}
     */
    public function update(Request $request, string $itemCode)
    {
        $elemento = OITM::find($itemCode);
        if (!$elemento) {
            $elemento = new Oitm();
            $elemento->ItemCode = $itemCode;
        }
        $elemento->ItemName = $request->input('ItemName');
        $elemento->OnHand = $request->input('OnHand', 0);

        return $this->repository->update($elemento);
    }

    /**
     * DELETE /api/oitm/{itemCode}
     */
    public function delete(string $itemCode)
    {
        return $this->repository->delete($itemCode);
    }

    /**
     * PATCH /api/oitm/{itemCode}
     */
    public function patch(Request $request, string $itemCode)
    {
        return $this->repository->patch($request, $itemCode);
    }
}