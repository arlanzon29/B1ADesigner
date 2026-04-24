<?php

namespace App\Http\Controllers;

use App\Interfaces\ICRD1Repository;
use App\Models\CRD1;
use Illuminate\Http\Request;

class CRD1Controller extends Controller
{
    protected $repository;

    public function __construct(ICRD1Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * GET /api/crd1/{cardCode}
     */
    public function getAll(string $cardCode)
    {
        return $this->repository->getAll($cardCode);
    }

    /**
     * GET /api/crd1/{cardCode}/{lineId}
     */
    public function getByKey(string $cardCode, int $lineId)
    {
        return $this->repository->getByKey($cardCode, $lineId);
    }

    /**
     * POST /api/crd1
     */
    public function add(Request $request)
    {
        $elemento = new CRD1();
        $elemento->CardCode = $request->input('CardCode');
        $elemento->LineId = $request->input('LineId');
        $elemento->Address = $request->input('Address');

        return $this->repository->add($elemento);
    }

    /**
     * PUT /api/crd1/{cardCode}/{lineId}
     */
    public function update(Request $request, string $cardCode, int $lineId)
    {
        $elemento = CRD1::where('CardCode', $cardCode)
            ->where('LineId', $lineId)
            ->first();
        if (!$elemento) {
            $elemento = new CRD1();
            $elemento->CardCode = $cardCode;
            $elemento->LineId = $lineId;
        }
        $elemento->Address = $request->input('Address');

        return $this->repository->update($elemento);
    }

    /**
     * DELETE /api/crd1/{cardCode}/{lineId}
     */
    public function delete(string $cardCode, int $lineId)
    {
        return $this->repository->delete($cardCode, $lineId);
    }
}