<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Sale;
use App\Models\SaleDetail;
use carbon\Carbon;

class CashoutComponent extends Component
{
    public $fromDate;
    public $toDate;
    public $userid;
    public $total;
    public $items;
    public $sales;
    public $details;

    public function mount()
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->userid = 0;
        $this->total = 0;
        $this->sales = [];
        $this->details = [];
    }

    public function render()
    {
        $users = User::orderBy('name', 'ASC')->get();

        return view('livewire.cashout.component', compact('users'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function Consultar()
    {
        $fecha_inicial = Carbon::parse($this->fromDate)->format('Y-m-d').' 00:00:00';
        $fecha_final = Carbon::parse($this->toDate)->format('Y-m-d').' 23:59:59';

        $this->sales = Sale::whereBetween('created_at', [$fecha_inicial, $fecha_final])
                            ->where([
                                ['status', '=', 'PAID'],
                                ['user_id', '=', $this->userid]
                            ])
                            ->get();

        $this->total = $this->sales ? $this->sales->sum('total') : 0;
        $this->items = $this->sales ? $this->sales->sum('items') : 0;
    }

    public function viewDetails(Sale $sale)
    {
        $fecha_inicial = Carbon::parse($this->fromDate)->format('Y-m-d').' 00:00:00';
        $fecha_final = Carbon::parse($this->toDate)->format('Y-m-d').' 23:59:59';

        /*$this->details = Sale::join('sale_details AS d', 'd.sale_id', 'sales.id')
                             ->join('products AS p', 'p.id', 'd.product_id')
                             ->select('d.sale_id', 'p.name AS product', 'd.quantity', 'd.price')
                             ->whereBetween('sales.created_at', [$fecha_inicial, $fecha_final])
                             ->where([
                                 ['sales.status', '=', 'PAID'],
                                 ['sales.user_id', '=', $this->userid],
                                 ['sales.id', '=', $sale->id]
                             ])
                             ->get();*/

        $this->details = SaleDetail::whereHas('sale', function($q) use ($sale, $fecha_inicial, $fecha_final){
                                        return $q->where([
                                                    ['sales.status', '=', 'PAID'],
                                                    ['sales.user_id', '=', $this->userid],
                                                    ['sales.id', '=', $sale->id]
                                                ])
                                                ->whereBetween('sales.created_at', [$fecha_inicial, $fecha_final]);
                                    })
                                    ->with('product')
                                    ->get();

        $this->emit('show-modal', 'Open modal');
    }

    public function print()
    {

    }
}
