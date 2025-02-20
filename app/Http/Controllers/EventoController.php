<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->query->count() === 0) {
            $eventos = Evento::all();
        } else {
            $eventos = Evento::query();
            $perPage = $request->query('perPage');
            $orderBy = $request->query('orderBy');

            // GROUPING
            if(isset($orderBy)) {
                $eventos = $eventos->ordered($orderBy);
            }

            if(isset($perPage)) {
                $eventos = $eventos->paginate($perPage)->withQueryString();
            } else {
                $eventos = $eventos->get();
            }
        }

        return response()->json($eventos);
    }

    /**
     * Display the specified resource.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evento = Evento::findOrFail($id);
        return response()->json($evento);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'date' => 'required',
            'name' => 'required|string',
            'owner' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string|max:2',
            'address' => 'required|string',
            'number' => 'required|numeric',
            'phone' => 'required|string|max:20'
        ];
        $validator = $this->getValidator($request, $rules);
        if($validator->stopOnFirstFailure()->fails()) {
            return response()->json(['msg' => $validator->errors()->first()], 400);
        }

        $evento = Evento::create($request);

        //Store image if available
        $image = $request->file('image');
        if(isset($image)) {
            $imgResponse = $this->storeImage($request);

            if($imgResponse[0] === 1) {
                $evento->image_path = $imgResponse[1];
            } else {
                return response()->json(['msg' => $imgResponse[1]], 400);
            }
        }

        return response()->json(['msg' => 'Evento cadastrado com sucesso!']);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'date' => 'required',
            'name' => 'required|string',
            'owner' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string|max:2',
            'address' => 'required|string',
            'number' => 'required|numeric',
            'phone' => 'required|string|max:20'
        ];

        $evento = Evento::findOrFail($id);

        $validator = $this->getValidator($request, $rules);
        if($validator->stopOnFirstFailure()->fails()) {
            return response()->json(['msg' => $validator->errors()->first()], 400);
        }

        $evento->date = $request->date;
        $evento->name = $request->name;
        $evento->owner = $request->owner;
        $evento->city = $request->city;
        $evento->state = $request->state;
        $evento->address = $request->address;
        $evento->number = $request->number;
        $evento->phone = $request->phone;

        //Store image if available
        $image = $request->file('image');
        if(isset($image)) {
            $imgResponse = $this->storeImage($request);

            if($imgResponse[0] === 1) {
                $evento->image_path = $imgResponse[1];
            } else {
                return response()->json(['msg' => $imgResponse[1]], 400);
            }
        }

        $product->save();
        return response()->json(['msg' => 'Evento editado com sucesso!']);
    }

    /**
     * Store an image in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return Array
     */
    public function storeImage(Request $request)
    {
        $image = $request->file('image');

        $validator = $this->getValidator($request, $rules);
        if($validator->stopOnFirstFailure()->fails()) {
            return [0, $validator->errors()->first()];
        }

        $imagePath = $img->store('images', 'public');
        return [1, $imagePath];
    }

    /**
     * Remove an image from storage.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyImage($id)
    {
        $evento = Evento::findOrFail($id);
        Storage::delete('public/' . $evento->image_path);
        $evento->image_path = null;
        $evento->save();

        return response()->json(['msg' => 'Imagem deletada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);
        if(isset($evento->image_path)) {
            Storage::delete('public/' . $evento->image_path);
        }
        $evento->delete();

        return response()->json(['msg' => 'Evento deletado com sucesso!']);
    }

    /**
     * Remove the specified resources from storage.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function massDestroy(Request $request)
    {
        foreach($request->ids as $id) {
            $this->destroy($id);
        }

        return response()->json(['msg' => 'Eventos deletados com sucesso!']);
    }

    /**
     * Validate the inputs for the specified resource.
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  array $rules
     * @return \Illuminate\Support\Facades\Validator
     */
    private function getValidator(Request $request, array $rules)
    {
        $messages = [
            'date' => [
                'required' => 'A data/hora do evento é obrigatória.',
            ],
            'name' => [
                'required' => 'O nome é obrigatório.',
                'string' => 'O nome deve ser um texto.',
            ],
            'owner' => [
                'required' => 'O nome do responsável é obrigatório.',
                'string' => 'O nome do responsável deve ser um texto.',
            ],
            'city' => [
                'required' => 'A cidade é obrigatória.',
                'string' => 'O nome da cidade deve ser um texto.',
            ],
            'state' => [
                'required' => 'O estado é obrigatória.',
                'string' => 'O estado deve ser um texto.',
                'max' => 'O estado deve ter no máximo :max caracteres.'
            ],
            'address' => [
                'required' => 'O endereço é obrigatório.',
                'string' => 'O endereço deve ser um texto.',
            ],
            'number' => [
                'required' => 'O número é obrigatório.',
                'numeric' => 'O número deve ser um número.',
            ],
            'phone' => [
                'required' => 'O telefone é obrigatório.',
                'max' => 'O telefone deve ter no máximo :max caracteres.'
            ]
        ];
        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Validate the inputs for images.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Facades\Validator
     */
    private function getImageValidator(Request $request)
    {
        $rules = [
            'images.*' => 'file|mimes:jpg,jpeg,png,webp|max:2048',
        ];
        $messages = [
            'file' => 'O conteúdo enviado não é uma imagem válida.',
            'mimes' => 'Somente os tipos de arquivo listados são aceitos.',
            'max' => 'O tamanho máximo suportado é de :max KB.',
        ];
        return Validator::make($request->all(), $rules, $messages);
    }
}
