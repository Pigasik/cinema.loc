<div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>

<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
<div class="flex items-center justify-center mt-8">
    <div class="flex items-center">
        <span class="text-white text-2xl mx-2 font-semibold">Personal Area</span>
    </div>
</div>

<nav class="mt-10">
    <a class="flex items-center mt-4 py-2 px-6 bg-gray-700 bg-opacity-25 text-gray-100" href="{{ route('admin.index') }}">
        <span class="mx-3">Menu</span>
    </a>
    <a class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="{{ route('admin.movies.index') }}">
        <span class="mx-3">Movies</span>
    </a>
    <a class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="{{ route('admin.series.index') }}">
        <span class="mx-3">Series</span>
    </a>
    <a class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="{{ route('admin.genres.index') }}">
        <span class="mx-3">Genres</span>
    </a>
    <a class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="{{ route('admin.casts.index') }}">
        <span class="mx-3">Casts</span>
    </a>
    <a class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="{{ route('admin.tags.index') }}">
        <span class="mx-3">Tags</span>
    </a>

</nav>
</div>
