<?php

use App\Http\Controllers\OitmController;
use App\Http\Controllers\OCRDController;
use App\Http\Controllers\Frm010ConsultaArticulosController;
use App\Http\Controllers\Frm020ConsultaClientesController;
use App\Http\Controllers\Frm012Controller;
use App\Http\Controllers\Frm030Controller;
use App\Http\Controllers\CRD1Controller;
use App\Http\Controllers\OITWController;
use App\Http\Controllers\OITTController;
use App\Http\Controllers\ITT1Controller;
use Illuminate\Support\Facades\Route;

Route::post('/frm010consultaarticulos', [Frm010ConsultaArticulosController::class, 'consultar']);
Route::post('/frm020consultaclientes', [Frm020ConsultaClientesController::class, 'consultar']);
Route::get('/frm012fichaarticulo', [Frm012Controller::class, 'getByKey']);
Route::get('/frm030fichacliente', [Frm030Controller::class, 'getByKey']);

Route::get('/oitm', [OitmController::class, 'search']);
Route::get('/oitm/{itemCode}', [OitmController::class, 'getByKey']);
Route::post('/oitm', [OitmController::class, 'add']);
Route::put('/oitm/{itemCode}', [OitmController::class, 'update']);
Route::delete('/oitm/{itemCode}', [OitmController::class, 'delete']);
Route::patch('/oitm/{itemCode}', [OitmController::class, 'patch']);

Route::get('/ocrd/{cardCode}', [OCRDController::class, 'getByKey']);
Route::post('/ocrd', [OCRDController::class, 'add']);
Route::put('/ocrd/{cardCode}', [OCRDController::class, 'update']);
Route::delete('/ocrd/{cardCode}', [OCRDController::class, 'delete']);
Route::patch('/ocrd/{cardCode}', [OCRDController::class, 'patch']);

Route::get('/crd1/{cardCode}', [CRD1Controller::class, 'getAll']);
Route::get('/crd1/{cardCode}/{lineId}', [CRD1Controller::class, 'getByKey']);
Route::post('/crd1', [CRD1Controller::class, 'add']);
Route::put('/crd1/{cardCode}/{lineId}', [CRD1Controller::class, 'update']);
Route::delete('/crd1/{cardCode}/{lineId}', [CRD1Controller::class, 'delete']);

Route::get('/oitw/{itemCode}', [OITWController::class, 'getAll']);
Route::get('/oitw/{itemCode}/{whsCode}', [OITWController::class, 'getByKey']);
Route::post('/oitw', [OITWController::class, 'add']);
Route::put('/oitw/{itemCode}/{whsCode}', [OITWController::class, 'update']);
Route::delete('/oitw/{itemCode}/{whsCode}', [OITWController::class, 'delete']);

Route::get('/oitt/{code}', [OITTController::class, 'getByKey']);
Route::post('/oitt', [OITTController::class, 'add']);
Route::put('/oitt/{code}', [OITTController::class, 'update']);
Route::delete('/oitt/{code}', [OITTController::class, 'delete']);
Route::get('/oitt', [OITTController::class, 'getByItemCode']);

Route::get('/itt1/{code}/{lineId}', [ITT1Controller::class, 'getByKey']);
Route::post('/itt1', [ITT1Controller::class, 'add']);
Route::put('/itt1/{code}/{lineId}', [ITT1Controller::class, 'update']);
Route::delete('/itt1/{code}/{lineId}', [ITT1Controller::class, 'delete']);
Route::get('/itt1/search', [ITT1Controller::class, 'getByCode']);