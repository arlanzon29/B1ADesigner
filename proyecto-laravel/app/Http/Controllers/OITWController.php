<?php

namespace App\Http\Controllers;

use App\Interfaces\IOITWRepository;
use App\Models\OITW;
use Illuminate\Http\Request;

class OITWController extends Controller
{
    protected $repository;

    public function __construct(IOITWRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * GET /api/oitw/{itemCode}
     */
    public function getAll(string $itemCode)
    {
        return $this->repository->getAll($itemCode);
    }

    /**
     * GET /api/oitw/{itemCode}/{whsCode}
     */
    public function getByKey(string $itemCode, string $whsCode)
    {
        return $this->repository->getByKey($itemCode, $whsCode);
    }

    /**
     * POST /api/oitw
     */
    public function add(Request $request)
    {
        $elemento = new OITW();
        $elemento->ItemCode = $request->input('ItemCode');
        $elemento->WhsCode = $request->input('WhsCode');
        $elemento->OnHand = $request->input('OnHand', 0);

        return $this->repository->add($elemento);
    }

    /**
     * PUT /api/oitw/{itemCode}/{whsCode}
     */
    public function update(Request $request, string $itemCode, string $whsCode)
    {
        $elemento = OITW::where('ItemCode', $itemCode)
            ->where('WhsCode', $whsCode)
            ->first();
        if (!$elemento) {
            $elemento = new OITW();
            $elemento->ItemCode = $itemCode;
            $elemento->WhsCode = $whsCode;
        }
        $elemento->OnHand = $request->input('OnHand', 0);

        return $this->repository->update($elemento);
    }

    /**
     * DELETE /api/oitw/{itemCode}/{whsCode}
     */
    public function delete(string $itemCode, string $whsCode)
    {
        return $this->repository->delete($itemCode, $whsCode);
    }
}