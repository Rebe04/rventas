<?php

namespace App\Http\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Products extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $name, $barcode, $cost, $price, $stock, $alerts, $categoryid, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    protected $paginationTheme = "bootstrap";

    public function mount()
    {
        $this->pageTitle = "Listado";
        $this->componentName = "Products";
        $this->categoryid = "Elegir";
    }

    public function render()
    {
        if (strlen($this->search)) {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->where('products.name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('products.barcode', 'LIKE', '%' . $this->search . '%')
                ->orWhere('c.name', 'LIKE', '%' . $this->search . '%')
                ->orderBy('products.name', 'asc')
                ->paginate($this->pagination);
        } else {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->orderBy('products.name', 'asc')
                ->paginate($this->pagination);
        }

        $categories = Category::orderBy('name', 'asc')->get();
        return view('livewire.product.products', compact('products', 'categories'))->extends('layouts.theme.app')->section('content');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function store()
    {
        $rules = [
            'name' => 'required|unique:products|min:3',
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'categoryid' => 'required|not_in:Elegir'
        ];

        $messages = [
            'name.required' => 'Nombre del producto requerido',
            'name.unique' => 'Ya existe un producto con este nombre',
            'name.min' => 'El nombre del producto debe ser mayor a 3 caracteres',
            'cost.required' => 'El costo es requerido',
            'price.required' => 'El precio es requerido',
            'stock.required' => 'El stock es requerido',
            'alerts.required' => 'Ingresa el valor mínimo de existencias',
            'categoryid.not_in' => 'Seleccione una categoría de producto'
        ];

        $this->validate($rules, $messages);

        $product = Product::create([
            'name' => $this->name,
            'cost' => $this->cleanValue($this->cost),
            'price' => $this->cleanValue($this->price),
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->categoryid
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products/', $customFileName);
            $product->image = $customFileName;
            $product->save();
        }

        $this->resetUI();
        $this->emit('product-added', 'Producto registrado');
    }

    public function edit(Product $product)
    {
        $this->selected_id = $product->id;
        $this->name = $product->name;
        $this->barcode = $product->barcode;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->alerts = $product->alerts;
        $this->categoryid = $product->category_id;
        $this->image = null;

        $this->emit('show-modal', 'Editar producto');
    }

    public function cleanValue($value)
    {
        return  number_format(str_replace(",", "", $value), 2, '.', '');
    }

    public function update()
    {
        $rules = [
            'name' => "required|min:3|unique:products,name,{$this->selected_id}",
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'categoryid' => 'required|not_in:Elegir'
        ];

        $messages = [
            'name.required' => 'Nombre del producto requerido',
            'name.unique' => 'Ya existe un producto con este nombre',
            'name.min' => 'El nombre del producto debe ser mayor a 3 caracteres',
            'cost.required' => 'El costo es requerido',
            'price.required' => 'El precio es requerido',
            'stock.required' => 'El stock es requerido',
            'alerts.required' => 'Ingresa el valor mínimo de existencias',
            'categoryid.not_in' => 'Seleccione una categoría de producto'
        ];

        $this->validate($rules, $messages);

        $product = Product::find($this->selected_id);

        $product->update([
            'name' => $this->name,
            'cost' => $this->cleanValue($this->cost),
            'price' => $this->cleanValue($this->price),
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->categoryid
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products/', $customFileName);
            $imageTemp = $product->image;
            $product->image = $customFileName;
            $product->save();

            if ($imageTemp != null) {
                if (file_exists('storage/products/' . $imageTemp)) {
                    unlink('storage/products/' . $imageTemp);
                }
            }
        }

        $this->resetUI();
        $this->emit('product-updated', 'Producto actualizado');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->barcode = '';
        $this->cost = '';
        $this->price = '';
        $this->stock = '';
        $this->alerts = '';
        $this->search = '';
        $this->categoryid = 'Elegir';
        $this->image = null;
        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();
    }

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function destroy(Product $product)
    {
        $imageTemp = $product->image;
        $product->delete();

        if ($imageTemp != null) {
            if (file_exists('storage/products/' . $imageTemp)) {
                unlink('storage/products/' . $imageTemp);
            }
        }

        $this->resetUI();
        $this->emit('product-deleted', 'Producto eliminado');
    }
}
