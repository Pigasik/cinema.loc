<div class="p-2 sm:px-15 bg-white border-b border-gray-200">

    <div class="mt-2 text-2xl">Database Statistics</div>
</div>

<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
    <div class="p-6">
        <div class="flex items-center">
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                <span class="text-xl font-bold text-blue-500">{{ $users->count() }}</span> Users in Database
            </div>
        </div>
    </div>

    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                <span class="text-xl font-bold text-blue-500">{{ $movies->count() }}</span> Movies in Database
            </div>
        </div>
    </div>

    <div class="p-6 border-t border-gray-200">
        <div class="flex items-center">
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                <span class="text-xl font-bold text-blue-500">{{ $series->count() }}</span> Series in Database
            </div>
        </div>
    </div>

    <div class="p-6 border-t border-gray-200 md:border-l">
        <div class="flex items-center">
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                <span class="text-xl font-bold text-blue-500"> {{ $casts->count() }}</span> Casts in Database
            </div>
        </div>
    </div>
</div>
</div>