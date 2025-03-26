<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #cce7ff, #ffffff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }

        .login-container h2 {
            margin-bottom: 10px;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-btn {
            margin: auto;
            width: 100%;
            padding: 10px;
            background: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }

        .social-login img {
            width: 30px;
            height: 30px;
            cursor: pointer;
        }
        .alert{
            color: red;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Sign in with email</h2>
        <!-- <p>Make a new doc to bring your words, data, and teams together. For free.</p> -->

        <form action="{{ route('auth.login') }}" method="post" enctype="multipart/form-data">
            @csrf

            @if ($errors->has('login'))
            <div class="alert alert-danger">
                {{ $errors->first('login') }}
            </div>
            @endif

            <!-- Display validation errors for email -->
            @if ($errors->has('email'))
            <div class="alert alert-danger">
                {{ $errors->first('email') }}
            </div>
            @endif
            <input type="email"
                name="email"
                class="input-field"
                placeholder="Email"
                value="{{ old('email') }}"
                required>

            <!-- Display validation errors for password -->
            @if ($errors->has('password'))
            <div class="alert alert-danger">
                {{ $errors->first('password') }}
            </div>
            @endif
            <input type="password"
                name="password"
                class="input-field"
                placeholder="Password"
                required>

            <button class="login-btn" type="submit">Get Started</button>
        </form>

        <!-- <p>Or sign in with</p>
        <div class="social-login">
            <img src="google-icon.png" alt="Google">
            <img src="facebook-icon.png" alt="Facebook">
            <img src="apple-icon.png" alt="Apple">
        </div> -->
    </div>
</body>

</html>