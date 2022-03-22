<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;

class ReportsComponent extends Component
{
    public $componentName;
    public $data;
    public $details;
    public $sumDetails;
    public $countDetails;
    public $reportType;
    public $userId;
    public $dateFrom;
    public $dateTo;
    public $saleId;

    public function mount()
    {
        $this->componentName = 'Reporte de Ventas';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->userId = 0;
        $this->saleId = 0;
    }

    public function render()
    {
        $users = User::orderBy('name', 'ASC')->get();
        $this->SalesByDate();

        return view('livewire.reports.component', compact('users'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function SalesByDate()
    {
        if($this->reportType == 0)
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';
        }
        else
        {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d').' 23:59:59';
        }

        if($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == ''))
        {
            return;
        }

        if($this->userId == 0)
        {
            /*$this->data = Sale::join('users AS u', 'u.id', 'sales.user_id')
                              ->select('sales.*', 'u.name AS user')
                              ->whereBetween('sales.created_at', [$from, $to])
                              ->get();*/
            $this->data = Sale::with('user')
                              ->whereBetween('sales.created_at', [$from, $to])
                              ->get();
        }
        else
        {
            /*$this->data = Sale::join('users AS u', 'u.id', 'sales.user_id')
                              ->select('sales.*', 'u.name AS user')
                              ->whereBetween('sales.created_at', [$from, $to])
                              ->where('user_id', $this->userId)
                              ->get();*/
            $this->data = Sale::with('user')
                              ->whereBetween('sales.created_at', [$from, $to])
                              ->where('user_id', $this->userId)
                              ->get();
        }
    }

    public function getDetails($saleId)
    {
        /*$this->details = SaleDetail::join('products AS p', 'p.id', 'sale_details.product_id')
                                   ->select('sale_details.id', 'sale_details.price', 'sale_details.quantity', 'p.name AS product')
                                   ->where('sale_details.sale_id', $saleId)
                                   ->get();*/
        $this->details = SaleDetail::with('product')
                                   ->where('sale_details.sale_id', $saleId)
                                   ->get();

        $suma = $this->details->sum(function($item){
            return $item->price * $item->quantity;
        });

        $this->sumDetails = $suma;
        $this->countDetails = $this->details->sum('quantity');
        $this->saleId = $saleId;

        $this->emit('show-modal', 'Detalles cargados');
    }
}
