<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>

<head>
	<title>Iniciar Sesión</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
	<style>
		body {
			background: url(https://www.construcsurperu.com/wp-content/uploads/2022/07/calaminas-03.jpg);
			font-family: 'PT Sans', Helvetica, Arial, sans-serif;
			color: #fff;
			background-repeat: no-repeat;
			background-size: cover;
		}

		html {
			margin: 0;
			padding: 0;
			height: 100%;
			background: #04F982 !important;
		}

		button {
			cursor: pointer;
			width: 300px;
			height: 44px;
			margin-top: 25px;
			padding: 0;
			background: #ef4300;
			-moz-border-radius: 6px;
			-webkit-border-radius: 6px;
			border-radius: 6px;
			border: 1px solid #ff730e;
			-moz-box-shadow:
				0 15px 30px 0 rgba(255, 255, 255, .25) inset,
				0 2px 7px 0 rgba(0, 0, 0, .2);
			-webkit-box-shadow:
				0 15px 30px 0 rgba(255, 255, 255, .25) inset,
				0 2px 7px 0 rgba(0, 0, 0, .2);
			box-shadow:
				0 15px 30px 0 rgba(255, 255, 255, .25) inset,
				0 2px 7px 0 rgba(0, 0, 0, .2);
			font-family: 'PT Sans', Helvetica, Arial, sans-serif;
			font-size: 14px;
			font-weight: 700;
			color: #fff;
			text-shadow: 0 1px 2px rgba(0, 0, 0, .1);
			-o-transition: all .2s;
			-moz-transition: all .2s;
			-webkit-transition: all .2s;
			-ms-transition: all .2s;
		}

		.img {
			height: 140px;
			width: 140px;
		}

		.user_card {
			height: 450px;
			width: 390px;
			margin-top: auto;
			margin-bottom: auto;
			background: #FFBD00;
			position: relative;
			display: flex;
			justify-content: center;
			flex-direction: column;
			padding: 15px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			-webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			-moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			border-radius: 5px;

		}

		.brand_logo_container {
			position: absolute;
			height: 170px;
			width: 170px;
			top: -75px;
			border-radius: 50%;
			background: #FFF;
			padding: 10px;
			text-align: center;
		}

		.brand_logo {
			height: 150px;
			width: 150px;
			border-radius: 50%;
			border: 2px solid white;
		}

		.form_container {
			margin-top: 100px;
		}

		.login_btn {
			width: 100%;
			background: #c0392b !important;
			color: white !important;
		}

		.login_btn:focus {
			box-shadow: none !important;
			outline: 0px !important;
		}

		.login_container {
			padding: 0 2rem;
		}

		.input-group-text {
			background: #c0392b !important;
			color: white !important;
			border: 0 !important;
			border-radius: 0.25rem 0 0 0.25rem !important;
		}

		.input_user,
		.input_pass:focus {
			box-shadow: none !important;
			outline: 0px !important;
		}

		.custom-checkbox .custom-control-input:checked~.custom-control-label::before {
			background-color: #FB825C !important;
		}

		.tituloo {
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="https://i1.wp.com/seindelperu.com/wp-content/uploads/2019/01/logo_seindel.png?fit=336%2C336&ssl=1" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form action="{{route('login')}}" method="POST">
						@csrf
						<br>
						<h5 class="tituloo" style="color: black;">EMPRESA PERU</h5>
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="username" class="form-control input_user" id="username" placeholder="usuario">
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password" class="form-control input_pass" id="password" placeholder="contraseña">
						</div>
						<!-- <div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="customControlInline">
								<label class="custom-control-label" for="customControlInline" style="color: black;">Recordar</label>
							</div>
						</div> -->
						<div class="d-flex justify-content-center mt-3 login_container">
							<button type="submit" class="btn login_btn" onclick="submitForm()">Entrar</button>
						</div>
					</form>
					<script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script>
					<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
					<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
					<script>
						function submitForm() {
							document.getElementById('loginForm').action = "{{ route('mostrar_menu', ['id']) }}";
							document.getElementById('loginForm').submit();
						}
					</script>
				</div>

				<div class="mt-4">
					<div class="d-flex justify-content-center links" style="color: black;">
						¿No tienes una cuenta? <a href="{{route('usuario')}}" class="ml-2">Registrate</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>