<nav class="border-gray-200 px-2 sm:px-4 py-2.5 bg-gray-900">
    <div class="container flex flex-wrap items-center justify-between mx-auto">
        <a href="home.php" class="flex items-center">
            <img src="src/assets/img/LOGO.png" class="h-12 mr-3 sm:h-9" alt="Dywiki's Logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Dywiki's</span>
        </a>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto" id="mobile-menu-2">
            <ul class="flex flex-col p-4 border-gray-100 rounded-lg md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 dark:border-gray-700">
                <li>
                    <a href="./home.php" class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 max-md:border-b-[1px] max-md:border-t-[1px]" aria-current="page">Accueil</a>
                </li>
                <li>
                    <a href="#" class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 max-md:border-b-[1px]">À propos</a>
                </li>
                <li>
                    <a href="./profile_list.php" class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 max-md:border-b-[1px]">Profil</a>
                </li>
                <li>
                    <a href="./categorie.php" class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 max-md:border-b-[1px]">Categories</a>
                </li>
            </ul>
        </div>
        <form method="get" action="./search.php" class="search relative ml-auto mr-10 border-2 border-gray-400 rounded-full w-[180px] h-8">
            <input type="text" name="query" class="text-base text-gray-400 outline-none bg-transparent w-[100px] h-full absolute top-0 left-4">
            <button type="submit" class="w-[50px] h-full cursor-pointer rounded-full shadow-transparent float-right hover:bg-gray-400 duration-300 p-1">
                <svg class="w-full h-full hover:fill-gray-900 fill-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z"/></svg>
            </button>
        </form>
        <div class="flex items-center">
            <button type="button" class="flex mr-3 text-sm rounded-full md:mr-0 border-[1px] border-rose-50" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                <span class="sr-only">Profile menu</span>
                <img class="w-8 h-8 object-cover rounded-full" src="<?php echo $_SESSION['img']?>" alt="user photo">
            </button>
            <!-- Menu profile -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 absolute top-0 mt-16 right-0 max-md:mr-4 2xl:mr-6" id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white"><?php echo 'Bonjour ' .  $_SESSION['user_last_name'] . ' ' . $_SESSION['user_name'] . ' !'?></span>
                    <span class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400"><?php echo $_SESSION["user_email"]?></span>
                </div>
                <ul class="py-1" aria-labelledby="user-menu-button">
                    <li>
                        <a href="./user_profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Votre profil</a>
                    </li>
                    <li>
                        <a href="./album.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Vos albums</a>
                    </li>
                    <li>
                        <a href="src/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Déconnexion</a>
                    </li>
                </ul>
            </div>
            <button data-collapse-toggle="mobile-menu-2" id="btn-drop" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
    </div>
</nav>