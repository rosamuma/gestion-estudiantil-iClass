<x-guest-layout>

    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="position-absolute w-40 top-0 start-0 h-100 d-md-block d-none">
                                <div class="oblique-image position-absolute d-flex fixed-top ms-auto h-100 z-index-0 bg-cover me-n8"
                                    style="background-image:url('../assets/img/header-blue-purple.jpg')">
                                    <div class="my-auto text-center ms-7">
                                        <h1 class="mt-3 font-weight-bolder display-3 text-white">Bienvenido <br> estudiante.</h1>
                                        <p class="text-lg mt-4 mb-4 fs-2 text-white">Ingresa tus datos para crear una cuenta</p>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent">
                                    <h3 class="font-weight-black text-dark display-6 text-center">Inscribirse</h3>
                                    <p class="mb-0">Ingresa tus datos.</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="sign-up">
                                        @csrf
                                        <label>Nombre Completo</label>
                                        <div class="mb-3">
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="name" value="{{old("name")}}" aria-label="Name"
                                                aria-describedby="name-addon">
                                            @error('name')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <label>Email</label>
                                        <div class="mb-3">
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="email@email.com" value="{{old("email")}}" aria-label="Email"
                                                aria-describedby="email-addon">
                                            @error('email')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <label>Contraseña</label>
                                        <div class="mb-3">
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="password" aria-label="Password"
                                                aria-describedby="password-addon">
                                            @error('password')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-check form-check-info text-left mb-0">
                                            <input class="form-check-input" type="checkbox" name="terms"
                                                id="terms" required>
                                            <label class="font-weight-normal text-dark mb-0" for="terms">
                                                Acepto los <a href="javascript:;"
                                                    class="text-dark font-weight-bold">Terminos y Condiciones</a>.
                                            </label>
                                            @error('terms')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-dark w-100 mt-4 mb-3">Crear</button>
                                            <button type="button" class="btn btn-white btn-icon w-100 mb-3">
                                                <span class="btn-inner--icon me-1">
                                                    <img class="w-5" src="../assets/img/logos/google-logo.svg"
                                                        alt="google-logo" />
                                                </span>
                                                <span class="btn-inner--text">Crear con Google</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-xs mx-auto">
                                        Ya tienes cuenta?
                                        <a href="{{ route('sign-in') }}" class="text-dark font-weight-bold">Ingresa aquí</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</x-guest-layout>
