<?php

namespace App\Http\Livewire\Coin;

use App\Models\Denomination;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Coins extends Component
{

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $type, $value, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Denominaciones';
        $this->type = "Elegir";
    }

    public function render()
    {

        if (strlen($this->search) > 0) {

            $coins = Denomination::where('type', 'LIKE', '%' . $this->search . '%')
                ->paginate($this->pagination);
        } else {
            $coins = Denomination::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.coin.coins', compact('coins'))
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit(Denomination $denomination)
    {
        $this->type = $denomination->type;
        $this->value = $denomination->value;
        $this->selected_id = $denomination->id;
        $this->image = null;

        $this->emit('show-modal', 'Editar contenido');
    }

    public function store()
    {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => 'required|unique:denominations'
        ];

        $messages = [
            'type.required' => 'El tipo de moneda es requerido',
            'type.not_in' => 'Elige un tipo de moneda',
            'value.required' => 'El valor es requerido',
            'value.unique' => 'El valor ya existe'
        ];

        $this->validate($rules, $messages);

        $denomination = Denomination::create([
            'type' => $this->type,
            'value' => $this->value
        ]);


        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/denominations/', $customFileName);
            $denomination->image = $customFileName;
            $denomination->save();
        }

        $this->resetUI();
        $this->emit('item-added', 'Denominación Registrada');
    }

    public function update()
    {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => "required|unique:denominations,value,{$this->selected_id}"
        ];

        $messages = [
            'type.required' => 'El tipo de moneda es requerido',
            'type.not_in' => 'Elige un tipo de moneda',
            'value.required' => 'El valor es requerido',
            'value.unique' => 'El valor ya existe'
        ];

        $this->validate($rules, $messages);

        $denomination = Denomination::find($this->selected_id);

        $denomination->update([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/denominations/', $customFileName);
            $imageName = $denomination->image;

            $denomination->image = $customFileName;
            $denomination->save();

            if ($imageName != null) {
                if (file_exists('storage/denominations/' . $imageName)) {
                    unlink('storage/denominations/' . $imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('item-updated', 'Denominación actualizada');
    }

    public function resetUI()
    {
        $this->type = 'Elegir';
        $this->value = '';
        $this->search = "";
        $this->image = null;
        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();
    }

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function destroy(Denomination $denomination)
    {
        $imageName = $denomination->image;
        $denomination->delete();

        if ($imageName != null) {
            unlink('storage/denominations/' . $imageName);
        }

        $this->resetUI();
        $this->emit('item-deleted', "Denominación Eliminada");
    }
}
