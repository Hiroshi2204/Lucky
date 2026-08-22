<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Lucky - Seleccionar local</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center"
         style="min-height: 100vh;">

        <div class="col-md-6 col-lg-5">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <div class="text-center mb-4">

                        <h2 class="fw-bold">
                            Lucky
                        </h2>

                        <p class="text-muted mb-0">
                            Selecciona el local donde trabajarás
                        </p>

                    </div>

                    @if($errors->any())

                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>

                    @endif

                    <form
                        method="POST"
                        action="{{ route('local.guardar') }}"
                    >

                        @csrf

                        <div class="mb-4">

                            <label
                                for="local_id"
                                class="form-label fw-semibold"
                            >
                                Local
                            </label>

                            <select
                                name="local_id"
                                id="local_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Seleccione un local
                                </option>

                                @foreach($locales as $local)

                                    <option value="{{ $local->id }}">

                                        {{ $local->nombre }}

                                        @if($local->codigo)
                                            — {{ $local->codigo }}
                                        @endif

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Continuar
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>