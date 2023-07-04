<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Categories extends Component
{

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $name, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorías';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {

            $categories = Category::where('name', 'LIKE', '%' . $this->search . '%')
                ->paginate($this->pagination);
        } else {
            $categories = Category::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.category.categories', compact('categories'))
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $category = Category::find($id, ['id', 'name', 'image']);
        $this->name = $category->name;
        $this->selected_id = $category->id;
        $this->image = null;

        $this->emit('show-modal', 'Editar contenido');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|unique:categories|min:3',
        ];

        $messages = [
            'name.required' => 'Nombre de la categoría es requerido',
            'name.unique' => 'La categoría ya existe',
            'name.min' => 'El nombre de la categoría debe ser mayor a 3 caracteres'
        ];

        $this->validate($rules, $messages);

        $category = Category::create([
            'name' => $this->name,
        ]);


        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories/', $customFileName);
            $category->image = $customFileName;
            $category->save();
        }

        $this->resetUI();
        $this->emit('category-added', 'Categoría Registrada');
    }

    public function update()
    {
        $rules = [
            'name' => "required|min:3|unique:categories,name,{$this->selected_id}"
        ];

        $messages = [
            'name.required' => 'Nombre de categoría requerido',
            'name.min' => 'El nombre de categoría debe ser mayor a 3 caracteres',
            'name.unique' => 'El nombre de categoría ya existe',
        ];

        $this->validate($rules, $messages);

        $category = Category::find($this->selected_id);

        $category->update([
            'name' => $this->name,
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories/', $customFileName);
            $imageName = $category->image;

            $category->image = $customFileName;
            $category->save();

            if ($imageName != null) {
                if (file_exists('storage/categories/' . $imageName)) {
                    unlink('storage/categories/' . $imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('category-updated', 'Categoría actualizada');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function destroy(Category $category)
    {
        $imageName = $category->image;
        $category->delete();

        if ($imageName != null) {
            unlink('storage/categories/' . $imageName);
        }

        $this->resetUI();
        $this->emit('category-deleted', "Categoría Eliminada");
    }
}
