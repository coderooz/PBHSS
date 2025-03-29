<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downloads</title>
    <link rel="shortcut icon" href="./resources/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./css/style2.css">
    <script src="./js/script.js"></script>
</head>

<body>
    <header class="text-gray-400 bg-gray-900 body-font">
        <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center"><a
                class="flex title-font font-medium items-center text-white mb-4 md:mb-0"><img alt="testimonial"
                    src="./resources/images/logo.jpg"
                    class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center"><span
                    class="ml-3 text-xl">Pachim Barnagar High School</span></a>
            <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center"><a
                    class="mr-5 hover:text-white" href="./index.html">Home</a><a class="mr-5 hover:text-white"
                    href="#">Features</a><a class="mr-5 hover:text-white" href="./school-gallery.html">Gallery</a><a
                    class="mr-5 hover:text-white" href="#others">Others</a></nav><button
                class="inline-flex items-center bg-gray-800 border-0 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base mt-4 md:mt-0"
                onclick="location.href='./signup-page.html'">Sign Up<svg fill="none" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1"
                    viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg></button>
        </div>
    </header>
    <section class="text-gray-400 bg-gray-900 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Contact Us</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Any Trouble or queries. Just <i>Contact Us!</i>
                </p>
            </div>
            <div class="lg:w-1/2 md:w-2/3 mx-auto" id="contactForm">
                <div class="flex flex-wrap -m-2">
                    <div class="p-2 w-1/2">
                        <div class="relative"><label for="name"
                                class="leading-7 text-sm text-gray-600">Name</label><input type="text" id="name"
                                name="name"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                    </div>
                    <div class="p-2 w-1/2">
                        <div class="relative"><label for="email"
                                class="leading-7 text-sm text-gray-600">Email</label><input type="email" id="email"
                                name="email"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative"><label for="message"
                                class="leading-7 text-sm text-gray-600">Message</label><textarea id="message"
                                name="message"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                        </div>
                    </div>
                    <div class="p-2 w-full"><button
                            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                            id="submitBtn">Button</button></div>
                    <div class="p-2 w-full pt-8 mt-8 border-t border-gray-200 text-center"><a
                            class="text-indigo-500">pbhs781317@gmail.com</a>
                        <p class="leading-normal my-5"><b>Village</b>-Bhulukadoba, <b>PO</b>-Bhulukadoba <br>Police
                            Station-Sorbhog<br>District-Barpeta, PIN-781317 </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>window.onload=function(e){eventlisten(document.querySelector("#submitBtn"),"click",(function(){let e=document.querySelector("#name").value,t=document.querySelector("#email").value,r=document.querySelector("#message").value;""==e||""==t||""==r?""==e?alert("Plz write the name!"):""==t?alert("Plz write the email!"):""==r&&alert("Plz write the message!"):httpGet("POST","./resources/requires/require.php",{type:"usercontact",name:e,email:t,message:r})}))};</script>
    <?php require_once('./resources/footer.php') ?>
