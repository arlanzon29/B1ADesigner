<?php

namespace App\Http\Controllers;

use App\Interfaces\IOSHPRepository;
use App\Models\OSHP;
use Illuminate\Http\Request;

class OSHPController extends Controller
{
    protected $repository;

    public function __construct(IOSHPRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * GET /api/oshp/{code}
     */
    public function getByKey(string $code)
    {
        return $this->repository->getByKey($code);
    }

    /**
     * POST /api/oshp
     */
    public function add(Request $request)
    {
        $elemento = new OSHP();
        $elemento->Code = $request->input('Code');
        $elemento->Name = $request->input('Name');

        return $this->repository->add($elemento);
    }

    /**
     * PUT /api/oshp/{code}
     */
    public function update(Request $request, string $code)
    {
        $elemento = OSHP::find($code);
        if (!$elemento) {
            $elemento = new OSHP();
            $elemento->Code = $code;
        }
        $elemento->Name = $request->input('Name');

        return $this->repository->update($elemento);
    }

    /**
     * DELETE /api/oshp/{code}
     */
    public function delete(string $code)
    {
        return $this->repository->delete($code);
    }
}