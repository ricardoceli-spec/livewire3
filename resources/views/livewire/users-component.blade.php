<div wire:poll.5s class="container">
    <div class="row">
        <h1 class="text-center mt-4">{{$title}} ({{$usersCount}})</h1>
        <hr>

        @if (session('msg'))
        <div class="alert alert-success">{{session('msg')}}</div>
        @endif

        <div class="col-12 col-md-6">
            <h3>Listado de Usuarios</h3>
            <hr>

            @livewire('list-users',['lazy'=>true])

        </div>

        <div class="col-12 col-md-6">
            <h3>Crear Usuario</h3>
            <hr>
            <form wire:submit='createUser'>
                <div class="mb-3">
                    <input wire:model='name' class="form-control" type="text" placeholder="Nombre">
                    @error('name') <span style="color:red;">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <input wire:model='email' class="form-control" type="email" placeholder="Email">
                    @error('email') <span style="color:red;">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <input wire:model='password' class="form-control" type="password" placeholder="Contraseña">
                    @error('password') <span style="color:red;">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <input wire:model='image' type="file" accept="image/png, image/jpeg">
                    <div wire:loading wire:target='image' class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    @error('image') <p style="color:red;">{{$message}}</p> @enderror

                    <div class="mt-3 text-center">
                        @if ($image)
                            <img src="{{$image->temporaryUrl()}}" alt="Preview" width="400">
                        @endif
                    </div>
                </div>

                <button wire:loading.attr='disabled' wire:target='createUser' class="btn btn-primary">Crear Usuario</button>

                <div wire:loading wire:target='createUser' class="mt-3">
                    Enviando...
                </div>
            </form>
        </div>

    </div>
</div>