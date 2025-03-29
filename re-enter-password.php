<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Re-Enter Password</title>
    <link rel="shortcut icon" href="./resources/reso/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./css/style2.css">
    <script src="./js/script.js"></script>
</head>
<body>
    <div class="min-h-screen bg-gray-900 py-6 flex flex-col justify-center relative overflow-hidden sm:py-12">
        <div class="relative px-6 pt-10 pb-8 bg-white shadow-xl ring-1 ring-gray-900/5 sm:max-w-lg sm:mx-auto sm:rounded-lg sm:px-10">
            <div class="max-w-md mx-auto text-center">
                <img src="./resources/reso/logo.jpg" class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center " alt="School Logo" />
                <span class="text-xl ml-3">Re-Enter Password</span>
                <div id="alertBox" style="display: none;" class="flex items-center text-white text-sm font-bold px-4 py-3 rounded-md bg-red-500" role="alert"></div>                 
                <div class="mt-4 bg-white shadow-md rounded-lg">
                    <div class="h-2 bg-indigo-500 rounded-md"></div>
                    <div class="px-8 py-6">
                        <label for="" class="block font-semibold">Enter Code</label>
                        <input type="text" name="userid" id="uniqecode" placeholder="Enter Unique Id"
                            class="border w-full h-5 px-5 py-5 mt-2 hover:outline-none focus:ring-1 focus:ring-indigo-600 rounded-md">
                    </div>
                    <div class="px-8 py-6">
                        <label for="" class="block font-semibold">Email-id</label>
                        <input type="email" name="email" id="email" placeholder="Enter Email-id"
                            class="border w-full h-5 px-5 py-5 mt-2 hover:outline-none focus:ring-1 focus:ring-indigo-600 rounded-md">
                    </div>
                    <div class="px-8 py-6">
                        <label for="" class="block font-semibold">New Password</label>
                        <input type="password" name="newpwd" id="newpwd" placeholder="New Password"
                            class="border w-full h-5 px-5 py-5 mt-2 hover:outline-none focus:ring-1 focus:ring-indigo-600 rounded-md">
                    </div>
                    <div class="px-8 py-6">
                        <label for="" class="block font-semibold">Retype Password</label>
                        <input type="password" name="renewpwd" id="renewpwd" placeholder="Retype Password"
                            class="border w-full h-5 px-5 py-5 mt-2 hover:outline-none focus:ring-1 focus:ring-indigo-600 rounded-md">
                    </div>
                </div>
                <div class="flex justify-between items-baseline"><button type="submit" id="loginBtn" class="mt-4 bg-indigo-500 text-white py-2 px-6 rounded-md hover:bg-indigo-600">Re-Register</button></div>
                <div class="text-center"><a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800" href="./signup-page.html">Create an Account! </a></div><div class="text-center"><a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800" href="./login.html">Already have an account? Login! </a></div>
            </div>
        </div>
    </div>
</body>
</html>