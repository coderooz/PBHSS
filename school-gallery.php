<?php require_once('./resources/header.php')?>
  <section class="text-gray-400 bg-gray-900 body-font">
    <div class="container px-5 py-24 mx-auto flex flex-wrap">
      <div class="flex w-full mb-20 flex-wrap">
        <h1 class="sm:text-3xl text-2xl font-medium title-font text-white lg:w-1/3 lg:mb-0 mb-4">School Galery</h1>
        <p class="lg:pl-6 lg:w-2/3 mx-auto leading-relaxed text-base">Some captured moments with our dear students.</p>
        <div class="lg:w-3/3 bg-gray-800 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 resize-none leading-6 transition-colors duration-200 ease-in-out">
          <select name="" id="imageLimit">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
            <option value="25" selected>25</option>
            <option value="50">50</option>
          </select>
        </div>
      </div>
      <div class="flex flex-wrap md:-m-2 -m-1" id="GallaryImage"></div>
    </div>
  </section>
  <!-- <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6 ml-1" viewBox="0 0 24 24"><path d="M11 171-5-5m0 015-5m-5 5h12"></path></svg> -->
  <section class="text-gray-400 items-center bg-gray-900 body-font">
    <div class="flex space-x-1 container mx-auto flex flex-wrap" id="paginationzone">
      
      <!-- <a href="./school-gallery.html?page=1"
        class="rounded-md px-4 px-2 hover:text-white text-gray-700 bg-gray-500 hover:bg-gray-700">1</a>
      <a href="./school-gallery.html?page=2"
        class="rounded-md px-4 px-2 hover:text-white text-gray-700 bg-gray-500 hover:bg-gray-700">2</a>
      
      <a href="./school-gallery.html?page=200"
        class="rounded-md px-4 px-2 hover:text-white text-gray-700 bg-gray-500 hover:bg-gray-700">200</a> -->
      
    </div>
  </section>
  <!-- <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6 ml-1" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"></path></svg> -->
  <input type="hidden" id="imagelimt" value="0">
  <?php require_once('./resources/footer.php')?>
