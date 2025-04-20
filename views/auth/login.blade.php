<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login Form with Bank Images</title>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <!-- Login Form with Bank Images -->
    <div class="flex flex-col items-center justify-center py-12">
        <div class="flex flex-col lg:flex-row gap-8 w-full max-w-6xl mx-auto">
            <!-- Left Image -->
            <div class="w-1/3 hidden lg:block">
                <img src="https://images.unsplash.com/photo-1583508915901-b5f84c1dcde1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Bank Image Left"
                    class="w-full h-full object-cover rounded-lg shadow-lg">
            </div>

            <!-- Center Form -->
            <div class="lg:w-1/3 w-full bg-white p-8 rounded-lg shadow-lg">
                <form action="{{ route('login-proses') }}" method="post" class="flex flex-col gap-6">
                    @csrf
                    <div class="flex flex-col">
                        <label class="mb-2 font-medium" for="email">Email</label>
                        <input type="email" id="email"
                            class="border rounded-md border-gray-400 hover:border-black focus:border-black p-2"
                            name="email" placeholder="Enter your email" required />
                    </div>

                    <div class="flex flex-col">
                        <label class="mb-2 font-medium" for="password">Password</label>
                        <div class="relative">
                            <input type="password" id="password"
                                class="border rounded-md border-gray-400 hover:border-black focus:border-black p-2 w-full"
                                name="password" placeholder="Enter your password" required />
                            <i class="material-icons absolute top-1/2 right-3 transform -translate-y-1/2 text-gray-500"
                                style="font-size: 16px">visibility</i>
                        </div>
                    </div>

                    <button type="submit"
                        class="text-center text-white p-2 bg-blue-700 rounded-md hover:bg-blue-800 transition duration-300">
                        Login
                    </button>
                </form>
                <div class="mt-6 text-center">
                    <p>or</p>
                    <a href="#"
                        class="inline-block mt-4 border rounded border-gray-400 hover:border-black focus:border-black p-2 w-full text-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png"
                            alt="Google" class="inline mr-2" width="18px" /> Sign-in with Google
                    </a>
                </div>
                <div class="mt-6 text-center">
                    <p>Don't have an account? <a href="#" class="text-blue-700 hover:underline">Register here</a></p>
                </div>
            </div>

            <!-- Right Image -->
            <div class="w-1/3 hidden lg:block">
                <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Bank Image Right"
                    class="w-full h-full object-cover rounded-lg shadow-lg">
            </div>
        </div>
    </div>
</body>

</html>