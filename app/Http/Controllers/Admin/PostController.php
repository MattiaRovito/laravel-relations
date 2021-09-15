<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Usare il Model
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        // chi deve visualizzare i prodotti?

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // validazione dei dati
        $request->validate([
            'title' => 'required|max:60',
            'content' => 'required'
        ]);


        // prendere i dati
        $data = $request->all();


        // creare la nuova istanza con i dati ottenuti dalla request
        $new_post = new Post();

        $slug = Str::slug($data['title'], '-'); 



        // se c'è un duplicato

        $slug_base = $slug;

        $slug_presente =  Post::where('slug', $slug)->first();

        $contatore = 1;

        while($slug_presente){
            $slug = $slug_base . '-' . $contatore;

            $slug_presente =  Post::where('slug', $slug)->first();

            $contatore++;
        }

        // end se c'è un duplicato



        $new_post->slug = $slug;
        
        
        $new_post->fill($data);



        // salvare i dati
        $new_post->save();

        return redirect()->route('admin.posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    //! Collegamento show con slug (utilizzato nel front-office)
    //* al posto di $slug si può passare qualsiasi cosa, è sempre un segnaposto
    public function show($slug)
    {

        //* vado a selezionare il primo elemento
        $post = Post::where('slug', $slug)->first();

        return view('admin.posts.show', compact('post'));
    }


    //! Collegamento show con id
    // public function show(Post $post)
    // {
    //     return view('admin.posts.show', compact('post'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Post $post)
    {


        // validazione dei dati
        $request->validate([
            'title' => 'required|max:60',
            'content' => 'required'
        ]);




        // prendere tutti i dati
        $data = $request->all();


        // Se è stato modificato aggiungi questo. Permette di aggiungere un -numero se è già esistente il titolo modificato. 
        if($data['title'] != $post->title){

            $slug = Str::slug($data['title'], '-'); 

            $slug_base = $slug;

            $slug_presente = Post::where('slug',  $slug)->first();

            $contatore = 1;
            while($slug_presente){
                // aggiungiamo al post di prima un -contatore
                $slug = $slug_base . '-' . $contatore;
                // se lo slug è uguale ad uno già presente allora segue il procedimento sotto

                // controlliamo nuovamente se il post esiste ancora
                $slug_presente = Post::where('slug',  $slug)->first();

                // incrementiamo il contatore
                $contatore++;
            }

            // in ogni caso, sia se è entrato nel ciclo sia no, farà questo

            $data['slug'] = $slug;
        }   


        
        // vado a modificarli
        $post->update($data);

        // fare il return
        return redirect()->route('admin.posts.index')->with('updated', 'Il post numero ' . $post->id . ' è stato modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
            $post->delete();

            return redirect()->route('admin.posts.index')->with('deleted', 'Il post numero ' . $post->id . ' è stato eliminato con successo');
    }
}
