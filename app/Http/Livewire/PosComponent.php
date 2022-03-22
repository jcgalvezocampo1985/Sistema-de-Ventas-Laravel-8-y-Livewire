<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PosComponent extends Component
{
    public $total;
    public $itemsQuantity;
    public $efectivo;
    public $change;
    public $denomination;

    protected $listeners = [
        'scan-code' => 'ScanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale',
        'clearChangeCash' => 'clearChangeCash'
    ];

    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }

    public function render()
    {
        $denominations = Denomination::orderBy('value', 'DESC')->get();
        $cart = Cart::getContent()->sortBy('name');

        return view('livewire.pos.component', compact('denominations', 'cart'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function clearChangeCash()
    {
        $this->efectivo = 0;
        $this->change = 0;
    }

    public function updatedEfectivo($value)
    {
        $efectivoZero = ($value === '') ? 0 : $value;
        $this->change = $efectivoZero - $this->total;
    }

    public function ACash($value)
    {
        if($value > 0){
            $this->efectivo += ($value == 0 ? $this->total : $value);
            $this->change = $this->efectivo - $this->total;
        }

        if($value == 0){
            $this->change = 0;
            $this->efectivo = $this->total;
        }
    }

    public function ScanCode($barcode, $cant = 1)
    {
        $product = Product::where('barcode', $barcode)->first();

        if($product == null || empty($product))
        {
            $this->emit('scan-notfound', 'El producto no existe');
        }
        else
        {
            if($this->InCart($product->id))
            {
                $this->increaseQty($product->id);
                return;
            }

            if($product->stock < 1)
            {
                $this->emit('no-stock', 'Stock insuficiente :/');
                return;
            }

            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();

            $this->emit('scan-ok', 'Producto agregado');
        }
    }

    public function InCart($productId)
    {
        $exist = Cart::get($productId);

        return $exist ? true : false;
    }

    public function increaseQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);

        $title = ($exist) ? 'Cantidad actualizada' : 'Producto agregado';

        if($exist)
        {
            if($product->stock < ($cant + $exist->quantity))
            {
                $this->emit('no-stock', 'Stock insuficiente :/');
                return;
            }
        }

        Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', $title);
    }

    public function updateQty($productId, $cant = 1)
    {
        if($cant <= 0)
        {
            $this->removeItem($productId);
        }
        else
        {
            $title = '';
            $product = Product::find($productId);
            $exist = Cart::get($productId);
            $title = ($exist) ? 'Cantidad actualizada' : 'Producto agregado';

            if ($exist) {
                if ($product->stock < $cant) {
                    $this->emit('no-stock', 'Stock insuficiente :/');
                    return;
                }
            }

            $this->removeItem($productId);

            if ($cant > 0) {
                Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
                $this->total = Cart::getTotal();
                $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
            }
        }
    }

    public function removeItem($productId)
    {
        Cart::remove($productId);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');
    }

    public function decreaseQty($productId)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);

        $newQty = ($item->quantity) - 1;

        if($newQty > 0)
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Cantidad actualizada');
    }

    public function clearCart()
    {
        Cart::clear();

        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Carrito vacío');
    }

    public function saveSale()
    {
        if($this->total <= 0)
        {
            $this->emit('sale-error', 'Agrega productos a la venta');
            return;
        }

        if($this->efectivo <= 0)
        {
            $this->emit('sale-error', 'Ingresa el efectivo');
            return;
        }

        if($this->total > $this->efectivo)
        {
            $this->emit('sale-error', 'El efectivo debe ser mayor o igual al total');
            return;
        }

        //Iniciar la transacción
        DB::beginTransaction();

        try
        {
            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash' => $this->efectivo,
                'change' => $this->change,
                'user_id' => Auth()->user()->id
            ]);

            if($sale)
            {
                $items = Cart::getContent();

                foreach($items as $item)
                {
                    SaleDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id
                    ]);

                    //Update stock del producto
                    $product = Product::find($item->id);
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                }
            }
            //Confirmar la transacción
            DB::commit();

            Cart::clear();

            $this->efectivo = 0;
            $this->change = 0;
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('sale-ok', 'Venta registrada con éxito');
            $this->emit('print-ticket', $sale->id);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            $this->emit('sale-error', $e->getMessage());
        }
    }

    public function printTicket($sale)
    {
        return Redirect::to("print://$sale->id");
    }
}
